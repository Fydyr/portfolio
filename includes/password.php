<?php

/**
 * Politique de mot de passe, partagée par les trois points d'entrée qui en
 * définissent un : la page « Mon compte », le formulaire /recover et le script
 * CLI sql/reset_admin.php. Une seule définition, donc pas de dérive entre eux.
 */

const PASSWORD_MIN_LENGTH = 12;

/**
 * Retourne la liste des erreurs. Tableau vide = mot de passe accepté.
 *
 * On mise sur la longueur plutôt que sur des règles de composition (majuscule,
 * chiffre, caractère spécial) : c'est la longueur qui porte l'essentiel de la
 * résistance, et les règles de composition poussent surtout vers des motifs
 * prévisibles du type « Motdepasse1! ».
 */
function validateNewPassword(string $new, string $confirm): array
{
    $errors = [];

    if (mb_strlen($new) < PASSWORD_MIN_LENGTH) {
        $errors[] = 'Le nouveau mot de passe doit contenir au moins ' . PASSWORD_MIN_LENGTH . ' caractères.';
    }
    if ($new !== $confirm) {
        $errors[] = 'La confirmation ne correspond pas au nouveau mot de passe.';
    }

    return $errors;
}
