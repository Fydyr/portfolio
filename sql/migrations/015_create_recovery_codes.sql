-- Codes de secours permettant de reprendre la main sur un compte administrateur
-- sans accès au serveur.
--
-- code_hash est un SHA-256 hexadécimal (64 caractères), pas un hash bcrypt :
-- les codes sont des secrets aléatoires à haute entropie, pour lesquels un hash
-- lent n'apporte rien. L'index UNIQUE permet en prime un lookup direct.
--
-- used_at NULL = code encore utilisable. On conserve les codes consommés plutôt
-- que de les supprimer, pour garder une trace des reprises en main.

CREATE TABLE IF NOT EXISTS recovery_codes (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    code_hash  CHAR(64) NOT NULL,
    used_at    TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_recovery_code_hash (code_hash),
    KEY idx_recovery_user (user_id),
    CONSTRAINT fk_recovery_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
