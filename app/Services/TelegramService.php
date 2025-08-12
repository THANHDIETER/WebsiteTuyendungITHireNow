<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramService
{
    protected $botToken;
    protected $chatId;
    protected $client;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
        $this->client = new Client([
            'base_uri' => "https://api.telegram.org/bot{$this->botToken}/",
        ]);
    }

    public function sendMessage(string $message): bool
    {
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
