-- Jalankan ini KALAU Anda SUDAH pernah import database/cuci_alber.sql sebelumnya
-- (sebelum fitur multi-foto ada). Ini akan:
-- 1. Membuat tabel submission_photos (baru)
-- 2. Memindahkan foto yang sudah ada di kolom lama foto_tampak_samping ke tabel baru
-- 3. Menghapus kolom lama tersebut
-- Data isian form yang sudah ada TIDAK akan hilang.

CREATE TABLE IF NOT EXISTS `submission_photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` bigint unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submission_photos_submission_id_foreign` (`submission_id`),
  CONSTRAINT `submission_photos_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pindahkan foto lama (kalau kolomnya masih ada) ke tabel baru
INSERT INTO `submission_photos` (`submission_id`, `path`, `created_at`, `updated_at`)
SELECT `id`, `foto_tampak_samping`, NOW(), NOW()
FROM `submissions`
WHERE `foto_tampak_samping` IS NOT NULL AND `foto_tampak_samping` <> '';

-- Hapus kolom lama (jalankan manual satu per satu kalau ada error "column not found",
-- artinya kolom ini memang sudah tidak ada / sudah pernah dihapus sebelumnya - aman diabaikan)
ALTER TABLE `submissions` DROP COLUMN `foto_tampak_samping`;

-- Catat migration baru supaya `php artisan migrate` tidak bentrok di kemudian hari
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2025_01_02_000002_create_submission_photos_table', 1
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2025_01_02_000002_create_submission_photos_table'
);
