-- Permet d'écrire la description d'un projet en markdown.
-- 0 = texte simple (nl2br + htmlspecialchars), 1 = markdown rendu via Parsedown.
-- (MySQL 8 ne supporte pas ADD COLUMN IF NOT EXISTS comme MariaDB ; cette migration
--  ne tourne qu'une seule fois grâce au tracking schema_migrations.)
ALTER TABLE projects
    ADD COLUMN is_markdown TINYINT(1) NOT NULL DEFAULT 0 AFTER description;
