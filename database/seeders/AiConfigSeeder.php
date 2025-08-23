<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AiConfig;

class AiConfigSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            [
                'key'   => 'ai_blacklist',
                'name'  => 'Blacklist từ cấm',
                'value' => json_encode([
                    'dm','đm','vl','cl','cc','dcm','lồn','cặc','buồi','đụ','địt',
                    'fuck','shit','sex','xxx','jav','porn','18+','nude','clip nóng','đồi trụy',
                    'spam','lừa đảo','đa cấp','cờ bạc','casino','bet','bóng đá','nổ hũ','xóc đĩa',
                    'zalo','telegram','viber','whatsapp','facebook','link fb','inbox','call','phone','sdt','liên hệ'
                ], JSON_UNESCAPED_UNICODE)
            ],
            [
                'key'   => 'ai_prompt',
                'name'  => 'Prompt AI',
                'value' => "Tiêu đề: {{title}}\nMô tả: {{description}}\nYêu cầu: {{requirements}}\nQuyền lợi: {{benefits}}\nLương: {{salary_min}} - {{salary_max}} {{currency}}\nLoại công việc: {{job_type}}\nKinh nghiệm: {{experience}}\nNgôn ngữ: {{jobLanguage}}"
            ],
            [
                'key'   => 'ai_model',
                'name'  => 'Model AI',
                'value' => 'gpt-4o-mini'
            ],
            [
                'key'   => 'ai_api_key',
                'name'  => 'API Key',
                'value' => ''
            ],
        ];

        foreach ($configs as $cfg) {
            AiConfig::updateOrCreate(['key' => $cfg['key']], $cfg);
        }
    }
}
