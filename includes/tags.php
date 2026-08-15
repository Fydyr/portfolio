<?php

/**
 * Découpage des champs multivalués des projets (`languages`, `categories`).
 *
 * Ces deux colonnes stockent une chaîne unique séparée par des virgules plutôt
 * qu'une table de liaison. Le choix est assumé : la volumétrie est de quelques
 * dizaines de projets, et la saisie en texte libre reste la plus rapide côté
 * administration.
 *
 * Cette logique vivait en `private static` dans ProjectsController. L'admin en a
 * désormais besoin pour ses datalists : elle remonte ici plutôt que d'être
 * dupliquée dans deux contrôleurs.
 */

/**
 * Sépare une chaîne en tags propres. Accepte les séparateurs , ; / |
 * Trime, ignore les valeurs vides, déduplique en conservant l'ordre de saisie.
 */
function extractTagList(string $raw): array
{
    $parts = preg_split('/[,;\/|]/', $raw);
    $tags = [];
    foreach ($parts as $part) {
        $part = trim($part);
        if ($part !== '') {
            $tags[] = $part;
        }
    }
    return array_values(array_unique($tags));
}

/**
 * Toutes les valeurs distinctes d'une colonne multivaluée, triées alphabétiquement.
 *
 * Sert à alimenter les <datalist> de l'administration, pour éviter que « Jeu vidéo »
 * et « jeu video » coexistent. La comparaison de doublons se fait en minuscules,
 * mais c'est la première graphie rencontrée qui est conservée pour l'affichage.
 *
 * Le nom de colonne ne peut pas passer en paramètre lié (PDO ne lie que les
 * valeurs, jamais les identifiants) : il est donc validé contre une liste blanche,
 * sans quoi l'appelant ouvrirait une injection SQL.
 */
function collectDistinctTags(PDO $pdo, string $column): array
{
    $allowed = ['languages', 'categories'];
    if (!in_array($column, $allowed, true)) {
        throw new InvalidArgumentException("Colonne non autorisée : $column");
    }

    $rows = $pdo->query(
        "SELECT `$column` FROM projects WHERE `$column` IS NOT NULL AND `$column` <> ''"
    )->fetchAll(PDO::FETCH_COLUMN);

    $found = [];
    foreach ($rows as $raw) {
        foreach (extractTagList((string)$raw) as $tag) {
            $key = mb_strtolower($tag);
            if (!isset($found[$key])) {
                $found[$key] = $tag;
            }
        }
    }

    ksort($found);
    return array_values($found);
}
