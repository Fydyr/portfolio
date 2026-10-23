-- Conversion des tables historiques (créées avant le système de migrations)
-- en utf8mb4 pour éviter l'erreur MySQL 3988 (incompatibilité de collation utf8mb4 / utf8mb3).

ALTER DATABASE CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE projects CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE user CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
