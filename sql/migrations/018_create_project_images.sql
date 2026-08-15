-- Images de projet en nombre libre.
--
-- Les colonnes img1/img2/img3 imposaient un plafond de trois images et rendaient
-- l'ordre implicite. Une table dédiée lève les deux limites.
--
-- ORDRE DES OPERATIONS, VOLONTAIRE :
--   1. création de la table
--   2. recopiage des images existantes
--   3. suppression des anciennes colonnes
--
-- sql/migrate.php exécute les instructions une par une et s'arrête au premier
-- échec. Si le recopiage échoue, le DROP n'est jamais atteint et les données
-- restent en place. L'inverse — supprimer d'abord — serait irréversible.
--
-- sort_order démarre à 1. La première image d'un projet est sa couverture :
-- c'est elle qui s'affiche sur les cartes et dans les métadonnées Open Graph.

CREATE TABLE IF NOT EXISTS project_images (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    filename   VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_project_images_project (project_id, sort_order),
    CONSTRAINT fk_project_images_project
        FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO project_images (project_id, filename, sort_order)
SELECT id, img1, 1 FROM projects WHERE img1 IS NOT NULL AND img1 <> '';

INSERT INTO project_images (project_id, filename, sort_order)
SELECT id, img2, 2 FROM projects WHERE img2 IS NOT NULL AND img2 <> '';

INSERT INTO project_images (project_id, filename, sort_order)
SELECT id, img3, 3 FROM projects WHERE img3 IS NOT NULL AND img3 <> '';

ALTER TABLE projects
    DROP COLUMN img1,
    DROP COLUMN img2,
    DROP COLUMN img3;
