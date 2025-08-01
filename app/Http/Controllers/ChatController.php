<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Events\MessageSent;
use App\Events\TypingEvent;

class ChatController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::with(['userOne', 'userTwo', 'latestMessage'])
            ->where('user_one', $userId)
            ->orWhere('user_two', $userId)
            ->get()
            ->map(function ($conv) use ($userId) {
                $conv->unread_count = $conv->messages()
                    ->where('sender_id', '!=', $userId)
                    ->whereNull('read_at')
                    ->count();
                return $conv;
            });

        $totalUnread = $conversations->sum('unread_count');

        return view('chat.index', [
            'conversations' => $conversations,
            'userId' => $userId,
            'conversationId' => null,
            'totalUnread' => $totalUnread
        ]);
    }


    public function show($id)
    {
        $userId = Auth::id();

        $conversation = Conversation::with(['userOne', 'userTwo', 'messages'])->findOrFail($id);

        if ($conversation->user_one !== $userId && $conversation->user_two !== $userId) {
            return redirect()->route('chat.index')->with('error', 'Bạn không có quyền truy cập cuộc trò chuyện này.');
        }

        // Đánh dấu tin nhắn là đã đọc khi vào xem conversation
        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $chatWith = $conversation->user_one === $userId ? $conversation->userTwo : $conversation->userOne;
        $messages = $conversation->messages()->orderBy('created_at')->get();

        // Lấy danh sách conversation và số tin chưa đọc
        $conversations = Conversation::with(['userOne', 'userTwo'])
            ->where('user_one', $userId)
            ->orWhere('user_two', $userId)
            ->get()
            ->map(function ($conv) use ($userId) {
                $conv->unread_count = $conv->messages()
                    ->where('sender_id', '!=', $userId)
                    ->whereNull('read_at')
                    ->count();
                return $conv;
            });

        $totalUnread = $conversations->sum('unread_count');

        return view('chat.index', [
            'messages' => $messages,
            'chatWith' => $chatWith,
            'conversationId' => $conversation->id,
            'conversations' => $conversations,
            'totalUnread' => $totalUnread, // Gửi cho view để hiện badge ở header
        ]);
    }



    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $conversation = Conversation::findOrFail($id);
        $userId = Auth::id();

        if ($conversation->user_one !== $userId && $conversation->user_two !== $userId) {
            abort(403);
        }

        $msg = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($msg))->toOthers();

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->route('chat.show', $id);
    }


    public function start($userId)
    {
        $authId = Auth::id();

        if ($authId == $userId) {
            return redirect()->back()->with('error', 'Bạn không thể nhắn tin với chính mình.');
        }

        // Đảm bảo người dùng tồn tại
        $otherUser = User::findOrFail($userId);

        // Đảm bảo user_one < user_two để tránh trùng ngược
        $userOne = min($authId, $userId);
        $userTwo = max($authId, $userId);

        $conversation = Conversation::firstOrCreate(
            ['user_one' => $userOne, 'user_two' => $userTwo]
        );

        return redirect()->route('chat.show', $conversation->id);
    }

    public function typing(Request $request, $conversationId)
    {
        broadcast(new TypingEvent(
            $conversationId,
            auth()->id(),
            auth()->user()->name,
            auth()->user()->avatar ?? null
        ))->toOthers();

        return response()->json(['status' => 'ok']);
    }

}