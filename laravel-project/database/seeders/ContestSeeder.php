<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Contest;
use Carbon\Carbon;

class ContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'name_en' => 'April 2000KM Walking Challenge',
                'name_ja' => '4月2000kmウォーキングチャレンジ',
                'name_vi' => 'Thử thách đi bộ 2000KM tháng 4',
                'name_zh' => '四月2000公里步行挑战',
                'desc_en' => 'Walk 2000 km in April and challenge your limits.',
                'desc_ja' => '4月に2000km歩いて限界に挑戦しましょう。',
                'desc_vi' => 'Đi bộ 2000 km trong tháng 4 để thử thách giới hạn.',
                'desc_zh' => '在四月挑战2000公里步行极限。',
                'target' => 2000,
            ],
            [
                'name_en' => 'Spring 1000KM Walking Challenge',
                'name_ja' => '春の1000KMウォーキングチャレンジ',
                'name_vi' => 'Thử thách đi bộ 1000KM mùa xuân',
                'name_zh' => '春季1000公里步行挑战',
                'desc_en' => 'Walk a total of 1000 km during the spring season and stay active while enjoying the fresh air.',
                'desc_ja' => '春の期間中に合計1000km歩いて、健康的な生活を楽しみましょう。',
                'desc_vi' => 'Hoàn thành 1000 km đi bộ trong mùa xuân và tận hưởng không khí trong lành.',
                'desc_zh' => '在春季期间完成1000公里步行，保持健康并享受户外活动。',
                'target' => 1000,
            ],
            [
                'name_en' => 'Weekend Step Challenge',
                'name_ja' => '週末ステップチャレンジ',
                'name_vi' => 'Thử thách bước chân cuối tuần',
                'name_zh' => '周末步数挑战',
                'desc_en' => 'Walk 10,000 steps this weekend and boost your energy with a fun walking goal.',
                'desc_ja' => '週末に10,000歩を達成して、アクティブな週末を過ごしましょう。',
                'desc_vi' => 'Hoàn thành 10.000 bước đi trong cuối tuần để duy trì năng lượng và sức khỏe.',
                'desc_zh' => '在周末完成10,000步，让你的周末更加健康和充满活力。',
                'target' => 10000,
            ],
            [
                'name_en' => 'Summer Fitness Walk',
                'name_ja' => '夏のフィットネスウォーク',
                'name_vi' => 'Đi bộ khỏe mạnh mùa hè',
                'name_zh' => '夏季健身步行挑战',
                'desc_en' => 'Walk 150 km during summer and maintain an active and healthy lifestyle.',
                'desc_ja' => '夏の間に150km歩いて、健康的なライフスタイルを維持しましょう。',
                'desc_vi' => 'Đi bộ 150 km trong mùa hè để duy trì lối sống năng động và khỏe mạnh.',
                'desc_zh' => '在夏季完成150公里步行，保持活力与健康。',
                'target' => 150,
            ],
            [
                'name_en' => 'Global 500KM Team Walk',
                'name_ja' => 'グローバル500KMチームウォーク',
                'name_vi' => 'Thử thách đội nhóm 500KM',
                'name_zh' => '全球500公里团队步行挑战',
                'desc_en' => 'Work together with other participants to reach a total of 500 km as a team.',
                'desc_ja' => 'チームで協力して合計500kmを達成しましょう。',
                'desc_vi' => 'Cùng đồng đội chinh phục mục tiêu 500 km và xây dựng tinh thần đồng đội.',
                'desc_zh' => '与团队成员一起完成500公里的共同目标。',
                'target' => 500,
            ]
        ];

        for ($i = 0; $i < 25; $i++) {
            $template = $templates[$i % count($templates)];

            // To make names unique just append the phase
            $phase = ceil(($i + 1) / count($templates));
            if ($phase > 1) {
                $template['name_en'] .= ' Phase ' . $phase;
                $template['name_ja'] .= ' フェーズ ' . $phase;
                $template['name_vi'] .= ' Giai đoạn ' . $phase;
                $template['name_zh'] .= ' 阶段 ' . $phase;
            }

            // Generate start dates strictly in March 2026
            $startDate = Carbon::create(2026, 3, rand(1, 31), rand(8, 10), rand(0, 59), rand(0, 59));
            
            // Generate end dates strictly in April 2026
            $endDate = Carbon::create(2026, 4, rand(1, 30), rand(15, 23), rand(0, 59), rand(0, 59));
            
            $calculateAt = $endDate->copy()->addDays(1);

            $idPrefix = Str::uuid()->toString();
            
            Contest::create([
                'id' => $idPrefix,
                'name_ja' => $template['name_ja'],
                'name_en' => $template['name_en'],
                'name_vi' => $template['name_vi'],
                'name_zh' => $template['name_zh'],
                'desc_ja' => $template['desc_ja'],
                'desc_en' => $template['desc_en'],
                'desc_vi' => $template['desc_vi'],
                'desc_zh' => $template['desc_zh'],
                'type' => 1,
                'image_url' => '/storage/contests/' . $idPrefix . '/' . time() . '.jpg',
                'start_date' => $startDate->format('Y-m-d H:i:s'),
                'end_date' => $endDate->format('Y-m-d H:i:s'),
                'calculate_at' => $calculateAt->format('Y-m-d H:i:s'),
                'target' => $template['target'],
                'reward_points' => rand(5, 20) * 100, // 500 to 2000 points
                'status' => 1,
            ]);
        }
    }
}
