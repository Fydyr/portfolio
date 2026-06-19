CREATE TABLE IF NOT EXISTS passions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    short_description TEXT,
    long_description TEXT,
    why TEXT,
    icon VARCHAR(100),
    likes JSON,
    sort_order INT DEFAULT 0,
    visible TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
