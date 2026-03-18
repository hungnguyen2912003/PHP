-- Adminer 5.4.2 MySQL 8.0.45 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-user_contest_steps:019ce0b3-6564-71eb-805c-185c74364725:019ce0b4-5a6c-72a5-b0d8-9cc0eea459e9',	's:4:\"5280\";',	1773383486),
('laravel-cache-user_contest_steps:019ce0b3-6564-71eb-805c-185c74364725:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:1050;',	1773883280),
('laravel-cache-user_contest_steps:019ce0b3-6564-71eb-805c-185c74364725:019cfaef-0347-73bf-982d-27475be01398',	'i:2600;',	1773826008),
('laravel-cache-user_contest_steps:019ce0b3-6639-7234-a4cc-c891e2cf6b77:019ce0b4-5a6c-72a5-b0d8-9cc0eea459e9',	'i:750;',	1773390076),
('laravel-cache-user_contest_steps:019ce0b3-6639-7234-a4cc-c891e2cf6b77:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:1050;',	1773884248),
('laravel-cache-user_contest_steps:019ce0b3-6639-7234-a4cc-c891e2cf6b77:019cfaef-0347-73bf-982d-27475be01398',	'i:1500;',	1773826161),
('laravel-cache-user_contest_steps:019ce0b3-6711-712c-8a67-4a09458f9621:019ce0b4-5a6c-72a5-b0d8-9cc0eea459e9',	'i:1210;',	1773390149),
('laravel-cache-user_contest_steps:019ce0b3-6711-712c-8a67-4a09458f9621:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:1050;',	1773884318),
('laravel-cache-user_contest_steps:019ce0b3-6711-712c-8a67-4a09458f9621:019cfaef-0347-73bf-982d-27475be01398',	'i:1500;',	1773826292),
('laravel-cache-user_contest_steps:019ce0b3-67ea-7002-9b76-c11162d87781:019ce0b4-5a6c-72a5-b0d8-9cc0eea459e9',	'i:4200;',	1773390296),
('laravel-cache-user_contest_steps:019ce0b3-67ea-7002-9b76-c11162d87781:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:1900;',	1773884703),
('laravel-cache-user_contest_steps:019ce0b3-67ea-7002-9b76-c11162d87781:019cfaef-0347-73bf-982d-27475be01398',	'i:1500;',	1773826392),
('laravel-cache-user_contest_steps:019ce0b3-68c2-720e-8300-0d519283e43e:019ce0b4-5a6c-72a5-b0d8-9cc0eea459e9',	'i:3100;',	1773390403),
('laravel-cache-user_contest_steps:019ce0b3-68c2-720e-8300-0d519283e43e:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:1930;',	1773884774),
('laravel-cache-user_contest_steps:019ce0b3-68c2-720e-8300-0d519283e43e:019cfaef-0347-73bf-982d-27475be01398',	'i:1400;',	1773826506),
('laravel-cache-user_contest_steps:019ce0b3-6998-72d3-b835-16dc12b320cd:019ce0b4-5a6c-72a5-b0d8-9cc0eea459e9',	'i:3640;',	1773807877),
('laravel-cache-user_contest_steps:019ce0b3-6998-72d3-b835-16dc12b320cd:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:1720;',	1773887292),
('laravel-cache-user_contest_steps:019ce0b3-6998-72d3-b835-16dc12b320cd:019cfaef-0347-73bf-982d-27475be01398',	'i:1000;',	1773826540),
('laravel-cache-user_contest_steps:019ce0b3-6a72-7344-b6d3-26ceaa69a0ea:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:640;',	1773887641),
('laravel-cache-user_contest_steps:019ce0b3-6a72-7344-b6d3-26ceaa69a0ea:019cfaef-0347-73bf-982d-27475be01398',	'i:600;',	1773826572),
('laravel-cache-user_contest_steps:019ce0b3-6b7e-725d-8970-18e4513c148e:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:550;',	1773887740),
('laravel-cache-user_contest_steps:019ce0b3-6b7e-725d-8970-18e4513c148e:019cfaef-0347-73bf-982d-27475be01398',	'i:1800;',	1773826671),
('laravel-cache-user_contest_steps:019ce0b3-6c78-7343-aab9-76e9987bc921:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:440;',	1773887817),
('laravel-cache-user_contest_steps:019ce0b3-6c78-7343-aab9-76e9987bc921:019cfaef-0347-73bf-982d-27475be01398',	'i:1100;',	1773826753),
('laravel-cache-user_contest_steps:019ce0b3-6d4a-7270-a72c-0db420c35439:019ce160-6b44-7326-9bb7-1eef7aeffe81',	'i:950;',	1773890834),
('laravel-cache-user_contest_steps:019ce0b3-6d4a-7270-a72c-0db420c35439:019cfaef-0347-73bf-982d-27475be01398',	'i:3750;',	1773826854);

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `contest_reward_settings`;
CREATE TABLE `contest_reward_settings` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contest_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rank` int NOT NULL,
  `reward_percent` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contest_rewards_contest_id_rank_unique` (`contest_id`,`rank`),
  CONSTRAINT `contest_rewards_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contest_reward_settings` (`id`, `contest_id`, `rank`, `reward_percent`, `created_at`, `updated_at`) VALUES
('019cfe7e-e0c7-70ed-b68b-f6a799c8dc48',	'01d92661-daa9-4c25-91a3-8466ca482fad',	1,	100,	'2026-03-18 08:10:53',	'2026-03-18 08:10:53'),
('019cfe7e-e0cb-71eb-ab90-61ef132bd100',	'01d92661-daa9-4c25-91a3-8466ca482fad',	2,	80,	'2026-03-18 08:10:53',	'2026-03-18 08:10:53'),
('019cfe7e-e0ce-72d0-82e5-5fc9b1a01b0e',	'01d92661-daa9-4c25-91a3-8466ca482fad',	3,	70,	'2026-03-18 08:10:53',	'2026-03-18 08:10:53'),
('019cfe7f-2344-7113-9f67-868c0916f6df',	'1192002e-860d-41de-a553-1b94c099297f',	1,	100,	'2026-03-18 08:11:10',	'2026-03-18 08:11:10'),
('019cfe7f-2347-7280-9d58-842241d3eff2',	'1192002e-860d-41de-a553-1b94c099297f',	2,	70,	'2026-03-18 08:11:10',	'2026-03-18 08:11:10'),
('019cfe7f-234a-72a0-b3f4-e2355a8fc94f',	'1192002e-860d-41de-a553-1b94c099297f',	3,	50,	'2026-03-18 08:11:10',	'2026-03-18 08:11:10'),
('019cfe7f-6d8c-724e-9d2c-e92814e470e3',	'17970212-3f5c-4c69-91ef-c4235d243f65',	1,	100,	'2026-03-18 08:11:29',	'2026-03-18 08:11:29'),
('019cfe7f-6d90-725b-a295-20eabb09598f',	'17970212-3f5c-4c69-91ef-c4235d243f65',	2,	80,	'2026-03-18 08:11:29',	'2026-03-18 08:11:29'),
('019cfe7f-6d92-70da-a8a2-df69e5d6c508',	'17970212-3f5c-4c69-91ef-c4235d243f65',	3,	50,	'2026-03-18 08:11:29',	'2026-03-18 08:11:29'),
('019cfe7f-a713-7016-8f8c-a878fcfaeede',	'191c14de-0b40-4e42-a49d-35fd73370d22',	1,	100,	'2026-03-18 08:11:44',	'2026-03-18 08:11:44'),
('019cfe7f-a717-719b-8116-24c421ca21ec',	'191c14de-0b40-4e42-a49d-35fd73370d22',	2,	70,	'2026-03-18 08:11:44',	'2026-03-18 08:11:44'),
('019cfe7f-a71a-737b-aff8-220ea010ee4a',	'191c14de-0b40-4e42-a49d-35fd73370d22',	3,	60,	'2026-03-18 08:11:44',	'2026-03-18 08:11:44'),
('019cfe7f-d4f7-7015-8089-56c8240aff41',	'1c299470-02d7-427c-a70d-710b915a597c',	1,	100,	'2026-03-18 08:11:56',	'2026-03-18 08:11:56'),
('019cfe7f-d4fc-71f4-a3a6-fe9169628650',	'1c299470-02d7-427c-a70d-710b915a597c',	2,	90,	'2026-03-18 08:11:56',	'2026-03-18 08:11:56'),
('019cfe7f-d501-71f1-86e3-76d9fec1b988',	'1c299470-02d7-427c-a70d-710b915a597c',	3,	80,	'2026-03-18 08:11:56',	'2026-03-18 08:11:56'),
('019cfe80-66e7-7005-ad74-7e9c2b8ce612',	'37911f10-7192-4c30-89eb-fcf971427da4',	1,	100,	'2026-03-18 08:12:33',	'2026-03-18 08:12:33'),
('019cfe80-66ea-73a1-95af-4b551bc11316',	'37911f10-7192-4c30-89eb-fcf971427da4',	2,	80,	'2026-03-18 08:12:33',	'2026-03-18 08:12:33'),
('019cfe80-66ee-733b-9195-5b159dec6201',	'37911f10-7192-4c30-89eb-fcf971427da4',	3,	70,	'2026-03-18 08:12:33',	'2026-03-18 08:12:33'),
('019cfe82-bc5f-7210-8518-67eab0115672',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	1,	100,	'2026-03-18 08:15:06',	'2026-03-18 08:15:06'),
('019cfe82-bc64-7123-bdcd-be6d351e485d',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	2,	80,	'2026-03-18 08:15:06',	'2026-03-18 08:15:06'),
('019cfe82-bc66-7137-bafd-204a08bcd9b7',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	3,	60,	'2026-03-18 08:15:06',	'2026-03-18 08:15:06'),
('019cff0c-6d30-7155-999f-51bdce0815ae',	'019ce162-3bd6-71ef-88b4-6c18305af5aa',	1,	100,	'2026-03-18 10:45:30',	'2026-03-18 10:45:30'),
('019cff0c-6d34-717f-bf1f-826d5e7b3577',	'019ce162-3bd6-71ef-88b4-6c18305af5aa',	2,	70,	'2026-03-18 10:45:30',	'2026-03-18 10:45:30'),
('019cff0c-6d37-70e3-90e3-6b0d8a778286',	'019ce162-3bd6-71ef-88b4-6c18305af5aa',	3,	50,	'2026-03-18 10:45:30',	'2026-03-18 10:45:30'),
('019d0054-1f02-703a-bb27-a605722ba0c6',	'019d0054-1eec-7107-aac4-b05ef5e13409',	1,	100,	'2026-03-18 16:43:26',	'2026-03-18 16:43:26'),
('019d0054-1f06-72c0-a255-dcef5bb92324',	'019d0054-1eec-7107-aac4-b05ef5e13409',	2,	80,	'2026-03-18 16:43:26',	'2026-03-18 16:43:26'),
('019d0054-1f0a-7107-bc26-412cc042826d',	'019d0054-1eec-7107-aac4-b05ef5e13409',	3,	60,	'2026-03-18 16:43:26',	'2026-03-18 16:43:26'),
('019d0054-1f0d-7074-a4c0-202b1637484a',	'019d0054-1eec-7107-aac4-b05ef5e13409',	4,	40,	'2026-03-18 16:43:26',	'2026-03-18 16:43:26'),
('019d005c-a5f7-722e-a404-9739a8702786',	'019d005a-bdf3-7216-b6d9-4b0c1c5ed6af',	1,	100,	'2026-03-18 16:52:45',	'2026-03-18 16:52:45'),
('019d005c-a5fc-73e9-ad92-b54e5c5de53b',	'019d005a-bdf3-7216-b6d9-4b0c1c5ed6af',	2,	70,	'2026-03-18 16:52:45',	'2026-03-18 16:52:45'),
('019d005c-a600-7224-977b-1eb1e4f87cd9',	'019d005a-bdf3-7216-b6d9-4b0c1c5ed6af',	3,	50,	'2026-03-18 16:52:45',	'2026-03-18 16:52:45');

DROP TABLE IF EXISTS `contests`;
CREATE TABLE `contests` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_vi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_zh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_ja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_vi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc_zh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1: walking, 2: running, 3: sprint',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  `calculate_at` timestamp NOT NULL,
  `target` int NOT NULL DEFAULT '1',
  `reward_points` int NOT NULL DEFAULT '0',
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1: inprogress, 2: completed, 3: finalized',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contests` (`id`, `name_ja`, `name_en`, `name_vi`, `name_zh`, `desc_ja`, `desc_en`, `desc_vi`, `desc_zh`, `type`, `image_url`, `start_date`, `end_date`, `calculate_at`, `target`, `reward_points`, `status`, `created_at`, `updated_at`) VALUES
('019ce160-6b44-7326-9bb7-1eef7aeffe81',	'春の1000KMウォーキングチャレンジ',	'Spring 1000KM Walking Challenge',	'Thử thách đi bộ 1000KM mùa xuân',	'春季1000公里步行挑战',	'春の期間中に合計1000km歩いて、健康的な生活を楽しみましょう。',	'Walk a total of 1000 km during the spring season and stay active while enjoying the fresh air.',	'Hoàn thành 1000 km đi bộ trong mùa xuân và tận hưởng không khí trong lành.',	'在春季期间完成1000公里步行，保持健康并享受户外活动。',	1,	'/storage/contests/019ce160-6b44-7326-9bb7-1eef7aeffe81/1773307718.jpg',	'2026-03-12 00:00:00',	'2026-03-20 00:00:00',	'2026-03-21 00:00:00',	1000,	500,	1,	'2026-03-12 16:28:38',	'2026-03-12 16:28:38'),
('019ce162-3bd6-71ef-88b4-6c18305af5aa',	'週末ステップチャレンジ',	'Weekend Step Challenge',	'Thử thách bước chân cuối tuần',	'周末步数挑战',	'週末に10,000歩を達成して、アクティブな週末を過ごしましょう。',	'Walk 10,000 steps this weekend and boost your energy with a fun walking goal.',	'Hoàn thành 10.000 bước đi trong cuối tuần để duy trì năng lượng và sức khỏe.',	'在周末完成10,000步，让你的周末更加健康和充满活力。',	1,	'/storage/contests/019ce162-3bd6-71ef-88b4-6c18305af5aa/1773307837.jpg',	'2026-03-12 00:00:00',	'2026-03-19 00:00:00',	'2026-03-20 00:00:00',	2000,	800,	1,	'2026-03-12 16:30:37',	'2026-03-18 10:45:30'),
('019ce163-66a8-723e-a99d-bc38081d0bd2',	'夏のフィットネスウォーク',	'Summer Fitness Walk',	'Đi bộ khỏe mạnh mùa hè',	'夏季健身步行挑战',	'夏の間に150km歩いて、健康的なライフスタイルを維持しましょう。',	'Walk 150 km during summer and maintain an active and healthy lifestyle.',	'Đi bộ 150 km trong mùa hè để duy trì lối sống năng động và khỏe mạnh.',	'在夏季完成150公里步行，保持活力与健康。',	1,	'/storage/contests/019ce163-66a8-723e-a99d-bc38081d0bd2/1773307913.jpg',	'2026-03-12 00:00:00',	'2026-03-28 00:00:00',	'2026-03-29 00:00:00',	150,	700,	1,	'2026-03-12 16:31:53',	'2026-03-12 16:31:53'),
('019ce164-9bbe-721d-b287-aa42b04e6210',	'グローバル500KMチームウォーク',	'Global 500KM Team Walk',	'Thử thách đội nhóm 500KM',	'全球500公里团队步行挑战',	'チームで協力して合計500kmを達成しましょう。',	'Work together with other participants to reach a total of 500 km as a team.',	'Cùng đồng đội chinh phục mục tiêu 500 km và xây dựng tinh thần đồng đội.',	'与团队成员一起完成500公里的共同目标。',	1,	'/storage/contests/019ce164-9bbe-721d-b287-aa42b04e6210/1773307993.jpg',	'2026-03-12 00:00:00',	'2026-04-01 00:00:00',	'2026-04-02 00:00:00',	500,	1500,	1,	'2026-03-12 16:33:13',	'2026-03-12 16:33:13'),
('019d0054-1eec-7107-aac4-b05ef5e13409',	'グローバルランニングレース2026',	'Global Running Race 2026',	'Giải Chạy Toàn Cầu 2026',	'全球跑步竞赛2026',	'世界中のランナーと一緒に参加できるエキサイティングなレースイベントです。自分の限界に挑戦し、持久力を高め、ランキング上位を目指しましょう。',	'Join runners from around the world in this exciting race event. Challenge yourself, improve your endurance, and compete for the top position on the leaderboard.',	'Tham gia giải chạy hấp dẫn cùng các vận động viên trên toàn thế giới. Thử thách bản thân, nâng cao sức bền và cạnh tranh vị trí cao trên bảng xếp hạng.',	'与来自世界各地的跑者一起参与这场激动人心的比赛。挑战自我，提高耐力，并在排行榜上争夺领先位置。',	2,	'/storage/contests/019d0054-1eec-7107-aac4-b05ef5e13409/1773827006.jpg',	'2026-03-18 00:00:00',	'2026-03-31 00:00:00',	'2026-04-01 00:00:00',	3000,	500,	1,	'2026-03-18 16:43:26',	'2026-03-18 16:43:26'),
('019d005a-bdf3-7216-b6d9-4b0c1c5ed6af',	'グローバル・スプリントチャレンジ2026',	'Global Sprint Challenge 2026',	'Thử Thách Chạy Nước Rút Toàn Cầu 2026',	'全球短跑挑战赛2026',	'スピードの興奮を体感できるグローバル・スプリントチャレンジです。短距離レースで限界に挑戦し、ランキング上位を目指しましょう。',	'Experience the thrill of speed in this global sprint challenge. Compete in short-distance races, push your limits, and race your way to the top of the leaderboard.',	'Trải nghiệm tốc độ bùng nổ trong thử thách chạy nước rút toàn cầu. Tham gia các cự ly ngắn, vượt qua giới hạn bản thân và vươn lên dẫn đầu bảng xếp hạng.',	'在这场全球短跑挑战赛中体验速度的激情。参与短距离竞速，突破自我，在排行榜上争夺领先位置。',	3,	'/storage/contests/019d005a-bdf3-7216-b6d9-4b0c1c5ed6af/1773827565.jpg',	'2026-03-18 00:00:00',	'2026-04-01 00:00:00',	'2026-04-02 00:00:00',	2000,	700,	1,	'2026-03-18 16:50:40',	'2026-03-18 16:52:45'),
('01d92661-daa9-4c25-91a3-8466ca482fad',	'4月2000kmウォーキングチャレンジ フェーズ 2',	'April 2000KM Walking Challenge Phase 2',	'Thử thách đi bộ 2000KM tháng 4 Giai đoạn 2',	'四月2000公里步行挑战 阶段 2',	'4月に2000km歩いて限界に挑戦しましょう。',	'Walk 2000 km in April and challenge your limits.',	'Đi bộ 2000 km trong tháng 4 để thử thách giới hạn.',	'在四月挑战2000公里步行极限。',	1,	'/storage/contests/01d92661-daa9-4c25-91a3-8466ca482fad/1773796253.jpg',	'2026-03-04 00:00:00',	'2026-04-17 00:00:00',	'2026-04-18 16:32:00',	2000,	1600,	1,	'2026-03-12 16:40:39',	'2026-03-18 08:10:53'),
('1192002e-860d-41de-a553-1b94c099297f',	'グローバル500KMチームウォーク',	'Global 500KM Team Walk',	'Thử thách đội nhóm 500KM',	'全球500公里团队步行挑战',	'チームで協力して合計500kmを達成しましょう。',	'Work together with other participants to reach a total of 500 km as a team.',	'Cùng đồng đội chinh phục mục tiêu 500 km và xây dựng tinh thần đồng đội.',	'与团队成员一起完成500公里的共同目标。',	1,	'/storage/contests/1192002e-860d-41de-a553-1b94c099297f/1773796270.jpg',	'2026-03-10 00:00:00',	'2026-04-07 00:00:00',	'2026-04-08 19:52:00',	500,	700,	1,	'2026-03-12 16:40:39',	'2026-03-18 08:11:10'),
('17970212-3f5c-4c69-91ef-c4235d243f65',	'春の1000KMウォーキングチャレンジ フェーズ 5',	'Spring 1000KM Walking Challenge Phase 5',	'Thử thách đi bộ 1000KM mùa xuân Giai đoạn 5',	'春季1000公里步行挑战 阶段 5',	'春の期間中に合計1000km歩いて、健康的な生活を楽しみましょう。',	'Walk a total of 1000 km during the spring season and stay active while enjoying the fresh air.',	'Hoàn thành 1000 km đi bộ trong mùa xuân và tận hưởng không khí trong lành.',	'在春季期间完成1000公里步行，保持健康并享受户外活动。',	1,	'/storage/contests/17970212-3f5c-4c69-91ef-c4235d243f65/1773796289.jpg',	'2026-03-02 00:00:00',	'2026-04-12 00:00:00',	'2026-04-13 20:28:00',	1000,	1300,	1,	'2026-03-12 16:40:39',	'2026-03-18 08:11:29'),
('191c14de-0b40-4e42-a49d-35fd73370d22',	'週末ステップチャレンジ フェーズ 3',	'Weekend Step Challenge Phase 3',	'Thử thách bước chân cuối tuần Giai đoạn 3',	'周末步数挑战 阶段 3',	'週末に10,000歩を達成して、アクティブな週末を過ごしましょう。',	'Walk 10,000 steps this weekend and boost your energy with a fun walking goal.',	'Hoàn thành 10.000 bước đi trong cuối tuần để duy trì năng lượng và sức khỏe.',	'在周末完成10,000步，让你的周末更加健康和充满活力。',	1,	'/storage/contests/191c14de-0b40-4e42-a49d-35fd73370d22/1773796304.jpg',	'2026-03-01 00:00:00',	'2026-04-02 00:00:00',	'2026-04-03 19:15:00',	10000,	1000,	1,	'2026-03-12 16:40:39',	'2026-03-18 08:11:44'),
('1c299470-02d7-427c-a70d-710b915a597c',	'週末ステップチャレンジ フェーズ 4',	'Weekend Step Challenge Phase 4',	'Thử thách bước chân cuối tuần Giai đoạn 4',	'周末步数挑战 阶段 4',	'週末に10,000歩を達成して、アクティブな週末を過ごしましょう。',	'Walk 10,000 steps this weekend and boost your energy with a fun walking goal.',	'Hoàn thành 10.000 bước đi trong cuối tuần để duy trì năng lượng và sức khỏe.',	'在周末完成10,000步，让你的周末更加健康和充满活力。',	1,	'/storage/contests/1c299470-02d7-427c-a70d-710b915a597c/1773796316.jpg',	'2026-03-06 00:00:00',	'2026-04-28 00:00:00',	'2026-04-29 19:57:00',	10000,	1600,	1,	'2026-03-12 16:40:39',	'2026-03-18 08:11:56'),
('37911f10-7192-4c30-89eb-fcf971427da4',	'夏のフィットネスウォーク フェーズ 4',	'Summer Fitness Walk Phase 4',	'Đi bộ khỏe mạnh mùa hè Giai đoạn 4',	'夏季健身步行挑战 阶段 4',	'夏の間に150km歩いて、健康的なライフスタイルを維持しましょう。',	'Walk 150 km during summer and maintain an active and healthy lifestyle.',	'Đi bộ 150 km trong mùa hè để duy trì lối sống năng động và khỏe mạnh.',	'在夏季完成150公里步行，保持活力与健康。',	1,	'/storage/contests/37911f10-7192-4c30-89eb-fcf971427da4/1773796353.jpg',	'2026-03-02 00:00:00',	'2026-04-06 00:00:00',	'2026-04-07 18:54:00',	150,	1100,	1,	'2026-03-12 16:40:39',	'2026-03-18 08:12:33'),
('37aa5887-1b69-4157-be89-ccd02d4e47ca',	'春の1000KMウォーキングチャレンジ',	'Spring 1000KM Walking Challenge',	'Thử thách đi bộ 1000KM mùa xuân',	'春季1000公里步行挑战',	'春の期間中に合計1000km歩いて、健康的な生活を楽しみましょう。',	'Walk a total of 1000 km during the spring season and stay active while enjoying the fresh air.',	'Hoàn thành 1000 km đi bộ trong mùa xuân và tận hưởng không khí trong lành.',	'在春季期间完成1000公里步行，保持健康并享受户外活动。',	1,	NULL,	'2026-03-01 00:00:00',	'2026-04-12 00:00:00',	'2026-04-13 21:56:00',	1000,	900,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:44:30'),
('3be5fe1f-2c83-48ea-bee9-d6c57da3e24b',	'週末ステップチャレンジ フェーズ 2',	'Weekend Step Challenge Phase 2',	'Thử thách bước chân cuối tuần Giai đoạn 2',	'周末步数挑战 阶段 2',	'週末に10,000歩を達成して、アクティブな週末を過ごしましょう。',	'Walk 10,000 steps this weekend and boost your energy with a fun walking goal.',	'Hoàn thành 10.000 bước đi trong cuối tuần để duy trì năng lượng và sức khỏe.',	'在周末完成10,000步，让你的周末更加健康和充满活力。',	1,	NULL,	'2026-03-07 00:00:00',	'2026-04-15 00:00:00',	'2026-04-16 19:02:00',	10000,	900,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:46:43'),
('4fb736ea-bd2d-4415-bf12-02a4d669d5a4',	'春の1000KMウォーキングチャレンジ フェーズ 3',	'Spring 1000KM Walking Challenge Phase 3',	'Thử thách đi bộ 1000KM mùa xuân Giai đoạn 3',	'春季1000公里步行挑战 阶段 3',	'春の期間中に合計1000km歩いて、健康的な生活を楽しみましょう。',	'Walk a total of 1000 km during the spring season and stay active while enjoying the fresh air.',	'Hoàn thành 1000 km đi bộ trong mùa xuân và tận hưởng không khí trong lành.',	'在春季期间完成1000公里步行，保持健康并享受户外活动。',	1,	NULL,	'2026-03-04 00:00:00',	'2026-04-21 00:00:00',	'2026-04-22 23:03:00',	1000,	1100,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:46:36'),
('5f2f3f12-0402-43a2-8f4d-ddfd080e76ca',	'夏のフィットネスウォーク フェーズ 5',	'Summer Fitness Walk Phase 5',	'Đi bộ khỏe mạnh mùa hè Giai đoạn 5',	'夏季健身步行挑战 阶段 5',	'夏の間に150km歩いて、健康的なライフスタイルを維持しましょう。',	'Walk 150 km during summer and maintain an active and healthy lifestyle.',	'Đi bộ 150 km trong mùa hè để duy trì lối sống năng động và khỏe mạnh.',	'在夏季完成150公里步行，保持活力与健康。',	1,	NULL,	'2026-03-08 00:00:00',	'2026-04-03 00:00:00',	'2026-04-04 16:33:00',	150,	1100,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:46:59'),
('63cae0d2-776b-4cfb-82c3-ef01ebc11275',	'グローバル500KMチームウォーク フェーズ 2',	'Global 500KM Team Walk Phase 2',	'Thử thách đội nhóm 500KM Giai đoạn 2',	'全球500公里团队步行挑战 阶段 2',	'チームで協力して合計500kmを達成しましょう。',	'Work together with other participants to reach a total of 500 km as a team.',	'Cùng đồng đội chinh phục mục tiêu 500 km và xây dựng tinh thần đồng đội.',	'与团队成员一起完成500公里的共同目标。',	1,	NULL,	'2026-02-10 00:00:00',	'2026-04-14 00:00:00',	'2026-04-15 22:57:00',	500,	1100,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:47:14'),
('6c20d10c-9fad-4f15-beea-60115a45b111',	'週末ステップチャレンジ',	'Weekend Step Challenge',	'Thử thách bước chân cuối tuần',	'周末步数挑战',	'週末に10,000歩を達成して、アクティブな週末を過ごしましょう。',	'Walk 10,000 steps this weekend and boost your energy with a fun walking goal.',	'Hoàn thành 10.000 bước đi trong cuối tuần để duy trì năng lượng và sức khỏe.',	'在周末完成10,000步，让你的周末更加健康和充满活力。',	1,	NULL,	'2026-03-05 00:00:00',	'2026-04-16 00:00:00',	'2026-04-17 18:16:00',	10000,	900,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:47:20'),
('85dbdd14-ec65-4fdb-9a6a-0c1b3aa187e0',	'週末ステップチャレンジ フェーズ 5',	'Weekend Step Challenge Phase 5',	'Thử thách bước chân cuối tuần Giai đoạn 5',	'周末步数挑战 阶段 5',	'週末に10,000歩を達成して、アクティブな週末を過ごしましょう。',	'Walk 10,000 steps this weekend and boost your energy with a fun walking goal.',	'Hoàn thành 10.000 bước đi trong cuối tuần để duy trì năng lượng và sức khỏe.',	'在周末完成10,000步，让你的周末更加健康和充满活力。',	1,	NULL,	'2026-03-08 00:00:00',	'2026-04-10 00:00:00',	'2026-04-11 21:05:00',	10000,	1300,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:47:27'),
('ac858be0-670a-497f-be8a-b1c4d982c99a',	'グローバル500KMチームウォーク フェーズ 5',	'Global 500KM Team Walk Phase 5',	'Thử thách đội nhóm 500KM Giai đoạn 5',	'全球500公里团队步行挑战 阶段 5',	'チームで協力して合計500kmを達成しましょう。',	'Work together with other participants to reach a total of 500 km as a team.',	'Cùng đồng đội chinh phục mục tiêu 500 km và xây dựng tinh thần đồng đội.',	'与团队成员一起完成500公里的共同目标。',	1,	NULL,	'2026-03-11 00:00:00',	'2026-04-09 00:00:00',	'2026-04-10 16:11:00',	500,	1000,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:47:33'),
('b07ce96c-6f7c-44fc-8ba0-9fa744634f51',	'4月2000kmウォーキングチャレンジ フェーズ 5',	'April 2000KM Walking Challenge Phase 5',	'Thử thách đi bộ 2000KM tháng 4 Giai đoạn 5',	'四月2000公里步行挑战 阶段 5',	'4月に2000km歩いて限界に挑戦しましょう。',	'Walk 2000 km in April and challenge your limits.',	'Đi bộ 2000 km trong tháng 4 để thử thách giới hạn.',	'在四月挑战2000公里步行极限。',	1,	NULL,	'2026-02-23 00:00:00',	'2026-04-06 00:00:00',	'2026-04-07 18:05:00',	2000,	2000,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:47:39'),
('b08a8139-e561-4c54-84d5-4889d6480acb',	'夏のフィットネスウォーク フェーズ 3',	'Summer Fitness Walk Phase 3',	'Đi bộ khỏe mạnh mùa hè Giai đoạn 3',	'夏季健身步行挑战 阶段 3',	'夏の間に150km歩いて、健康的なライフスタイルを維持しましょう。',	'Walk 150 km during summer and maintain an active and healthy lifestyle.',	'Đi bộ 150 km trong mùa hè để duy trì lối sống năng động và khỏe mạnh.',	'在夏季完成150公里步行，保持活力与健康。',	1,	NULL,	'2026-03-07 00:00:00',	'2026-04-08 00:00:00',	'2026-04-09 17:08:00',	150,	1500,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:47:47'),
('b4959c87-b5a6-4531-9346-79d7ff18a53f',	'4月2000kmウォーキングチャレンジ フェーズ 3',	'April 2000KM Walking Challenge Phase 3',	'Thử thách đi bộ 2000KM tháng 4 Giai đoạn 3',	'四月2000公里步行挑战 阶段 3',	'4月に2000km歩いて限界に挑戦しましょう。',	'Walk 2000 km in April and challenge your limits.',	'Đi bộ 2000 km trong tháng 4 để thử thách giới hạn.',	'在四月挑战2000公里步行极限。',	1,	NULL,	'2026-03-03 00:00:00',	'2026-04-30 00:00:00',	'2026-05-01 16:44:00',	2000,	1800,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:48:17'),
('bb5931fc-ca34-4b15-8231-5613a291fd42',	'グローバル500KMチームウォーク フェーズ 3',	'Global 500KM Team Walk Phase 3',	'Thử thách đội nhóm 500KM Giai đoạn 3',	'全球500公里团队步行挑战 阶段 3',	'チームで協力して合計500kmを達成しましょう。',	'Work together with other participants to reach a total of 500 km as a team.',	'Cùng đồng đội chinh phục mục tiêu 500 km và xây dựng tinh thần đồng đội.',	'与团队成员一起完成500公里的共同目标。',	1,	NULL,	'2026-03-05 00:00:00',	'2026-04-15 00:00:00',	'2026-04-16 23:21:00',	500,	1600,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:44:19'),
('d258ac95-4da9-4562-ae3b-aa540aca8cb3',	'夏のフィットネスウォーク',	'Summer Fitness Walk',	'Đi bộ khỏe mạnh mùa hè',	'夏季健身步行挑战',	'夏の間に150km歩いて、健康的なライフスタイルを維持しましょう。',	'Walk 150 km during summer and maintain an active and healthy lifestyle.',	'Đi bộ 150 km trong mùa hè để duy trì lối sống năng động và khỏe mạnh.',	'在夏季完成150公里步行，保持活力与健康。',	1,	NULL,	'2026-03-11 00:00:00',	'2026-04-20 00:00:00',	'2026-04-21 21:18:00',	150,	1500,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:48:08'),
('dad0a201-eaae-415b-91ed-492f67468546',	'4月2000kmウォーキングチャレンジ フェーズ 4',	'April 2000KM Walking Challenge Phase 4',	'Thử thách đi bộ 2000KM tháng 4 Giai đoạn 4',	'四月2000公里步行挑战 阶段 4',	'4月に2000km歩いて限界に挑戦しましょう。',	'Walk 2000 km in April and challenge your limits.',	'Đi bộ 2000 km trong tháng 4 để thử thách giới hạn.',	'在四月挑战2000公里步行极限。',	1,	NULL,	'2026-03-05 00:00:00',	'2026-04-04 00:00:00',	'2026-04-05 22:54:00',	2000,	1800,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:48:01'),
('e7d24829-7565-4e0d-ac0f-05dfe34d27d2',	'グローバル500KMチームウォーク フェーズ 4',	'Global 500KM Team Walk Phase 4',	'Thử thách đội nhóm 500KM Giai đoạn 4',	'全球500公里团队步行挑战 阶段 4',	'チームで協力して合計500kmを達成しましょう。',	'Work together with other participants to reach a total of 500 km as a team.',	'Cùng đồng đội chinh phục mục tiêu 500 km và xây dựng tinh thần đồng đội.',	'与团队成员一起完成500公里的共同目标。',	1,	NULL,	'2026-03-08 00:00:00',	'2026-04-20 00:00:00',	'2026-04-21 19:03:00',	500,	600,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:47:54'),
('ed525e29-4786-4699-b9ff-f06687f37288',	'春の1000KMウォーキングチャレンジ フェーズ 4',	'Spring 1000KM Walking Challenge Phase 4',	'Thử thách đi bộ 1000KM mùa xuân Giai đoạn 4',	'春季1000公里步行挑战 阶段 4',	'春の期間中に合計1000km歩いて、健康的な生活を楽しみましょう。',	'Walk a total of 1000 km during the spring season and stay active while enjoying the fresh air.',	'Hoàn thành 1000 km đi bộ trong mùa xuân và tận hưởng không khí trong lành.',	'在春季期间完成1000公里步行，保持健康并享受户外活动。',	1,	NULL,	'2026-03-08 00:00:00',	'2026-04-22 00:00:00',	'2026-04-23 15:49:00',	1000,	1500,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:43:40'),
('f664537f-f146-4e09-a3fc-188a2d754cd7',	'4月2000kmウォーキングチャレンジ',	'April 2000KM Walking Challenge',	'Thử thách đi bộ 2000KM tháng 4',	'四月2000公里步行挑战',	'4月に2000km歩いて限界に挑戦しましょう。',	'Walk 2000 km in April and challenge your limits.',	'Đi bộ 2000 km trong tháng 4 để thử thách giới hạn.',	'在四月挑战2000公里步行极限。',	1,	NULL,	'2026-03-12 00:00:00',	'2026-04-16 00:00:00',	'2026-04-17 21:20:00',	2000,	1400,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:43:35'),
('fe126d4a-291b-4ae3-b36d-f01ff951110b',	'春の1000KMウォーキングチャレンジ フェーズ 2',	'Spring 1000KM Walking Challenge Phase 2',	'Thử thách đi bộ 1000KM mùa xuân Giai đoạn 2',	'春季1000公里步行挑战 阶段 2',	'春の期間中に合計1000km歩いて、健康的な生活を楽しみましょう。',	'Walk a total of 1000 km during the spring season and stay active while enjoying the fresh air.',	'Hoàn thành 1000 km đi bộ trong mùa xuân và tận hưởng không khí trong lành.',	'在春季期间完成1000公里步行，保持健康并享受户外活动。',	1,	NULL,	'2026-03-01 00:00:00',	'2026-04-28 00:00:00',	'2026-04-29 21:27:00',	1000,	900,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:43:13'),
('fe5aa635-cbf0-45a7-b36c-c818aa4a268f',	'夏のフィットネスウォーク フェーズ 2',	'Summer Fitness Walk Phase 2',	'Đi bộ khỏe mạnh mùa hè Giai đoạn 2',	'夏季健身步行挑战 阶段 2',	'夏の間に150km歩いて、健康的なライフスタイルを維持しましょう。',	'Walk 150 km during summer and maintain an active and healthy lifestyle.',	'Đi bộ 150 km trong mùa hè để duy trì lối sống năng động và khỏe mạnh.',	'在夏季完成150公里步行，保持活力与健康。',	1,	NULL,	'2026-03-06 00:00:00',	'2026-04-17 00:00:00',	'2026-04-18 22:34:00',	150,	2000,	1,	'2026-03-12 16:40:39',	'2026-03-12 16:46:21');

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `measurements`;
CREATE TABLE `measurements` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recorded_at` timestamp NOT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `height` decimal(8,2) DEFAULT NULL,
  `bmi` decimal(8,2) DEFAULT NULL,
  `body_fat` decimal(8,2) DEFAULT NULL,
  `fat_free_body_weight` decimal(8,2) DEFAULT NULL,
  `muscle_mass` decimal(8,2) DEFAULT NULL,
  `skeletal_muscle_mass` decimal(8,2) DEFAULT NULL,
  `subcutaneous_fat` decimal(8,2) DEFAULT NULL,
  `visceral_fat` decimal(8,2) DEFAULT NULL,
  `body_water` decimal(8,2) DEFAULT NULL,
  `protein` decimal(8,2) DEFAULT NULL,
  `bone_mass` decimal(8,2) DEFAULT NULL,
  `bmr` decimal(8,2) DEFAULT NULL,
  `waist` decimal(8,2) DEFAULT NULL,
  `hip` decimal(8,2) DEFAULT NULL,
  `whr` decimal(8,2) DEFAULT NULL,
  `attachment_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `measurements_user_id_foreign` (`user_id`),
  CONSTRAINT `measurements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(32,	'2026_01_23_081004_create_jobs_table',	1),
(45,	'2026_01_23_064040_create_users_table',	2),
(46,	'2026_01_23_065745_create_password_reset_tokens_table',	2),
(47,	'2026_01_23_081003_create_cache_table',	2),
(48,	'2026_01_23_081003_create_sessions_table',	2),
(49,	'2026_02_06_095528_create_measurements_table',	2),
(50,	'2026_02_23_143244_create_contests_table',	2),
(51,	'2026_03_06_084406_create_user_contests_table',	2),
(52,	'2026_03_09_082324_create_user_steps_table',	2),
(53,	'2026_03_13_144206_create_contest_rewards_table',	3),
(54,	'2026_03_17_081624_rename_contest_rewards_to_contest_reward_settings',	4),
(55,	'2026_03_17_145022_add_consolation_points_to_contests_table',	5),
(56,	'2026_03_17_153010_drop_consolation_points_from_contests_table',	6),
(57,	'2026_03_17_092000_add_unique_key_to_user_steps_table',	7),
(58,	'2026_03_18_101500_add_device_source_to_user_contests_table',	8);

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('MqQ7l9VYyQHcgxec8nSdlhWje27TeK17IQBcIDD1',	NULL,	'172.18.0.1',	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:148.0) Gecko/20100101 Firefox/148.0',	'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRjVBQkE3ZmdiRmdUaERkUGpCTzQ5VXBMWUJGeEpOTWJpVjJFdTBscSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Njg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODA4MC9jZG4tY2dpL2NoYWxsZW5nZS1wbGF0Zm9ybS9zY3JpcHRzL2pzZC9tYWluLmpzIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjE4OiJmbGFzaGVyOjplbnZlbG9wZXMiO2E6MDp7fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzY6IjAxOWNlMGIzLTY0OGUtNzEzNC1hODc3LTgzNzMwNjNiMWY2NSI7fQ==',	1773827565);

DROP TABLE IF EXISTS `user_contests`;
CREATE TABLE `user_contests` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contest_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `total_steps` int NOT NULL DEFAULT '0',
  `device_source` tinyint DEFAULT NULL,
  `rank` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `is_calculated` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0: in_process; 1: completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_contests_user_id_contest_id_unique` (`user_id`,`contest_id`),
  KEY `user_contests_user_id_index` (`user_id`),
  KEY `user_contests_contest_id_index` (`contest_id`),
  CONSTRAINT `user_contests_contest_id_foreign` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_contests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_contests` (`id`, `user_id`, `contest_id`, `start_time`, `end_time`, `duration`, `total_steps`, `device_source`, `rank`, `score`, `is_calculated`, `status`, `created_at`, `updated_at`) VALUES
('019cfe86-b30c-70d7-bf73-78ef82482638',	'019ce0b3-6564-71eb-805c-185c74364725',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-12 06:19:26',	'2026-03-18 08:21:47',	525741,	1050,	1,	NULL,	NULL,	0,	1,	'2026-03-18 08:19:26',	'2026-03-18 08:21:47'),
('019cfe96-c825-70af-b00c-322786c1ec7d',	'019ce0b3-6639-7234-a4cc-c891e2cf6b77',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-12 06:37:00',	'2026-03-18 08:37:37',	525637,	1050,	1,	NULL,	NULL,	0,	1,	'2026-03-18 08:37:00',	'2026-03-18 08:37:37'),
('019cfe9d-84d3-72b0-8e61-85a3a9bf8f11',	'019ce0b3-67ea-7002-9b76-c11162d87781',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-12 05:44:21',	'2026-03-18 08:45:10',	529249,	1900,	1,	NULL,	NULL,	0,	1,	'2026-03-18 08:44:21',	'2026-03-18 08:45:10'),
('019cfe9e-9f3b-7015-bbcb-0299e55739f6',	'019ce0b3-68c2-720e-8300-0d519283e43e',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-12 07:45:34',	'2026-03-18 08:46:19',	522045,	1930,	1,	NULL,	NULL,	0,	1,	'2026-03-18 08:45:34',	'2026-03-18 08:46:19'),
('019cfe9f-a241-7346-93ca-84208cc7e681',	'019ce0b3-6998-72d3-b835-16dc12b320cd',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-12 06:46:40',	'2026-03-18 09:28:18',	528098,	1720,	1,	NULL,	NULL,	0,	1,	'2026-03-18 08:46:40',	'2026-03-18 09:28:18'),
('019cfeca-7e7c-728a-950d-49f5fb24f7de',	'019ce0b3-6a72-7344-b6d3-26ceaa69a0ea',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-12 09:33:29',	'2026-03-18 09:34:08',	518439,	640,	1,	NULL,	NULL,	0,	0,	'2026-03-18 09:33:29',	'2026-03-18 09:34:08'),
('019cfecc-21ea-7188-a914-5dd1d7d26c5d',	'019ce0b3-6b7e-725d-8970-18e4513c148e',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-13 09:35:16',	'2026-03-18 09:35:46',	432030,	550,	1,	NULL,	NULL,	0,	0,	'2026-03-18 09:35:16',	'2026-03-18 09:35:46'),
('019cfecd-230f-72c7-8774-4b7ad3813515',	'019ce0b3-6c78-7343-aab9-76e9987bc921',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-14 09:36:22',	'2026-03-18 09:37:02',	345640,	440,	1,	NULL,	NULL,	0,	0,	'2026-03-18 09:36:22',	'2026-03-18 09:37:02'),
('019cfefb-57d8-72cb-9258-226075f22324',	'019ce0b3-6d4a-7270-a72c-0db420c35439',	'019ce160-6b44-7326-9bb7-1eef7aeffe81',	'2026-03-12 05:26:50',	'2026-03-18 10:27:26',	536436,	950,	1,	NULL,	NULL,	0,	0,	'2026-03-18 10:26:50',	'2026-03-18 10:27:26');

DROP TABLE IF EXISTS `user_steps`;
CREATE TABLE `user_steps` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_source` tinyint NOT NULL COMMENT '1: apple_watch, 2: garmin, 3: fitbit',
  `steps` int NOT NULL DEFAULT '0',
  `recorded_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_device_record_unique` (`user_id`,`device_source`,`recorded_at`),
  CONSTRAINT `user_steps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_steps` (`id`, `user_id`, `device_source`, `steps`, `recorded_at`, `created_at`, `updated_at`) VALUES
('019cfe88-705d-728a-b4f4-234cb22750ec',	'019ce0b3-6564-71eb-805c-185c74364725',	1,	400,	'2026-03-12 07:00:00',	'2026-03-18 08:21:20',	'2026-03-18 08:21:20'),
('019cfe88-705d-728a-b4f4-234cb25ac680',	'019ce0b3-6564-71eb-805c-185c74364725',	1,	300,	'2026-03-12 09:00:00',	'2026-03-18 08:21:20',	'2026-03-18 08:21:20'),
('019cfe88-705d-728a-b4f4-234cb2bde0e2',	'019ce0b3-6564-71eb-805c-185c74364725',	1,	350,	'2026-03-12 11:00:00',	'2026-03-18 08:21:20',	'2026-03-18 08:21:20'),
('019cfe97-3710-7047-ad9e-5e5ef2e219ce',	'019ce0b3-6639-7234-a4cc-c891e2cf6b77',	1,	300,	'2026-03-12 08:00:00',	'2026-03-18 08:37:28',	'2026-03-18 08:37:28'),
('019cfe97-3710-7047-ad9e-5e5ef37a9fe2',	'019ce0b3-6639-7234-a4cc-c891e2cf6b77',	1,	200,	'2026-03-12 10:00:00',	'2026-03-18 08:37:28',	'2026-03-18 08:37:28'),
('019cfe97-3710-7047-ad9e-5e5ef4117cee',	'019ce0b3-6639-7234-a4cc-c891e2cf6b77',	1,	300,	'2026-03-13 09:00:00',	'2026-03-18 08:37:28',	'2026-03-18 08:37:28'),
('019cfe97-3710-7047-ad9e-5e5ef4de09ff',	'019ce0b3-6639-7234-a4cc-c891e2cf6b77',	1,	250,	'2026-03-13 11:00:00',	'2026-03-18 08:37:28',	'2026-03-18 08:37:28'),
('019cfe98-4769-70e4-beac-00ada5c6167b',	'019ce0b3-6711-712c-8a67-4a09458f9621',	1,	200,	'2026-03-12 08:00:00',	'2026-03-18 08:38:38',	'2026-03-18 08:38:38'),
('019cfe98-4769-70e4-beac-00ada61a5aeb',	'019ce0b3-6711-712c-8a67-4a09458f9621',	1,	150,	'2026-03-13 09:00:00',	'2026-03-18 08:38:38',	'2026-03-18 08:38:38'),
('019cfe98-4769-70e4-beac-00ada63f071b',	'019ce0b3-6711-712c-8a67-4a09458f9621',	1,	180,	'2026-03-14 10:00:00',	'2026-03-18 08:38:38',	'2026-03-18 08:38:38'),
('019cfe98-4769-70e4-beac-00ada714cba1',	'019ce0b3-6711-712c-8a67-4a09458f9621',	1,	220,	'2026-03-15 11:00:00',	'2026-03-18 08:38:38',	'2026-03-18 08:38:38'),
('019cfe98-4769-70e4-beac-00ada7ed6be2',	'019ce0b3-6711-712c-8a67-4a09458f9621',	1,	300,	'2026-03-16 12:00:00',	'2026-03-18 08:38:38',	'2026-03-18 08:38:38'),
('019cfe9e-25c8-72f1-90e0-40d31ef1f124',	'019ce0b3-67ea-7002-9b76-c11162d87781',	2,	180,	'2026-03-12 07:10:00',	'2026-03-18 08:45:03',	'2026-03-18 08:45:03'),
('019cfe9e-25c8-72f1-90e0-40d31f07b3a9',	'019ce0b3-67ea-7002-9b76-c11162d87781',	2,	260,	'2026-03-13 08:20:00',	'2026-03-18 08:45:03',	'2026-03-18 08:45:03'),
('019cfe9e-25c8-72f1-90e0-40d31f24a18b',	'019ce0b3-67ea-7002-9b76-c11162d87781',	2,	320,	'2026-03-14 09:30:00',	'2026-03-18 08:45:03',	'2026-03-18 08:45:03'),
('019cfe9e-25c8-72f1-90e0-40d320016e6b',	'019ce0b3-67ea-7002-9b76-c11162d87781',	2,	150,	'2026-03-15 10:10:00',	'2026-03-18 08:45:03',	'2026-03-18 08:45:03'),
('019cfe9e-25c8-72f1-90e0-40d320578186',	'019ce0b3-67ea-7002-9b76-c11162d87781',	2,	410,	'2026-03-16 11:40:00',	'2026-03-18 08:45:03',	'2026-03-18 08:45:03'),
('019cfe9e-25c8-72f1-90e0-40d32140f9d3',	'019ce0b3-67ea-7002-9b76-c11162d87781',	2,	220,	'2026-03-17 12:00:00',	'2026-03-18 08:45:03',	'2026-03-18 08:45:03'),
('019cfe9e-25c8-72f1-90e0-40d321edfb99',	'019ce0b3-67ea-7002-9b76-c11162d87781',	2,	360,	'2026-03-18 06:20:00',	'2026-03-18 08:45:03',	'2026-03-18 08:45:03'),
('019cfe9f-3e4c-71ee-bc13-2cfcf0a06dca',	'019ce0b3-68c2-720e-8300-0d519283e43e',	1,	240,	'2026-03-12 06:50:00',	'2026-03-18 08:46:14',	'2026-03-18 08:46:14'),
('019cfe9f-3e4c-71ee-bc13-2cfcf1970ce7',	'019ce0b3-68c2-720e-8300-0d519283e43e',	1,	310,	'2026-03-13 08:10:00',	'2026-03-18 08:46:14',	'2026-03-18 08:46:14'),
('019cfe9f-3e4c-71ee-bc13-2cfcf1cd1d02',	'019ce0b3-68c2-720e-8300-0d519283e43e',	1,	200,	'2026-03-14 09:40:00',	'2026-03-18 08:46:14',	'2026-03-18 08:46:14'),
('019cfe9f-3e4c-71ee-bc13-2cfcf2725c2d',	'019ce0b3-68c2-720e-8300-0d519283e43e',	1,	450,	'2026-03-15 10:30:00',	'2026-03-18 08:46:14',	'2026-03-18 08:46:14'),
('019cfe9f-3e4c-71ee-bc13-2cfcf2f7b94e',	'019ce0b3-68c2-720e-8300-0d519283e43e',	1,	370,	'2026-03-16 11:20:00',	'2026-03-18 08:46:14',	'2026-03-18 08:46:14'),
('019cfe9f-3e4c-71ee-bc13-2cfcf3556e5f',	'019ce0b3-68c2-720e-8300-0d519283e43e',	1,	180,	'2026-03-17 12:50:00',	'2026-03-18 08:46:14',	'2026-03-18 08:46:14'),
('019cfe9f-3e4c-71ee-bc13-2cfcf3641b66',	'019ce0b3-68c2-720e-8300-0d519283e43e',	1,	420,	'2026-03-18 06:30:00',	'2026-03-18 08:46:14',	'2026-03-18 08:46:14'),
('019cfea0-0d34-71c1-9d44-96c9bd403a16',	'019ce0b3-6998-72d3-b835-16dc12b320cd',	1,	300,	'2026-03-12 07:30:00',	'2026-03-18 08:47:07',	'2026-03-18 09:28:12'),
('019cfea0-0d34-71c1-9d44-96c9bd9af133',	'019ce0b3-6998-72d3-b835-16dc12b320cd',	1,	180,	'2026-03-13 08:45:00',	'2026-03-18 08:47:07',	'2026-03-18 09:28:12'),
('019cfea0-0d34-71c1-9d44-96c9bd9b9da9',	'019ce0b3-6998-72d3-b835-16dc12b320cd',	1,	420,	'2026-03-14 09:20:00',	'2026-03-18 08:47:07',	'2026-03-18 09:28:12'),
('019cfea0-0d34-71c1-9d44-96c9be5c54c6',	'019ce0b3-6998-72d3-b835-16dc12b320cd',	1,	260,	'2026-03-15 10:50:00',	'2026-03-18 08:47:07',	'2026-03-18 09:28:12'),
('019cfea0-0d34-71c1-9d44-96c9bf108f00',	'019ce0b3-6998-72d3-b835-16dc12b320cd',	1,	350,	'2026-03-16 11:10:00',	'2026-03-18 08:47:07',	'2026-03-18 09:28:12'),
('019cfea0-0d34-71c1-9d44-96c9bff4ae06',	'019ce0b3-6998-72d3-b835-16dc12b320cd',	1,	210,	'2026-03-17 12:30:00',	'2026-03-18 08:47:07',	'2026-03-18 09:28:12'),
('019cfeca-fc61-724f-8d67-33d45b54c625',	'019ce0b3-6a72-7344-b6d3-26ceaa69a0ea',	1,	180,	'2026-03-12 07:10:00',	'2026-03-18 09:34:01',	'2026-03-18 09:34:01'),
('019cfeca-fc61-724f-8d67-33d45bef448f',	'019ce0b3-6a72-7344-b6d3-26ceaa69a0ea',	1,	120,	'2026-03-13 08:20:00',	'2026-03-18 09:34:01',	'2026-03-18 09:34:01'),
('019cfeca-fc61-724f-8d67-33d45cb7fb82',	'019ce0b3-6a72-7344-b6d3-26ceaa69a0ea',	1,	160,	'2026-03-14 09:30:00',	'2026-03-18 09:34:01',	'2026-03-18 09:34:01'),
('019cfeca-fc61-724f-8d67-33d45d65fbeb',	'019ce0b3-6a72-7344-b6d3-26ceaa69a0ea',	1,	140,	'2026-03-15 10:10:00',	'2026-03-18 09:34:01',	'2026-03-18 09:34:01'),
('019cfeca-fc61-724f-8d67-33d45e617828',	'019ce0b3-6a72-7344-b6d3-26ceaa69a0ea',	1,	120,	'2026-03-16 11:40:00',	'2026-03-18 09:34:01',	'2026-03-18 09:34:01'),
('019cfeca-fc61-724f-8d67-33d45f151fbb',	'019ce0b3-6a72-7344-b6d3-26ceaa69a0ea',	1,	100,	'2026-03-17 12:00:00',	'2026-03-18 09:34:01',	'2026-03-18 09:34:01'),
('019cfecc-7ed9-730b-ab6b-19097e47497a',	'019ce0b3-6b7e-725d-8970-18e4513c148e',	1,	200,	'2026-03-12 06:50:00',	'2026-03-18 09:35:40',	'2026-03-18 09:35:40'),
('019cfecc-7ed9-730b-ab6b-19097e9f6102',	'019ce0b3-6b7e-725d-8970-18e4513c148e',	1,	150,	'2026-03-13 08:10:00',	'2026-03-18 09:35:40',	'2026-03-18 09:35:40'),
('019cfecc-7ed9-730b-ab6b-19097ea384eb',	'019ce0b3-6b7e-725d-8970-18e4513c148e',	1,	180,	'2026-03-14 09:40:00',	'2026-03-18 09:35:40',	'2026-03-18 09:35:40'),
('019cfecc-7ed9-730b-ab6b-19097eab228d',	'019ce0b3-6b7e-725d-8970-18e4513c148e',	1,	170,	'2026-03-15 10:30:00',	'2026-03-18 09:35:40',	'2026-03-18 09:35:40'),
('019cfecc-7ed9-730b-ab6b-19097f19c017',	'019ce0b3-6b7e-725d-8970-18e4513c148e',	1,	120,	'2026-03-16 11:20:00',	'2026-03-18 09:35:40',	'2026-03-18 09:35:40'),
('019cfecc-7ed9-730b-ab6b-19097fbf887f',	'019ce0b3-6b7e-725d-8970-18e4513c148e',	1,	80,	'2026-03-17 12:50:00',	'2026-03-18 09:35:40',	'2026-03-18 09:35:40'),
('019cfecd-aba6-73eb-9cd6-398e85f5d6da',	'019ce0b3-6c78-7343-aab9-76e9987bc921',	1,	130,	'2026-03-14 09:45:00',	'2026-03-18 09:36:57',	'2026-03-18 09:36:57'),
('019cfecd-aba6-73eb-9cd6-398e8677da35',	'019ce0b3-6c78-7343-aab9-76e9987bc921',	1,	110,	'2026-03-15 10:50:00',	'2026-03-18 09:36:57',	'2026-03-18 09:36:57'),
('019cfecd-aba6-73eb-9cd6-398e869e4014',	'019ce0b3-6c78-7343-aab9-76e9987bc921',	1,	100,	'2026-03-16 11:10:00',	'2026-03-18 09:36:57',	'2026-03-18 09:36:57'),
('019cfecd-aba6-73eb-9cd6-398e86fc6cfe',	'019ce0b3-6c78-7343-aab9-76e9987bc921',	1,	100,	'2026-03-17 12:30:00',	'2026-03-18 09:36:57',	'2026-03-18 09:36:57'),
('019cfefb-b2f6-7215-956a-6b1fe064b5a0',	'019ce0b3-6d4a-7270-a72c-0db420c35439',	1,	220,	'2026-03-12 07:00:00',	'2026-03-18 10:27:14',	'2026-03-18 10:27:14'),
('019cfefb-b2f6-7215-956a-6b1fe118a67b',	'019ce0b3-6d4a-7270-a72c-0db420c35439',	1,	180,	'2026-03-13 08:20:00',	'2026-03-18 10:27:14',	'2026-03-18 10:27:14'),
('019cfefb-b2f7-714f-8ca7-7a1667f2294c',	'019ce0b3-6d4a-7270-a72c-0db420c35439',	1,	200,	'2026-03-14 09:50:00',	'2026-03-18 10:27:14',	'2026-03-18 10:27:14'),
('019cfefb-b2f7-714f-8ca7-7a166870f349',	'019ce0b3-6d4a-7270-a72c-0db420c35439',	1,	150,	'2026-03-15 10:10:00',	'2026-03-18 10:27:14',	'2026-03-18 10:27:14'),
('019cfefb-b2f7-714f-8ca7-7a1668c1384c',	'019ce0b3-6d4a-7270-a72c-0db420c35439',	1,	120,	'2026-03-16 11:40:00',	'2026-03-18 10:27:14',	'2026-03-18 10:27:14'),
('019cfefb-b2f7-714f-8ca7-7a1668c2e527',	'019ce0b3-6d4a-7270-a72c-0db420c35439',	1,	80,	'2026-03-17 12:20:00',	'2026-03-18 10:27:14',	'2026-03-18 10:27:14');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint unsigned NOT NULL DEFAULT '3' COMMENT '1: admin, 2: staff, 3: user',
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` tinyint unsigned DEFAULT NULL COMMENT '1: male, 2: female',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_token_sent_at` timestamp NULL DEFAULT NULL,
  `status` tinyint unsigned NOT NULL DEFAULT '1' COMMENT '1: pending, 2: active, 3: banned',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `role`, `fullname`, `date_of_birth`, `gender`, `email`, `phone`, `avatar_url`, `address`, `bio`, `username`, `password`, `google_id`, `activation_token`, `activation_token_sent_at`, `status`, `email_verified_at`, `last_login_at`, `created_at`, `updated_at`) VALUES
('019ce0b3-63b3-7258-9e59-ac64dcd166e3',	1,	'Admin',	NULL,	NULL,	'admin@example.com',	NULL,	NULL,	NULL,	NULL,	'admin',	'$2y$12$4PxSBGgVh8saOF/LQnKvcOGK9RL6M5M/SME6UFvxWrEDeV2gTuCge',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:38',	'2026-03-12 13:19:38'),
('019ce0b3-648e-7134-a877-8373063b1f65',	2,	'Matthew Hernandez',	NULL,	NULL,	'staff@example.com',	NULL,	NULL,	NULL,	NULL,	'staff',	'$2y$12$1XdVpSpWylZ3YOrWt8fukOq2UkOtiI9XSVLBOB64jYdkK77BVk.YO',	NULL,	NULL,	NULL,	2,	NULL,	'2026-03-18 08:08:30',	'2026-03-12 13:19:39',	'2026-03-18 08:08:30'),
('019ce0b3-6564-71eb-805c-185c74364725',	3,	'Roth Conway',	NULL,	NULL,	'hung.nkd.29012003@gmail.com',	NULL,	NULL,	NULL,	NULL,	'user1',	'$2y$12$ANMPlgxDPT3q3hciw1l8LumLXHbMwsqs6OsqESY6d2JtufY88DgvK',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:39',	'2026-03-12 13:19:39'),
('019ce0b3-6639-7234-a4cc-c891e2cf6b77',	3,	'Kylynn Buchanan',	NULL,	NULL,	'hungnkd2912003@gmail.com',	NULL,	NULL,	NULL,	NULL,	'user2',	'$2y$12$QZCwhISaci0rFb7dHBiR8uS7NEbk6q5Pkd4XuhhoKSCcN5Ap8FbjC',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:39',	'2026-03-12 13:19:39'),
('019ce0b3-6711-712c-8a67-4a09458f9621',	3,	'Tobias Blackwell',	NULL,	NULL,	'to2lop9.8tvuong@gmail.com',	NULL,	NULL,	NULL,	NULL,	'user3',	'$2y$12$K0j75F1i5t88qCJz60aFOeRNRd6OSZOzgtcn1sgtVdKf29i7OrATG',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:39',	'2026-03-12 13:19:39'),
('019ce0b3-67ea-7002-9b76-c11162d87781',	3,	'Lynn Stein',	NULL,	NULL,	'bocute291@hotmail.com',	NULL,	NULL,	NULL,	NULL,	'user4',	'$2y$12$Ph2HkLxkRQUJpiTukK2Mou0tolmGtC4rjqgksQtvoZqRur9.SiatC',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:39',	'2026-03-12 13:19:39'),
('019ce0b3-68c2-720e-8300-0d519283e43e',	3,	'Sebastian Vance',	NULL,	NULL,	'hungnkd291@hotmail.com',	NULL,	NULL,	NULL,	NULL,	'user5',	'$2y$12$4FGCl5XIqo9B0avDlnyvNunTSlESmIKv.H6PcIHTkR8E6KQr/SOdC',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:40',	'2026-03-12 13:19:40'),
('019ce0b3-6998-72d3-b835-16dc12b320cd',	3,	'Brynne Parrish',	NULL,	NULL,	'hungnkd2912003@hotmail.com',	NULL,	NULL,	NULL,	NULL,	'user6',	'$2y$12$nlE8IBqYTHEyo2BfV3Pt6eXtar2rzV2SRc808BEcu/COhgDKr1XNm',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:40',	'2026-03-12 13:19:40'),
('019ce0b3-6a72-7344-b6d3-26ceaa69a0ea',	3,	'Athena Robinson',	NULL,	NULL,	'user7@example.com',	NULL,	NULL,	NULL,	NULL,	'user7',	'$2y$12$rGwPjH0Tb6vN6YUj36EkpuDDB4WLu9qtI41cp3/JRExfZmVfjPR9e',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:40',	'2026-03-12 13:19:40'),
('019ce0b3-6b7e-725d-8970-18e4513c148e',	3,	'Linus Page',	NULL,	NULL,	'user8@example.com',	NULL,	NULL,	NULL,	NULL,	'user8',	'$2y$12$XbJWqXZFOY5qQC55iZkK..NDACtuBb3j/Okj0GipvpVsZ4MoEUbKe',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:40',	'2026-03-12 13:19:40'),
('019ce0b3-6c78-7343-aab9-76e9987bc921',	3,	'Donna Fry',	NULL,	NULL,	'user9@example.com',	NULL,	NULL,	NULL,	NULL,	'user9',	'$2y$12$i33zOuxdQbEWHP5/8J/S/uh3bSVrHI/kkwvgua.ysP7RMy4IGVTEe',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:41',	'2026-03-12 13:19:41'),
('019ce0b3-6d4a-7270-a72c-0db420c35439',	3,	'Hiram Bush',	NULL,	NULL,	'user10@example.com',	NULL,	NULL,	NULL,	NULL,	'user10',	'$2y$12$x0ri8CasNZq4EYYLSFyTEe.wYZkpONBZfGvPMbQxctiZzbwGZmMpq',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:41',	'2026-03-12 13:19:41'),
('019ce0b3-6e21-7059-ae4e-7b221fae72ec',	3,	'Amena Mcneil',	NULL,	NULL,	'user11@example.com',	NULL,	NULL,	NULL,	NULL,	'user11',	'$2y$12$6gL4KRKDIJFDT56TK6YrveOezXmcRQ8JjzKHOdx8DceOxs8DRm5WC',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:41',	'2026-03-12 13:19:41'),
('019ce0b3-6ef6-7260-b58c-5fc4706ffc3c',	3,	'Jake Hunter',	NULL,	NULL,	'user12@example.com',	NULL,	NULL,	NULL,	NULL,	'user12',	'$2y$12$TRTDTLk1KofUvAsmMOBDsONssHMcih88cw68iFoI6GN0ZA2EyKapm',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:41',	'2026-03-12 13:19:41'),
('019ce0b3-6fcb-70fc-b227-27076884b06c',	3,	'Mason Clark',	NULL,	NULL,	'user13@example.com',	NULL,	NULL,	NULL,	NULL,	'user13',	'$2y$12$4HfkRt9K7zFUvDefnK6ZG.UgLvxJ5Z.9QSfJm8dgtaYSVpUZ/7WcW',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:41',	'2026-03-12 13:19:41'),
('019ce0b3-70a0-726e-9130-c26f2c98e0e5',	3,	'Ethan Walker',	NULL,	NULL,	'user14@example.com',	NULL,	NULL,	NULL,	NULL,	'user14',	'$2y$12$B/EEpjPwN7sRA2n5EBHime9eD/ouIfB6XFm0CpRBOpRGSNj3/tiXO',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:42',	'2026-03-12 13:19:42'),
('019ce0b3-7176-7350-b591-785e701d7641',	3,	'Kyle Bennett',	NULL,	NULL,	'user15@example.com',	NULL,	NULL,	NULL,	NULL,	'user15',	'$2y$12$nAxxMKPGOUIgqxf7VOmAGeZKf3GvXNAsiXJmXgEoKep8xOSrcIfma',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:42',	'2026-03-12 13:19:42'),
('019ce0b3-724b-7212-8800-29adaf020bb0',	3,	'Justin Ward',	NULL,	NULL,	'user16@example.com',	NULL,	NULL,	NULL,	NULL,	'user16',	'$2y$12$01OKmu0KD9bMLlE2Uu4qfe9sQWVWaeBx77FVqMn69xWH4Vj60BIJK',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:42',	'2026-03-12 13:19:42'),
('019ce0b3-732b-70d3-8398-478fe81d510c',	3,	'Trevor Morgan',	NULL,	NULL,	'user17@example.com',	NULL,	NULL,	NULL,	NULL,	'user17',	'$2y$12$H2NRytRMRl0vhjHzTpFVAuMT332NFOA.dDw6ahKBe66o9Us3p.W/a',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:42',	'2026-03-12 13:19:42'),
('019ce0b3-7403-7301-8227-98aa1e8d85b6',	3,	'Cody Fisher',	NULL,	NULL,	'user18@example.com',	NULL,	NULL,	NULL,	NULL,	'user18',	'$2y$12$8z4YBofm1eZcIsiFysbMjuPVTLOf6WiNF9V6DIxipJ4QORtPqZ2oy',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:42',	'2026-03-12 13:19:42'),
('019ce0b3-74df-715c-bf02-c8fb37e82037',	3,	'Blake Sanders',	NULL,	NULL,	'user19@example.com',	NULL,	NULL,	NULL,	NULL,	'user19',	'$2y$12$xmUP6v7jsLPb566LkixdZu/scVenc9Em9YvVYk8bqwSieYNseAxSS',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:43',	'2026-03-12 13:19:43'),
('019ce0b3-75b6-70b2-82f0-80566a94f6e5',	3,	'James Smith',	NULL,	NULL,	'user20@example.com',	NULL,	NULL,	NULL,	NULL,	'user20',	'$2y$12$oQ6cefEIZcWj9NMyBFe6HukeNBH/f9bw4if5SgTYfOcJrIth2nyQ2',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:43',	'2026-03-12 13:19:43'),
('019ce0b3-768b-7231-828a-cdbc58d9c634',	3,	'Michael Johnson',	NULL,	NULL,	'user21@example.com',	NULL,	NULL,	NULL,	NULL,	'user21',	'$2y$12$it7/0A9KsBXYmTc1lt5FsuxbCg4HqQRqaQ5vxb6lxo5Qhh9sGmFcG',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:43',	'2026-03-12 13:19:43'),
('019ce0b3-7765-718b-ab50-cf1b7d5ac739',	3,	'Robert Williams',	NULL,	NULL,	'user22@example.com',	NULL,	NULL,	NULL,	NULL,	'user22',	'$2y$12$5hw5CwknfGPapILWSgwrze37IXb0pdktjOwvyl72CF.1Lbrqg6GzO',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:43',	'2026-03-12 13:19:43'),
('019ce0b3-7837-735c-8e62-226799b0cd5a',	3,	'John Brown',	NULL,	NULL,	'user23@example.com',	NULL,	NULL,	NULL,	NULL,	'user23',	'$2y$12$cenlGpB1NWx/3aePzfoVnOe/bRMNIjQqzrR//v0r3NgZ5JaO.Z1ju',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:44',	'2026-03-12 13:19:44'),
('019ce0b3-7908-70f0-9960-7119c76c29ba',	3,	'David Jones',	NULL,	NULL,	'user24@example.com',	NULL,	NULL,	NULL,	NULL,	'user24',	'$2y$12$d1Iuv70fYzigLVgjgk5n..ruXCzIINZvXeiKP6gZ.xJ6ZchxnRTQ2',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:44',	'2026-03-12 13:19:44'),
('019ce0b3-79db-722a-8dae-20b167a8bbd5',	3,	'William Miller',	NULL,	NULL,	'user25@example.com',	NULL,	NULL,	NULL,	NULL,	'user25',	'$2y$12$WHMgEVshADtlQWajk8jCcOW/Qh1j4HGjNdq4aGvhalLuokruw/Brq',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:44',	'2026-03-12 13:19:44'),
('019ce0b3-7ab0-7160-a367-b40cb47c7ab9',	3,	'Richard Davis',	NULL,	NULL,	'user26@example.com',	NULL,	NULL,	NULL,	NULL,	'user26',	'$2y$12$uxObIVX5W5LhbGqh7LUFl.afKSAEK0bWboyhsyJad.KX/j612ymcG',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:44',	'2026-03-12 13:19:44'),
('019ce0b3-7b82-72a5-9882-a31d8a9ca8c9',	3,	'Joseph Garcia',	NULL,	NULL,	'user27@example.com',	NULL,	NULL,	NULL,	NULL,	'user27',	'$2y$12$2jtqXLLDs/hD0uelU0XJl.juaFldpiP.0UE7ow/lgx1xlezLjeM5.',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:44',	'2026-03-12 13:19:44'),
('019ce0b3-7c5f-7036-87e5-febf40aae07b',	3,	'Thomas Martinez',	NULL,	NULL,	'user28@example.com',	NULL,	NULL,	NULL,	NULL,	'user28',	'$2y$12$4McyD4FiKiApyhqgQhNVmumQbIPwtvMDd0.JxwQSnEY1bwUmD0/4u',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:45',	'2026-03-12 13:19:45'),
('019ce0b3-7d35-7372-90f9-63711e136e88',	3,	'Charles Anderson',	NULL,	NULL,	'user29@example.com',	NULL,	NULL,	NULL,	NULL,	'user29',	'$2y$12$kZmiCaOItpMESoRXVzUSaeCKVd6RUNssMJmFZtAMsbDGWA1tB5iai',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:45',	'2026-03-12 13:19:45'),
('019ce0b3-7e0a-7225-aea3-3afc3276169b',	3,	'Christopher Taylor',	NULL,	NULL,	'user30@example.com',	NULL,	NULL,	NULL,	NULL,	'user30',	'$2y$12$Hq.KjYEEnhCUIWzf3HAYVuMamNqdKp8DBhozjHuuKMwEpOPOeYR5W',	NULL,	NULL,	NULL,	2,	NULL,	NULL,	'2026-03-12 13:19:45',	'2026-03-12 13:19:45');

-- 2026-03-18 09:56:29 UTC
