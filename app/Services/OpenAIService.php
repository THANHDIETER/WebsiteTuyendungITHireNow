<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Gửi nội dung mô tả tuyển dụng cho AI đánh giá
     * Trả về true nếu AI đánh giá phù hợp, false nếu không phù hợp
     */
    public function analyzeJobDescription(string $description): array
    {
        $prompt = "Bạn hãy đánh giá nội dung mô tả tuyển dụng dưới đây xem có hợp lệ để đăng không. Nếu không hợp lệ, hãy cho biết lý do ngắn gọn. Nếu hợp lệ trả lời 'OK'. Nội dung:\n\n" . $description;

        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'max_tokens' => 100,
                    'temperature' => 0,
                ]
            ]);

            $body = json_decode($response->getBody(), true);

            if (!isset($body['choices'][0]['message']['content'])) {
                return ['ok' => false, 'reason' => 'Không nhận được phản hồi từ AI.'];
            }

            $content = trim($body['choices'][0]['message']['content']);

            if (strtolower($content) === 'ok') {
                return ['ok' => true, 'reason' => null];
            }

            return ['ok' => false, 'reason' => $content];

        } catch (\Exception $e) {
            // Log lỗi hoặc xử lý tùy bạn
            return ['ok' => false, 'reason' => 'Lỗi khi gọi API AI: ' . $e->getMessage()];
        }
    }

}
