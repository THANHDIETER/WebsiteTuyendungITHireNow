<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\AiConfig; // ✅ thêm dòng này

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $model;

    public function __construct()
    {
        // Lấy API key và model từ AiConfig
        $this->apiKey = AiConfig::getValue('ai_api_key');
        $this->model = AiConfig::getValue('ai_model');

        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function analyzeJobDescription(string $description): array
    {
        $prompt = "Bạn hãy đánh giá nội dung tuyển dụng dưới đây xem có hợp lệ để đăng không. Nếu không hợp lệ, hãy cho biết lý do ngắn gọn. Nếu hợp lệ trả lời 'OK'. Nội dung:\n\n" . $description;
        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => $this->model,
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
            $lowerContent = strtolower($content);

            if (str_contains($lowerContent, 'hợp lệ') || str_contains($lowerContent, 'ok') || str_contains($lowerContent, 'đồng ý')) {
                return ['ok' => true, 'reason' => null];
            }

            return ['ok' => false, 'reason' => $content];

        } catch (\Exception $e) {
            return ['ok' => false, 'reason' => 'Lỗi khi gọi API AI: ' . $e->getMessage()];
        }
    }
}
