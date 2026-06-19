<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php'; // Connexion à la BDD
require_once __DIR__ . '/../includes/rate-limit.php';
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
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
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

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
}
