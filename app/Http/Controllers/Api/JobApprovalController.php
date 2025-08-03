<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Services\OpenAIService;
use App\Services\TelegramService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class JobApprovalController extends Controller
{
    public function sync(Request $request)
    {
        if ($request->query('token') !== config('app.payment_check_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $openAI = app(OpenAIService::class);
        $telegram = app(TelegramService::class);

        $blacklist = [
            'đm',
            'con chó',
            'loại từ tục tĩu khác',
            'bậy bạ',
            'spam',
            'xxx',
        ];

        $jobs = Job::where('status', 'pending')
            ->whereNull('ai_processed_at')
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();

        $approvedCount = 0;
        $rejectedCount = 0;

        foreach ($jobs as $job) {
            $fieldErrors = [];

            // 1. Kiểm tra tiêu đề
            $title = trim($job->title);
            if (empty($title)) {
                $fieldErrors[] = 'Tiêu đề tuyển dụng bị trống.';
            } else {
                foreach ($blacklist as $badWord) {
                    if (stripos($title, $badWord) !== false) {
                        $fieldErrors[] = "Tiêu đề chứa từ không phù hợp: '{$badWord}'.";
                        break;
                    }
                }
            }

            // 2. Kiểm tra mô tả
            $descriptionRaw = $job->description;
            if (is_array($descriptionRaw)) {
                $descriptionRaw = json_encode($descriptionRaw);
            }

            $plainDescription = strip_tags((string) $descriptionRaw);
            $plainDescription = html_entity_decode($plainDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $plainDescription = str_replace(["\u{A0}", "\xc2\xa0"], ' ', $plainDescription);
            $plainDescription = preg_replace('/\s+/', ' ', $plainDescription);
            $plainDescription = trim($plainDescription);

            if (empty($plainDescription)) {
                $fieldErrors[] = 'Mô tả tuyển dụng bị trống hoặc không rõ ràng.';
            } elseif (mb_strlen($plainDescription) < 30) {
                $fieldErrors[] = 'Mô tả tuyển dụng quá ngắn, cần chi tiết hơn.';
            } else {
                foreach ($blacklist as $badWord) {
                    if (stripos($plainDescription, $badWord) !== false) {
                        $fieldErrors[] = "Mô tả chứa từ không phù hợp: '{$badWord}'.";
                        break;
                    }
                }
            }

            // 3. Kiểm tra yêu cầu (requirements)
            $requirementsRaw = $job->requirements;
            if (is_array($requirementsRaw)) {
                $requirementsRaw = json_encode($requirementsRaw);
            }
            $requirements = strip_tags((string) $requirementsRaw);
            $requirements = html_entity_decode($requirements, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $requirements = str_replace(["\u{A0}", "\xc2\xa0"], ' ', $requirements);
            $requirements = preg_replace('/\s+/', ' ', $requirements);
            $requirements = trim($requirements);

            if (empty($requirements)) {
                $fieldErrors[] = 'Thiếu phần yêu cầu ứng viên (requirements).';
            } elseif (mb_strlen($requirements) < 30) {
                $fieldErrors[] = 'Phần yêu cầu ứng viên quá ngắn.';
            }

            // 4. Kiểm tra quyền lợi (benefits)
            $benefitsRaw = $job->benefits;
            if (is_array($benefitsRaw)) {
                $benefitsRaw = json_encode($benefitsRaw);
            }
            $benefits = strip_tags((string) $benefitsRaw);
            $benefits = html_entity_decode($benefits, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $benefits = str_replace(["\u{A0}", "\xc2\xa0"], ' ', $benefits);
            $benefits = preg_replace('/\s+/', ' ', $benefits);
            $benefits = trim($benefits);

            if (empty($benefits)) {
                $fieldErrors[] = 'Thiếu phần quyền lợi (benefits).';
            } elseif (mb_strlen($benefits) < 30) {
                $fieldErrors[] = 'Phần quyền lợi quá ngắn.';
            }

            // 5. Lương
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

            if (empty($job->currency)) {
                $fieldErrors[] = 'Đơn vị tiền tệ chưa được chỉ định.';
            }

            if (empty($job->location_id) && empty($job->address) && empty($job->remote_policy_id)) {
                $fieldErrors[] = 'Chưa xác định địa điểm làm việc hoặc chính sách làm việc từ xa.';
            }

            if (empty($job->deadline)) {
                $fieldErrors[] = 'Hạn nộp hồ sơ chưa được cung cấp.';
            } else {
                $deadlineTimestamp = strtotime($job->deadline);
                $now = time();
                if ($deadlineTimestamp < $now) {
                    $fieldErrors[] = 'Hạn nộp hồ sơ đã hết hạn.';
                }
                if ($deadlineTimestamp > strtotime('+1 year', $now)) {
                    $fieldErrors[] = 'Hạn nộp hồ sơ không được vượt quá 1 năm.';
                }
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

            // Nếu có lỗi dữ liệu thì reject ngay
            if (!empty($fieldErrors)) {
                $job->status = 'rejected';
                $job->ai_processed_at = now();
                $job->save();

                $message = "⚠️ Bài tuyển dụng không được duyệt (lỗi dữ liệu):\n"
                    . "Tiêu đề: <b>{$job->title}</b>\n"
                    . "Công ty ID: {$job->company_id}\n"
                    . "Tin ID: {$job->id}\n"
                    . "Lý do: " . implode(' | ', $fieldErrors);

                try {
                    $telegram->sendMessage($message);
                } catch (\Exception $e) {
                    Log::error('Gửi Telegram thất bại: ' . $e->getMessage());
                }

                $rejectedCount++;
                continue;
            }

            // Gọi AI đánh giá tổng thể tiêu đề + mô tả + yêu cầu + quyền lợi
            $fullContent = "Tiêu đề: {$job->title}\nMô tả: {$plainDescription}\nYêu cầu: {$requirements}\nQuyền lợi: {$benefits}";
            // dd($fullContent);
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
                    $telegram->sendMessage($message);
                } catch (\Exception $e) {
                    Log::error('Gửi Telegram thất bại: ' . $e->getMessage());
                }

                $approvedCount++;
            } else {
                $job->status = 'pending';  // sửa lại từ 'pending' thành 'rejected'
                // $job->ai_processed_at = now();
                $job->save();

                $message = "⚠️ Bài tuyển dụng không được duyệt (AI đánh giá):\n"
                    . "Tiêu đề: <b>{$job->title}</b>\n"
                    . "Công ty ID: {$job->company_id}\n"
                    . "Tin ID: {$job->id}\n"
                    . "Lý do: {$result['reason']}";

                try {
                    $telegram->sendMessage($message);
                } catch (\Exception $e) {
                    Log::error('Gửi Telegram thất bại: ' . $e->getMessage());
                }

                $rejectedCount++;
            }
        }

        return response()->json([
            'message' => 'Hoàn thành xử lý tin tuyển dụng',
            'approved' => $approvedCount,
            'rejected' => $rejectedCount,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
