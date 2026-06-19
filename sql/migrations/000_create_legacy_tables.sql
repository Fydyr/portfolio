-- Tables existantes avant le système de migrations.
-- IF NOT EXISTS = no-op si déjà présentes (prod), création si absentes (dev fresh).

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    link VARCHAR(500),
    img1 VARCHAR(255),
    img2 VARCHAR(255),
    img3 VARCHAR(255),
    visibilite TINYINT(1) DEFAULT 1,
    languages VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mail VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    admin TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
