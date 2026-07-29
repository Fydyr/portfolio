-- Garantit qu'au moins un compte administrateur existe.
--
-- Contexte : la garde d'accès de /admin vérifie désormais réellement `admin = 1`.
-- Avant, la condition
--     !isset($_SESSION['user_id']) && !isset($_SESSION['admin']) == 1
-- se lisait (précédence de `==` sur `&&`) « aucune des deux clés n'est présente »,
-- donc tout compte authentifié passait pour administrateur et la colonne `admin`
-- n'était jamais consultée.
--
-- La colonne étant `DEFAULT 0`, un compte créé à la main (phpMyAdmin, INSERT
-- direct) vaut 0 et se retrouverait verrouillé hors du panel après ce durcissement.
--
-- No-op s'il existe déjà au moins un admin. Sinon promeut le compte le plus
-- ancien. Les sous-requêtes sont imbriquées dans des tables dérivées pour forcer
-- leur matérialisation (MySQL interdit de lire la table cible d'un UPDATE
-- autrement).
UPDATE user
SET admin = 1
WHERE id = (
        SELECT first_id FROM (SELECT MIN(id) AS first_id FROM user) AS t1
    )
    AND NOT EXISTS (
        SELECT 1 FROM (SELECT id FROM user WHERE admin = 1) AS t2
    );
