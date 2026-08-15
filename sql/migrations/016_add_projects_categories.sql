-- Catégories de projet, distinctes des technologies déjà portées par `languages`.
--
-- Même convention de stockage que `languages` : une chaîne unique séparée par des
-- virgules, découpée à la lecture par extractTagList(). Pas de table de liaison —
-- la volumétrie ne le justifie pas et la saisie en texte libre reste la plus
-- rapide côté administration.
--
-- `languages` = technologies (PHP, MySQL, Docker)
-- `categories` = types de projet (Web, Jeu, Scolaire, Outil)
--
-- NULL autorisé : les projets existants n'ont pas de catégorie tant qu'on ne leur
-- en a pas donné, et la page publique doit continuer de les afficher.

ALTER TABLE projects ADD COLUMN categories VARCHAR(255) NULL AFTER languages;
