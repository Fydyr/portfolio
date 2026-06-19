-- Settings clé/valeur (titre, sous-titre, paragraphes courts)
CREATE TABLE IF NOT EXISTS site_settings (
    `key`        VARCHAR(100) PRIMARY KEY,
    `value`      LONGTEXT,
    `is_markdown` TINYINT(1) DEFAULT 0,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sections About : blocs répétitifs ordonnables (recherche, parcours, etc.)
CREATE TABLE IF NOT EXISTS about_sections (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    slug        VARCHAR(100) UNIQUE NOT NULL,
    title       VARCHAR(255) NOT NULL,
    icon        VARCHAR(100),
    content     LONGTEXT,
    is_markdown TINYINT(1) DEFAULT 1,
    sort_order  INT DEFAULT 0,
    visible     TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
