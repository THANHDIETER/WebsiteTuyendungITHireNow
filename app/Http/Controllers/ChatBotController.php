<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatLimitLog;
use App\Models\AiConfig; // ✅ thêm dòng này

class ChatBotController extends Controller
{    
    protected $apiKey;

    public function chat(Request $request)
    {
        $message = $request->input('message');
        $user = Auth::user();
        $this->apiKey = AiConfig::getValue('ai_api_key');

        $userId = $user?->id;
        $sessionId = $user ? null : session()->getId();
        $role = $user->role ?? 'guest';

        $intent = null;
        $reply = null;

        if (!$user) {
            $sessionId = session()->getId();

            // Check nếu session đã bị giới hạn
            $isLimited = ChatLimitLog::where('session_id', $sessionId)->exists();

            if ($isLimited) {
                return response()->json([
                    'reply' => '🛑 Bạn đã dùng tối đa 10 lượt trò chuyện. Vui lòng <a href="/showLoginForm">đăng nhập</a> để tiếp tục.'
                ]);
            }

            $chatCount = ChatLog::where('session_id', $sessionId)->count();

            if ($chatCount >= 10) {
                ChatLimitLog::create([
                    'session_id' => $sessionId,
                    'limited_at' => now(),
                ]);

                return response()->json([
                    'reply' => '🛑 Bạn đã dùng tối đa 10 lượt trò chuyện. Vui lòng <a href="/showLoginForm">đăng nhập</a> để tiếp tục.'
                ]);
            }
        }
        // --- PHÂN LOẠI THEO ROLE ---
        if (in_array($role, ['job_seeker', 'guest', 'admin'])) {
            if (Str::contains(Str::lower($message), ['việc làm', 'công việc','tìm việc', 'tìm công việc', 'việc làm mới'])) {
                $intent = 'job_search';
                $jobs = Job::where('status', 'published')->latest()->take(10)->get();

                if ($jobs->count()) {
                    $reply = "Dưới đây là một số việc làm mới nhất:\n";
                    foreach ($jobs as $job) {
                        $location = $job->location->name ?? 'không rõ địa điểm';
                        $reply .= "- {$job->title} tại {$job->company->name} ({$location})\n";
                    }

                    ChatLog::create([
                        'user_id' => $userId,
                        'session_id' => $sessionId,
                        'message' => $message,
                        'reply' => $reply,
                        'intent' => $intent,
                        'role' => $role
                    ]);

                    return response()->json(['reply' => nl2br(e($reply))]);
                }
            }
        }

        if (in_array($role, ['employer', 'admin'])) {
            if (Str::contains(Str::lower($message), ['đăng tin', 'tuyển ứng viên',])) {
                $intent = 'recruiter_help';
                $reply = "Để đăng tin tuyển dụng:\n";
                $reply .= "1. Vào trang dành cho nhà tuyển dụng 
                -> quản lý tin tuyển dụng
                -> Đăng tin tuyển dụng 
                -> tạo tin tuyển dụng.\n";
                $reply .= "2. Điền đầy đủ thông tin việc làm.\n";
                $reply .= "3. Chọn gói dịch vụ (nếu có) và đăng tin.\n\n";
                $reply .= "Bạn cũng có thể xem hồ sơ ứng viên trong mục \"Quản lý ứng viên\".";

                ChatLog::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'message' => $message,
                    'reply' => $reply,
                    'intent' => $intent,
                    'role' => $role
                ]);

                return response()->json(['reply' => nl2br(e($reply))]);
            }
        }

        if (in_array($role, ['employer', 'admin'])) {
            if (Str::contains(Str::lower($message), ['mua gói', 'mua dịch vụ', 'gói dịch vụ', 'gói tuyển dụng'])) {
                $intent = 'package_purchase';
                $reply = "🎯 Hướng dẫn mua gói dịch vụ tuyển dụng:\n";
                $reply .= "1. Truy cập trang Nhà tuyển dụng.\n";
                $reply .= "2. Vào mục \"Mua gói dịch vụ\"\n";
                $reply .= "3. Chọn gói phù hợp với nhu cầu của bạn (ví dụ: Gói cơ bản, Gói nâng cao...).\n";
                $reply .= "4. Nhấn \"Mua ngay\" và thực hiện thanh toán theo hướng dẫn.\n";
                $reply .= "📌 Sau khi thanh toán thành công, bạn có thể sử dụng các quyền lợi của gói:\n";

                ChatLog::create([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'message' => $message,
                    'reply' => $reply,
                    'intent' => $intent,
                    'role' => $role
                ]);

                return response()->json(['reply' => nl2br(e($reply))]);
            }
        }


        // --- Gọi GPT ---
        $response = Http::withToken($this->apiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o',
                'messages' => [
                    ['role' => 'system', 'content' => 'Bạn là trợ lý tuyển dụng chuyên nghiệp. Hãy phản hồi bằng cùng ngôn ngữ với người dùng.'],
                    ['role' => 'user', 'content' => $message],
                ],
            ]);

        if ($response->failed()) {
            return response()->json(['reply' => 'Lỗi khi gọi OpenAI API: ' . $response->body()]);
        }

        $replyContent = $response['choices'][0]['message']['content'] ?? 'Không có phản hồi từ GPT.';

        ChatLog::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'message' => $message,
            'reply' => $replyContent,
            'role' => $role,
        ]);

        return response()->json(['reply' => nl2br(e($replyContent))]);
    }

    public function history()
    {
        $user = Auth::user();

        $userId = $user?->id;
        $sessionId = $user ? null : session()->getId();

        $logs = ChatLog::query()
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
            ->orderBy('created_at')
            ->get();

        return response()->json($logs);
    }
}
