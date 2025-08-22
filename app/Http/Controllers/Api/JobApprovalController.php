<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use App\Models\Setting;
use App\Models\AiConfig;
use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Jobs\SendTelegramMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Events\GlobalNotificationEvent;
use App\Notifications\Employer\JobApprovedNotification;
use App\Notifications\Employer\JobRejectedNotification;

class JobApprovalController extends Controller
{
    /**
     * Làm sạch text đầu vào
     */
    private function sanitizeText($raw): string
    {
        if (is_array($raw)) {
            $raw = json_encode($raw);
        }
        $text = strip_tags((string) $raw);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace(["\u{A0}", "\xc2\xa0"], ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    /**
     * Kiểm tra blacklist trong text
     */
    private function checkBlacklist(string $text, array $blacklist): ?string
    {
        foreach ($blacklist as $word) {
            if (stripos($text, $word) !== false) {
                return $word;
            }
        }
        return null;
    }

    public function sync(Request $request)
    {
        if ($request->query('token') !== Setting::getValue('token_cron')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $openAI = app(OpenAIService::class);

        // Lấy blacklist và ép về array string
        $blacklistRaw = json_decode(AiConfig::getValue('ai_blacklist', '[]'), true) ?: [];
        $blacklist = array_map(function ($item) {
            return is_array($item) && isset($item['value']) ? (string) $item['value'] : (string) $item;
        }, $blacklistRaw);
        $blacklist = array_filter($blacklist, fn($w) => trim($w) !== '');

        $aiPrompt = AiConfig::getValue('ai_prompt', "Tiêu đề: {{title}}\nMô tả: {{description}}\nYêu cầu: {{requirements}}\nQuyền lợi: {{benefits}}");

        $jobs = Job::where('status', 'pending')
            ->whereNull('ai_processed_at')
            ->orderBy('created_at', 'asc')
            ->limit(5)
            ->get();

        $approvedCount = 0;
        $rejectedCount = 0;

        foreach ($jobs as $job) {
            $fieldErrors = [];

            /** 1. Tiêu đề */
            $title = trim($job->title);
            if (empty($title)) {
                $fieldErrors[] = 'Tiêu đề tuyển dụng bị trống.';
            } elseif ($bad = $this->checkBlacklist($title, $blacklist)) {
                $fieldErrors[] = "Tiêu đề chứa từ không phù hợp: '{$bad}'.";
            }

            /** 2. Mô tả */
            $plainDescription = $this->sanitizeText($job->description);
            if (empty($plainDescription)) {
                $fieldErrors[] = 'Mô tả tuyển dụng bị trống hoặc không rõ ràng.';
            } elseif (mb_strlen($plainDescription) < 30) {
                $fieldErrors[] = 'Mô tả tuyển dụng quá ngắn, cần chi tiết hơn.';
            } elseif ($bad = $this->checkBlacklist($plainDescription, $blacklist)) {
                $fieldErrors[] = "Mô tả chứa từ không phù hợp: '{$bad}'.";
            }

            /** 3. Yêu cầu */
            $requirements = $this->sanitizeText($job->requirements);
            if (empty($requirements)) {
                $fieldErrors[] = 'Thiếu phần yêu cầu ứng viên (requirements).';
            } elseif (mb_strlen($requirements) < 30) {
                $fieldErrors[] = 'Phần yêu cầu ứng viên quá ngắn.';
            } elseif ($bad = $this->checkBlacklist($requirements, $blacklist)) {
                $fieldErrors[] = "Phần yêu cầu chứa từ không phù hợp: '{$bad}'.";
            }

            /** 4. Quyền lợi */
            $benefits = $this->sanitizeText($job->benefits);
            if (empty($benefits)) {
                $fieldErrors[] = 'Thiếu phần quyền lợi (benefits).';
            } elseif (mb_strlen($benefits) < 30) {
                $fieldErrors[] = 'Phần quyền lợi quá ngắn.';
            } elseif ($bad = $this->checkBlacklist($benefits, $blacklist)) {
                $fieldErrors[] = "Phần quyền lợi chứa từ không phù hợp: '{$bad}'.";
            }

            /** 5. Lương */
            if (!$job->salary_negotiable) {
                if (empty($job->salary_min) && empty($job->salary_max)) {
                    $fieldErrors[] = 'Mức lương chưa được cung cấp hoặc không có thông báo thương lượng.';
                } elseif (!empty($job->salary_min) && !empty($job->salary_max)) {
                    if ($job->salary_min > $job->salary_max) {
                        $fieldErrors[] = 'Mức lương tối thiểu không thể lớn hơn mức tối đa.';
                    }
                    if ($job->salary_min <= 0 || $job->salary_max <= 0) {
                        $fieldErrors[] = 'Mức lương phải là số dương.';
                    }
                }
            }

            /** 6. Các trường khác */
            if (empty($job->currency)) {
                $fieldErrors[] = 'Đơn vị tiền tệ chưa được chỉ định.';
            }
            if (empty($job->location_id) && empty($job->address) && empty($job->remote_policy_id)) {
                $fieldErrors[] = 'Chưa xác định địa điểm làm việc hoặc chính sách làm việc từ xa.';
            }
            
            if (empty($job->company_id)) {
                $fieldErrors[] = 'Công ty đăng tin không hợp lệ.';
            }
            if (empty($job->job_type_id)) {
                $fieldErrors[] = 'Loại công việc chưa được chỉ định.';
            }
            if (empty($job->level_id)) {
                $fieldErrors[] = 'Cấp bậc công việc chưa được chỉ định.';
            }
            if (empty($job->experience_id)) {
                $fieldErrors[] = 'Kinh nghiệm làm việc chưa được chỉ định.';
            }
            if (empty($job->language_id)) {
                $fieldErrors[] = 'Ngôn ngữ yêu cầu chưa được chỉ định.';
            }
            if ($job->status !== 'pending') {
                $fieldErrors[] = 'Tin tuyển dụng không ở trạng thái chờ duyệt.';
            }

            /** Nếu có lỗi thì reject ngay */
            if (!empty($fieldErrors)) {
                $job->status = 'rejected';
                $job->ai_processed_at = now();
                $job->save();

                $message = "⚠️ Bài tuyển dụng không được duyệt (lỗi dữ liệu):\n"
                    . "Tiêu đề: <b>{$job->title}</b>\n"
                    . "Công ty ID: {$job->company_id}\n"
                    . "Tin ID: {$job->id}\n"
                    . "Lý do: " . implode(' | ', $fieldErrors);
                    
                $employer = $job->company->user;
                $employer->notify(new JobRejectedNotification($job));
                try {
                    SendTelegramMessage::dispatch($message);
                } catch (\Exception $e) {
                    Log::error('Gửi Telegram thất bại: ' . $e->getMessage());
                }

                $rejectedCount++;
                continue;
            }

            /** Gọi AI đánh giá tổng thể */
            $fullContent = str_replace(
                [
                    '{{title}}',
                    '{{description}}',
                    '{{requirements}}',
                    '{{benefits}}',
                    '{{salary_min}}',
                    '{{salary_max}}',
                    '{{currency}}',
                    '{{job_type}}',
                    '{{experience}}',
                    '{{jobLanguage}}',
                ],
                [
                    $job->title,
                    $plainDescription,
                    $requirements,
                    $benefits,
                    $job->salary_min,
                    $job->salary_max,
                    $job->currency,
                    $job->jobType->name,
                    $job->experience->name,
                    $job->jobLanguage->name,
                ],
                $aiPrompt
            );

            $result = $openAI->analyzeJobDescription($fullContent);

            if ($result['ok']) {
                $job->status = 'published';
                $job->approved_by = 0;
                $job->ai_processed_at = now();
                $job->save();

                $message = "✅ Bài tuyển dụng đã được duyệt tự động:\n"
                    . "Tiêu đề: <b>{$job->title}</b>\n"
                    . "Công ty ID: {$job->company_id}\n"
                    . "Tin ID: {$job->id}";

                try {
                    SendTelegramMessage::dispatch($message);
                } catch (\Exception $e) {
                    Log::error('Gửi Telegram thất bại: ' . $e->getMessage());
                }
                $employer = $job->company->user;
                $employer->notify(new JobApprovedNotification($job));
                // event(new GlobalNotificationEvent("Tin tuyển dụng '{$job->title}' đã được duyệt!"));
                // return $employer;
                $approvedCount++;
            } else {
                $job->status = 'pending'; // đã sửa lại cho đúng
                $job->ai_processed_at = now();
                $job->save();

                $message = "⚠️ Bài tuyển dụng không được duyệt (AI đánh giá):\n"
                    . "Tiêu đề: <b>{$job->title}</b>\n"
                    . "Công ty ID: {$job->company_id}\n"
                    . "Tin ID: {$job->id}\n"
                    . "Lý do: {$result['reason']}";

                $employer = $job->company->user;
                $employer->notify(new JobRejectedNotification($job));
                try {
                    SendTelegramMessage::dispatch($message);
                } catch (\Exception $e) {
                    Log::error('Gửi Telegram thất bại: ' . $e->getMessage());
                }

                $rejectedCount++;
            }
        }

        return response()->json([
            'message'  => 'Hoàn thành xử lý tin tuyển dụng',
            'approved' => $approvedCount,
            'rejected' => $rejectedCount,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
