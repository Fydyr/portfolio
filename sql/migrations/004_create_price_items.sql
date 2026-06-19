CREATE TABLE IF NOT EXISTS price_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price VARCHAR(100),
    icon VARCHAR(100),
    sort_order INT DEFAULT 0,
    visible TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
