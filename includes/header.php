<?php
//import bdd
include_once __DIR__ . '/db.php';
global $pdo;

// Démarrer la session
session_start();

// récupérer le nombre de projets sur la bdd
$stmt = $pdo->prepare("SELECT COUNT(*) FROM projects");
$stmt->execute();
$project_count = $stmt->fetchColumn();

// Configuration du site
$site_title = "Enzo Fournier";
$site_tagline = "";
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Navigation items
$nav_items = [
    'index' => ['title' => 'Accueil', 'icon' => '🏠', 'url' => homeUrl()],
    'projects' => ['title' => 'Projets', 'icon' => '📂', 'url' => url('projects')],
    'contact' => ['title' => 'Contact', 'icon' => '📌', 'url' => url('contact')],
];

// Gestion de l'authentification
if (isset($_SESSION['user_id'])) {
    $nav_items['admin'] = ['title' => 'Admin', 'icon' => '⚙️', 'url' => url('admin')];
    $nav_items['logout'] = ['title' => 'Déconnexion', 'icon' => '🚪', 'url' => url('logout')];
} else {
    $nav_items['login'] = ['title' => 'Connexion', 'icon' => '🔐', 'url' => url('login')];
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Logo du site -->
    <link rel="icon" type="image/x-icon" href="/assets//img/logo_site.ico">

    <!-- Embed pour discord -->
    <meta property="og:title" content="Portfolio de Enzo" />
    <meta property="og:description" content="Ceci est le portfolio de Enzo Fournier. Vous pourrez trouver les différents projets réalisé par celui ci." />
    <meta property="og:image" content="/assets/img/img_logo.png" />
    <meta property="og:url" content="https://enzo-f.jrcan.dev/" />
    <meta property="og:type" content="website" />

    <!-- Embed pour twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Portfolio de Enzo" />
    <meta name="twitter:description" content="Ceci est le portfolio de Enzo Fournier. Vous pourrez trouver les différents projets réalisé par celui ci." />
    <meta name="twitter:image" content="/assets/img/img_logo.png" />
    <meta name="twitter:site" content="@fydyr9">
    <meta name="twitter:creator" content="@fydyr9">


    <style>
        /* Variables CSS */
        :root {
            --primary-color: #00d4ff;
            --secondary-color: #ff006e;
            --accent-color: #7209b7;
            --success-color: #00ff88;
            --warning-color: #ffaa00;
            --danger-color: #ff0040;
            --dark-bg: #0a0a0f;
            --dark-card: #1a1a2e;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --text-muted: #666b6e;
            --gradient-primary: linear-gradient(135deg, #00d4ff 0%, #7209b7 100%);
            --gradient-secondary: linear-gradient(135deg, #ff006e 0%, #00d4ff 100%);
            --gradient-success: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
            --shadow-glow: 0 0 30px rgba(0, 212, 255, 0.3);
            --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.3);
            --border-glow: 1px solid rgba(0, 212, 255, 0.5);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body */
        body {
            background: var(--dark-bg);
            background-image:
                radial-gradient(circle at 20% 50%, rgba(120, 9, 183, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 0, 110, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(0, 212, 255, 0.2) 0%, transparent 50%);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* Particles Background */
        .particles-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        /* Header */
        .header-nav {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: var(--border-glow);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-card);
        }

        .header-nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gradient-primary);
        }

        .navbar-brand {
            text-decoration: none;
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-icon {
            font-size: 2rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-family: 'Courier New', monospace;
        }

        .brand-name {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .navbar-nav .nav-link {
            color: var(--text-secondary);
            transition: var(--transition);
            position: relative;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color);
            background: rgba(0, 212, 255, 0.1);
            text-decoration: none;
        }

        .navbar-nav .nav-link.active {
            color: var(--primary-color);
            background: rgba(0, 212, 255, 0.2);
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }

        /* Typography */
        h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
        }

        h2 {
            font-size: clamp(1.5rem, 3vw, 2.5rem);
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        p {
            color: var(--text-secondary);
            font-size: 1.125rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        /* Cards */
        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: var(--border-glow);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-card);
            transition: var(--transition);
            position: relative;
            margin: 1rem 0;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gradient-primary);
            opacity: 0.8;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-glow);
            border-color: var(--primary-color);
        }

        .card-body {
            padding: 2rem;
        }

        /* Buttons */
        .btn {
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            border: none;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 212, 255, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
            background: var(--gradient-secondary);
            color: white;
        }

        /* Alerts */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            backdrop-filter: blur(20px);
            margin: 1rem 0;
            padding: 1rem 1.5rem;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success {
            background: rgba(0, 255, 136, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(0, 255, 136, 0.3);
        }

        .alert-error {
            background: rgba(255, 0, 64, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(255, 0, 64, 0.3);
        }

        /* Footer */
        .footer-section {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(20px);
            border-top: var(--border-glow);
            margin-top: 4rem;
            position: relative;
        }

        .footer-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gradient-primary);
        }

        .footer-main {
            padding: 3rem 0 2rem;
        }

        .footer-widget {
            margin-bottom: 2rem;
        }

        .footer-title {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-title .brand-icon {
            font-size: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-tagline {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .footer-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .footer-stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-widget-title {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .footer-contact {
            margin-bottom: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            color: var(--text-secondary);
        }

        .contact-item i {
            color: var(--primary-color);
            width: 16px;
        }

        .contact-item a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
        }

        .contact-item a:hover {
            color: var(--primary-color);
        }

        .social-title {
            color: var(--text-primary);
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--glass-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 212, 255, 0.4);
        }

        .nav-title {
            color: var(--text-primary);
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-links li {
            margin-bottom: 0.5rem;
        }

        .footer-link {
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-link:hover {
            color: var(--primary-color);
            padding-left: 0.25rem;
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 0;
        }

        .footer-copyright {
            color: var(--text-secondary);
        }

        .legal-links {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .legal-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .legal-links a:hover {
            color: var(--primary-color);
        }

        .status-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: var(--success-color);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 255, 136, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(0, 255, 136, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 255, 136, 0);
            }
        }

        .status-text {
            color: var(--success-color);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .footer-simple {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(20px);
            border-top: var(--border-glow);
            padding: 2rem 0;
            margin-top: 4rem;
            position: relative;
        }

        .footer-simple::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--gradient-primary);
        }

        .footer-content {
            text-align: center;
            color: var(--text-secondary);
        }

        .footer-brand {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        /* Animations */
        .glow-effect {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
            }

            to {
                text-shadow: 0 0 30px rgba(0, 212, 255, 0.8);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .brand-container {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .navbar-nav .nav-link {
                justify-content: center;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="<?php echo $current_page; ?>-page">

    <!-- Particles Background -->
    <div id="particles-bg" class="particles-background"></div>

    <!-- Header Navigation -->
    <header class="header-nav">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <!-- Logo / Brand -->
                <a class="navbar-brand" href="<?= homeUrl() ?>">
                    <div class="brand-container">
                        <span class="brand-icon">&lt;/&gt;</span>
                        <div class="brand-text">
                            <h1 class="brand-name glow-effect"><?php echo $site_title; ?></h1>
                        </div>
                    </div>
                </a>

                <!-- Toggle pour mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation principale -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php foreach ($nav_items as $page => $item): ?>
                            <li class="nav-item">
                                <?php
                                // Logique plus précise pour détecter la page active
                                $current_page = basename($_SERVER['REQUEST_URI'], '.php');
                                $is_active = ($current_page === $page) ||
                                    ($_SERVER['REQUEST_URI'] === '/' && $page === 'index') ||
                                    (strpos($_SERVER['REQUEST_URI'], $page) !== false && $page !== 'index');
                                ?>
                                <a class="nav-link <?php echo $is_active ? 'active' : ''; ?>"
                                    href="<?php echo $item['url']; ?>">
                                    <span class="nav-icon"><?php echo $item['icon']; ?></span>
                                    <span class="nav-text"><?php echo $item['title']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main content wrapper -->
    <main class="main-content">
        <div class="container">
            <!-- Messages Flash -->
            <?php if (function_exists('getFlash') && $success = getFlash('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if (function_exists('getFlash') && $error = getFlash('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>
