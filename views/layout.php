<?php
// Configuration du site
$site_title = "Mon Site MVC";
$site_tagline = "Architecture MVC • Performance • Innovation";
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Navigation items basée sur votre structure MVC
$nav_items = [
    'index' => ['title' => 'Accueil', 'icon' => '🏠', 'url' => homeUrl()],
    'about' => ['title' => 'À propos', 'icon' => '📋', 'url' => url('about')],
    'users' => ['title' => 'Utilisateurs', 'icon' => '👥', 'url' => url('users')],
    'products' => ['title' => 'Produits', 'icon' => '📦', 'url' => url('products')]
];

// Gestion de l'authentification pour la navigation
if (isset($_SESSION['admin'])) {
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
    <meta name="description" content="Application MVC moderne avec interface futuriste">
    <meta name="keywords" content="MVC, PHP, application web, interface futuriste">
    <meta name="author" content="<?php echo $site_title; ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
    <meta property="og:title" content="<?php echo $title ?? $site_title; ?>">
    <meta property="og:description" content="<?php echo $site_tagline; ?>">
    <meta property="og:image" content="/assets/images/og-image.jpg">

    <title><?= $title ?? $site_title ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS futuriste intégré -->
    <style>
        /* Variables CSS futuristes */
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
            --shadow-hover: 0 15px 50px rgba(0, 212, 255, 0.2);
            --border-glow: 1px solid rgba(0, 212, 255, 0.5);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset et base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-bg);
            background-image:
                radial-gradient(circle at 20% 50%, rgba(120, 9, 183, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 0, 110, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(0, 212, 255, 0.2) 0%, transparent 50%);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Header futuriste */
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

        .brand-tagline {
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin: 0;
            font-weight: 300;
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

        .nav-icon {
            font-size: 1rem;
        }

        /* Alerts futuristes */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            backdrop-filter: blur(20px);
            margin: 1rem 0;
            padding: 1rem 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
        }

        .alert-success {
            background: rgba(0, 255, 136, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(0, 255, 136, 0.3);
        }

        .alert-success::before {
            background: var(--gradient-success);
        }

        .alert-error {
            background: rgba(255, 0, 64, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(255, 0, 64, 0.3);
        }

        .alert-error::before {
            background: linear-gradient(135deg, #ff0040 0%, #ff006e 100%);
        }

        /* Boutons futuristes */
        .btn {
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
            text-decoration: none;
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

        /* Cards futuristes */
        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: var(--border-glow);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-card);
            transition: var(--transition);
            overflow: hidden;
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

        /* Tables futuristes */
        .table {
            background: transparent;
            color: var(--text-primary);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin: 1rem 0;
        }

        .table thead th {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .table tbody tr {
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background: rgba(0, 212, 255, 0.1);
            transform: scale(1.01);
        }

        .table td {
            padding: 1rem;
            border: none;
            vertical-align: middle;
        }

        /* Formulaires futuristes */
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 0.875rem 1rem;
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
            color: var(--text-primary);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        /* Grid responsive */
        .grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }

        /* Main content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding-top: 2rem;
        }

        /* Footer simple mais futuriste */
        .footer-simple {
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(20px);
            border-top: var(--border-glow);
            padding: 2rem 0;
            margin-top: 4rem;
        }

        .footer-simple::before {
            content: '';
            position: absolute;
            bottom: 0;
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

        /* Effets spéciaux */
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

            .brand-tagline {
                font-size: 0.7rem;
            }

            .navbar-nav .nav-link {
                justify-content: center;
            }
        }

        /* Custom toggler */
        .navbar-toggler {
            border: none;
            padding: 0.25rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }
    </style>
</head>

<body class="<?php echo $current_page; ?>-page">

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
                            <p class="brand-tagline"><?php echo $site_tagline; ?></p>
                        </div>
                    </div>
                </a>

                <!-- Toggle pour mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation principale -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php foreach ($nav_items as $page => $item): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], $page) !== false) ? 'active' : ''; ?>"
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
            <!-- Messages Flash avec style futuriste -->
            <?php if ($success = getFlash('success')): ?>
                <div class="alert alert-success animate__animated animate__fadeInDown">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <?php if ($error = getFlash('error')): ?>
                <div class="alert alert-error animate__animated animate__fadeInDown">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <!-- Contenu de la page -->
            <?= $content ?? '' ?>
        </div>
    </main>

    <!-- Footer simple -->
    <footer class="footer-simple">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand"><?php echo $site_title; ?></div>
                <p>&copy; <?php echo date('Y'); ?> Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script de base -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts après 5 secondes
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('animate__fadeOutUp');
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // Navigation active dynamique
            const navLinks = document.querySelectorAll('.nav-link');
            const currentUrl = window.location.href;

            navLinks.forEach(link => {
                if (currentUrl.includes(link.getAttribute('href'))) {
                    link.classList.add('active');
                }
            });
        });
    </script>

</body>

</html>