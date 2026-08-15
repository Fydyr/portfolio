<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/password.php';
require_once __DIR__ . '/../includes/recovery.php';
require_once __DIR__ . '/../includes/rate-limit.php';

/**
 * Gestion du compte de l'administrateur connecté.
 *
 * L'authentification publique (login, logout, recover) reste dans
 * AccountController : ce contrôleur-ci ne traite que ce qui suppose une session
 * déjà authentifiée.
 */
class AccountAdminController extends BaseController
{
    /**
     * Rend la page. Les actions POST réaffichent la page via cette méthode en
     * lui passant leurs erreurs, plutôt que de dupliquer le rendu.
     */
    public function index(array $viewData = [])
    {
        requireAdmin();
        global $pdo;

        $userId = (int)$_SESSION['user_id'];

        echo $this->view('admin_account', array_merge([
            'errors'         => [],
            'plainCodes'     => null,
            'remainingCodes' => countUnusedRecoveryCodes($pdo, $userId),
            'userMail'       => $_SESSION['user_mail'] ?? '',
        ], $viewData));
    }

    public function changePassword()
    {
        requireAdmin();
        global $pdo;

        $userId  = (int)$_SESSION['user_id'];
        $email   = $_SESSION['user_mail'] ?? null;
        $ip      = clientIp();
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // Même limiteur que le login. Sans lui, une session volée permettrait de
        // brute-forcer le mot de passe actuel pour verrouiller le propriétaire
        // hors de son propre compte.
        $rl = checkRateLimit($ip, $email);
        if ($rl['blocked']) {
            http_response_code(429);
            header('Retry-After: ' . $rl['retry_after']);
            $this->index(['errors' => [
                'Trop de tentatives. Réessayez dans ' . formatRetryAfter($rl['retry_after']) . '.',
            ]]);
            return;
        }

        $stmt = $pdo->prepare('SELECT password FROM user WHERE id = ?');
        $stmt->execute([$userId]);
        $hash = $stmt->fetchColumn();

        if (!$hash || !password_verify($current, $hash)) {
            recordLoginAttempt($ip, $email, false);
            $this->index(['errors' => ['Mot de passe actuel incorrect.']]);
            return;
        }

        $errors = validateNewPassword($new, $confirm);
        if ($new === $current) {
            $errors[] = "Le nouveau mot de passe doit être différent de l'actuel.";
        }
        if (!empty($errors)) {
            $this->index(['errors' => $errors]);
            return;
        }

        $pdo->prepare('UPDATE user SET password = ? WHERE id = ?')
            ->execute([password_hash($new, PASSWORD_DEFAULT), $userId]);

        // Succès : remet le quota de tentatives à zéro.
        recordLoginAttempt($ip, $email, true);

        // Même séquence qu'un login réussi : l'identifiant de session et le jeton
        // CSRF tournent à chaque changement d'état d'authentification.
        session_regenerate_id(true);
        unset($_SESSION['csrf_token']);

        flash('success', 'Mot de passe mis à jour.');
        redirect('admin/account');
    }

    /**
     * Régénère le lot complet de codes et réaffiche la page avec les codes en
     * clair. C'est le seul moment où ils sont lisibles : ils ne sont stockés
     * que hachés, et rien ne permet de les retrouver ensuite.
     */
    public function generateCodes()
    {
        requireAdmin();
        global $pdo;

        $codes = regenerateRecoveryCodes($pdo, (int)$_SESSION['user_id']);
        $this->index(['plainCodes' => $codes]);
    }
}
