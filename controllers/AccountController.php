<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php'; // Connexion à la BDD
require_once __DIR__ . '/../includes/rate-limit.php';
require_once __DIR__ . '/../includes/password.php';
require_once __DIR__ . '/../includes/recovery.php';
global $pdo;

class AccountController extends BaseController
{
    public function login()
    {
        // Si déjà connecté, redirige vers l'accueil
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Anti login-CSRF : empêche un tiers de connecter la victime sur un
            // compte qu'il contrôle pour ensuite observer/piéger son activité.
            requireCsrf();

            $errors = [];

            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
            $mdp   = $_POST['mdp'] ?? '';
            $ip    = clientIp();

            // === Rate limit (check AVANT de toucher à la DB user) ===
            $rl = checkRateLimit($ip, $email ?: null);
            if ($rl['blocked']) {
                http_response_code(429);
                header('Retry-After: ' . $rl['retry_after']);
                $errors[] = "Trop de tentatives échouées. Réessayez dans " . formatRetryAfter($rl['retry_after']) . ".";
                echo $this->view('login', ['errors' => $errors]);
                return;
            }

            if (!$email) {
                $errors[] = 'Adresse email invalide.';
            }
            if (empty($mdp)) {
                $errors[] = 'Mot de passe requis.';
            }

            if (empty($errors)) {
                global $pdo;
                $stmt = $pdo->prepare('SELECT id, mail, password, admin FROM user WHERE mail = ?');
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($mdp, $user['password'])) {
                    recordLoginAttempt($ip, $email, true);

                    // Anti-fixation de session : l'ID de session utilisé avant
                    // authentification ne doit jamais rester valide après.
                    session_regenerate_id(true);
                    // On fait tourner aussi le jeton CSRF avec le changement de privilège.
                    unset($_SESSION['csrf_token']);

                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_mail'] = $user['mail'];
                    $_SESSION['admin']     = (int)($user['admin'] ?? 0);
                    header('Location: ' . url('admin'));
                    exit;
                } else {
                    recordLoginAttempt($ip, $email ?: null, false);
                    $remaining = max(0, RATE_LIMIT_MAX_ATTEMPTS - ($rl['attempts'] + 1));
                    if ($remaining <= 2 && $remaining > 0) {
                        $errors[] = "Email ou mot de passe incorrect. Il vous reste $remaining tentative(s) avant blocage temporaire.";
                    } else {
                        $errors[] = 'Email ou mot de passe incorrect.';
                    }
                }
            } else {
                // Email/mdp manquant : on log quand même comme échec (les bots qui spamment ne fournissent pas toujours)
                recordLoginAttempt($ip, $email ?: null, false);
            }

            echo $this->view('login', ['errors' => $errors]);
        } else {
            echo $this->view('login');
        }
    }

    /**
     * Réinitialisation du mot de passe par code de secours.
     *
     * Route publique : contrairement aux pages /admin, aucun middleware ne la
     * couvre, la vérification CSRF est donc explicite. La session anonyme existe
     * déjà (startSecureSession() tourne dans includes/header.php), le jeton est
     * donc disponible pour un visiteur non connecté.
     */
    public function recover()
    {
        if (isset($_SESSION['user_id'])) {
            redirect('admin/account');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo $this->view('recover', ['errors' => []]);
            return;
        }

        requireCsrf();
        global $pdo;

        $email   = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $code    = $_POST['code'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $ip      = clientIp();

        $rl = checkRateLimit($ip, $email ?: null);
        if ($rl['blocked']) {
            http_response_code(429);
            header('Retry-After: ' . $rl['retry_after']);
            echo $this->view('recover', ['errors' => [
                'Trop de tentatives. Réessayez dans ' . formatRetryAfter($rl['retry_after']) . '.',
            ]]);
            return;
        }

        // Valider le mot de passe AVANT de toucher au code : sinon une simple
        // faute de frappe dans la confirmation consommerait définitivement un
        // code de secours. Ce message ne révèle rien, le code n'a pas été testé.
        $pwErrors = validateNewPassword($new, $confirm);
        if (!empty($pwErrors)) {
            echo $this->view('recover', ['errors' => $pwErrors]);
            return;
        }

        // Message unique pour tous les échecs d'identification : adresse inconnue,
        // code inconnu, code déjà consommé. Des messages distincts permettraient
        // de découvrir quelles adresses possèdent un compte.
        $genericError = 'Adresse e-mail ou code de secours invalide.';

        $user = null;
        if ($email) {
            $stmt = $pdo->prepare('SELECT id FROM user WHERE mail = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        if (!$user || !consumeRecoveryCode($pdo, (int)$user['id'], $code)) {
            recordLoginAttempt($ip, $email ?: null, false);
            echo $this->view('recover', ['errors' => [$genericError]]);
            return;
        }

        $pdo->prepare('UPDATE user SET password = ? WHERE id = ?')
            ->execute([password_hash($new, PASSWORD_DEFAULT), (int)$user['id']]);

        recordLoginAttempt($ip, $email, true);

        // Pas de connexion automatique : le nouveau mot de passe doit être saisi
        // sur le formulaire de login normal. Plus simple, et rien à invalider.
        flash('success', 'Mot de passe réinitialisé. Vous pouvez vous connecter.');
        redirect('login');
    }

    public function logout()
    {
        startSecureSession();
        session_unset();
        session_destroy();

        // Détruit aussi le cookie côté navigateur, sinon l'ID reste présenté à
        // chaque requête suivante.
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires'  => time() - 42000,
            'path'     => $params['path'],
            'domain'   => $params['domain'],
            'secure'   => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'] ?? 'Strict',
        ]);

        header('Location: ' . url(''));
        exit;
    }
}
