-- Projets mis en avant sur la page d'accueil, choisis et ordonnés depuis
-- /admin/featured.
--
-- Une seule colonne encode l'appartenance ET le rang :
--   NULL     -> pas à la une
--   1, 2, 3… -> à la une, à cette position
--
-- Un booléen `featured` doublé d'une colonne `position` permettrait l'état
-- incohérent « coché mais sans position », qu'il faudrait ensuite gérer partout.
-- Ici cet état est inexprimable.
--
-- L'index sert le ORDER BY home_position de la page d'accueil.

ALTER TABLE projects
    ADD COLUMN home_position INT NULL DEFAULT NULL AFTER categories,
    ADD INDEX idx_projects_home_position (home_position);
