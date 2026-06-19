-- Compteur de visites quotidien pour pouvoir faire un graphique.
-- Une ligne par jour, incrémentée à chaque nouvelle session.
-- Le compteur total (compteur.txt) reste géré séparément pour compat.
CREATE TABLE IF NOT EXISTS daily_visits (
    day   DATE PRIMARY KEY,
    count INT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
