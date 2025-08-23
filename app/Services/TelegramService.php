<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Setting;

class TelegramService implements ShouldQueue
{
    protected $botToken;
    protected $chatId;
    protected $client;

    public function __construct()
    {
        // 👉 Lấy từ DB qua model Setting
        $this->botToken = Setting::where('key', 'telegram_bot_token')->value('value');
        $this->chatId   = Setting::where('key', 'telegram_chat_id')->value('value');

        $this->client = new Client([
            'base_uri' => "https://api.telegram.org/bot{$this->botToken}/",
        ]);
    }

    public function sendMessage(string $message): bool
    {
        if (!$this->botToken || !$this->chatId) {
            return false;
        }

        $response = $this->client->post('sendMessage', [
            'json' => [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ],
        ]);

        return $response->getStatusCode() === 200;
    }
}
