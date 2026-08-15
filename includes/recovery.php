<?php

/**
 * Codes de secours : génération, normalisation, stockage, consommation.
 *
 * Stockage en SHA-256 et non en bcrypt. Ce n'est pas un oubli : bcrypt existe
 * pour ralentir le cassage de secrets à faible entropie choisis par un humain.
 * Un code aléatoire de ~59 bits n'est pas cassable par force brute, bcrypt n'y
 * apporterait donc rien, et imposerait jusqu'à 8 vérifications lentes par
 * tentative. SHA-256 autorise en prime un index unique, donc un lookup direct.
 * C'est ainsi que sont stockés les codes de secours de GitHub et les jetons d'API.
 */

const RECOVERY_CODE_COUNT = 8;

// Base32 amputé des caractères ambigus à la lecture : ni O/0, ni I/1, ni L, ni U.
// 30 caractères -> ~4,9 bits par caractère -> ~59 bits pour un code de 12.
const RECOVERY_ALPHABET  = '23456789ABCDEFGHJKMNPQRSTVWXYZ';
const RECOVERY_GROUPS    = 3;
const RECOVERY_GROUP_LEN = 4;

/**
 * Génère un code au format XXXX-XXXX-XXXX.
 *
 * random_int() est le générateur cryptographique de PHP. rand() et mt_rand()
 * sont prédictibles à partir de quelques sorties : les utiliser ici rendrait
 * les codes devinables.
 */
function generateRecoveryCode(): string
{
    $max = strlen(RECOVERY_ALPHABET) - 1;
    $groups = [];

    for ($g = 0; $g < RECOVERY_GROUPS; $g++) {
        $chunk = '';
        for ($i = 0; $i < RECOVERY_GROUP_LEN; $i++) {
            $chunk .= RECOVERY_ALPHABET[random_int(0, $max)];
        }
        $groups[] = $chunk;
    }

    return implode('-', $groups);
}

/**
 * Normalise une saisie : majuscules, puis suppression de tout caractère hors
 * alphabet. Rend la saisie tolérante aux tirets, espaces, retours à la ligne et
 * copier-coller depuis un PDF.
 *
 * L'alphabet ne contient ni tiret ni métacaractère : son injection dans la
 * classe de caractères est sûre et ne peut pas former de plage accidentelle.
 */
function normalizeRecoveryCode(string $input): string
{
    $upper = strtoupper(trim($input));
    return preg_replace('/[^' . RECOVERY_ALPHABET . ']/', '', $upper) ?? '';
}

function hashRecoveryCode(string $normalized): string
{
    return hash('sha256', $normalized);
}

/**
 * Remplace le lot complet de codes d'un utilisateur. Les anciens sont détruits :
 * un lot remplace l'autre, jamais de cumul — sinon un lot compromis resterait
 * valide indéfiniment.
 *
 * Retourne les codes EN CLAIR. C'est la seule et unique occasion de les afficher :
 * ils ne sont stockés que hachés.
 */
function regenerateRecoveryCodes(PDO $pdo, int $userId): array
{
    $codes = [];
    $seen  = [];

    while (count($codes) < RECOVERY_CODE_COUNT) {
        $code = generateRecoveryCode();
        $norm = normalizeRecoveryCode($code);
        if (isset($seen[$norm])) {
            continue; // collision très improbable, mais l'index est UNIQUE
        }
        $seen[$norm] = true;
        $codes[] = $code;
    }

    // Transaction : ne jamais laisser l'utilisateur sans aucun code valide si
    // l'insertion échoue à mi-parcours.
    $pdo->beginTransaction();
    try {
        $pdo->prepare('DELETE FROM recovery_codes WHERE user_id = ?')->execute([$userId]);
        $ins = $pdo->prepare('INSERT INTO recovery_codes (user_id, code_hash) VALUES (?, ?)');
        foreach ($codes as $code) {
            $ins->execute([$userId, hashRecoveryCode(normalizeRecoveryCode($code))]);
        }
        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }

    return $codes;
}

/**
 * Consomme un code. Retourne true seulement si le code existait, appartenait à
 * cet utilisateur et n'avait pas déjà servi.
 *
 * La vérification et la consommation tiennent dans un seul UPDATE conditionnel,
 * donc en une seule opération atomique. Un SELECT suivi d'un UPDATE laisserait
 * une fenêtre où deux requêtes simultanées portant le même code réussiraient
 * toutes les deux.
 */
function consumeRecoveryCode(PDO $pdo, int $userId, string $rawCode): bool
{
    $norm = normalizeRecoveryCode($rawCode);
    if ($norm === '') {
        return false;
    }

    $stmt = $pdo->prepare(
        'UPDATE recovery_codes
            SET used_at = NOW()
          WHERE user_id = :uid AND code_hash = :hash AND used_at IS NULL'
    );
    $stmt->execute([':uid' => $userId, ':hash' => hashRecoveryCode($norm)]);

    return $stmt->rowCount() === 1;
}

function countUnusedRecoveryCodes(PDO $pdo, int $userId): int
{
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM recovery_codes WHERE user_id = ? AND used_at IS NULL'
    );
    $stmt->execute([$userId]);
    return (int)$stmt->fetchColumn();
}
