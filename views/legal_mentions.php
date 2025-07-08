<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="style.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #00d4ff;
            --secondary-color: #ff006e;
            --accent-color: #7209b7;
            --success-color: #00ff88;
            --warning-color: #ffaa00;
            --danger-color: #ff0040;
            --info-color: #00b4d8;
            --dark-bg: #0a0a0f;
            --dark-card: #1a1a2e;
            --dark-surface: #16213e;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-hover: rgba(255, 255, 255, 0.15);
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --text-muted:rgb(141, 159, 170);
            --text-accent: #e0e6ed;

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #00d4ff 0%, #7209b7 100%);
            --gradient-secondary: linear-gradient(135deg, #ff006e 0%, #00d4ff 100%);
            --gradient-success: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
            --gradient-warning: linear-gradient(135deg, #ffaa00 0%, #ff6b35 100%);
            --gradient-danger: linear-gradient(135deg, #ff0040 0%, #ff006e 100%);
            --gradient-dark: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);

            /* Shadows */
            --shadow-glow: 0 0 30px rgba(0, 212, 255, 0.3);
            --shadow-card: 0 8px 32px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 15px 50px rgba(0, 212, 255, 0.2);
            --shadow-inner: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            --shadow-text: 0 2px 4px rgba(0, 0, 0, 0.5);

            /* Borders */
            --border-glow: 1px solid rgba(0, 212, 255, 0.5);
            --border-subtle: 1px solid rgba(255, 255, 255, 0.1);
            --border-muted: 1px solid rgba(255, 255, 255, 0.05);
            --border-radius: 16px;
            --border-radius-sm: 8px;
            --border-radius-lg: 24px;

            /* Transitions */
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.15s ease;
            --transition-slow: all 0.5s ease;

            /* Spacing */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;
            --spacing-xxl: 3rem;
        }

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
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            text-align: center;
            margin-bottom: var(--spacing-xl);
            animation: glow 2s ease-in-out infinite alternate;
        }

        h2 {
            font-size: clamp(1.5rem, 3vw, 2.5rem);
            color: var(--primary-color);
            position: relative;
            margin-bottom: var(--spacing-lg);
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

        h3 {
            font-size: clamp(1.25rem, 2.5vw, 1.75rem);
            color: var(--text-accent);
            margin-bottom: var(--spacing-md);
        }

        h4 {
            font-size: 1.25rem;
            color: var(--secondary-color);
            margin-bottom: var(--spacing-sm);
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: var(--border-glow);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-card);
            transition: var(--transition);
            overflow: hidden;
            position: relative;
            margin: var(--spacing-md) 0;
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
            background: var(--glass-hover);
        }

        .card-body {
            padding: var(--spacing-xl);
        }

        .tech-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin: 0.25rem;
            background: var(--gradient-primary);
            color: white;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: var(--transition);
            border: none;
        }

        .tech-badge:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
        }

        .tech-badge.backend {
            background: var(--gradient-secondary);
        }

        .tech-badge.database {
            background: var(--gradient-success);
        }

        .tech-badge.tools {
            background: var(--gradient-warning);
        }

        .passion-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius-sm);
            padding: var(--spacing-md);
            margin-bottom: var(--spacing-sm);
            border-left: 4px solid var(--primary-color);
            transition: var(--transition);
        }

        .passion-item:hover {
            background: rgba(0, 212, 255, 0.1);
            transform: translateX(5px);
        }

        .icon-highlight {
            color: var(--primary-color);
            margin-right: var(--spacing-sm);
            font-size: 1.2em;
        }

        .profile-header {
            text-align: center;
            padding: var(--spacing-xxl) 0;
            position: relative;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--spacing-lg);
            font-size: 4rem;
            color: white;
            box-shadow: var(--shadow-glow);
            animation: float 3s ease-in-out infinite;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-lg);
            margin-top: var(--spacing-xl);
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 20px rgba(0, 212, 255, 0.5);
            }

            to {
                text-shadow: 0 0 30px rgba(0, 212, 255, 0.8);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .language-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius-sm);
            padding: 0.5rem 1rem;
            margin: 0.25rem;
            display: inline-block;
            border: var(--border-subtle);
            transition: var(--transition);
        }

        .language-item:hover {
            background: rgba(0, 212, 255, 0.1);
            border-color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .profile-avatar {
                width: 120px;
                height: 120px;
                font-size: 3rem;
            }

            .card-body {
                padding: var(--spacing-lg);
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: var(--spacing-md);
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <!-- En-tête de la page -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h1 class="glow-effect">Mentions Légales</h1>
                    <p class="lead text-secondary">Informations légales concernant ce site portfolio</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Identification de l'éditeur -->
                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-user-circle me-2"></i>
                            Identification de l'éditeur
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong class="text-primary">Nom/Dénomination sociale :</strong><br>
                                    <span class="text-secondary">Enzo Fournier</span>
                                </p>

                                <p><strong class="text-primary">Statut :</strong><br>
                                    <span class="text-secondary">Étudiant</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong class="text-primary">Email :</strong><br>
                                    <span class="text-secondary">enzofournier.contact@gmail.com</span>
                                </p>
                            </div>
                        </div>
                        <div class="bg-glass p-3 rounded border-glow">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            <strong class="text-primary">Directeur de la publication :</strong> <span class="text-secondary">Enzo Fournier</span>
                        </div>
                    </div>
                </div>

                <!-- Hébergement -->
                <div class="card slide-in-left mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-server me-2"></i>
                            Hébergement
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong class="text-primary">Nom de l'hébergeur :</strong><br>
                                    <span class="text-secondary"><a href="https://jrcan.dev" target="_blank" class="text-decoration-none text-reset">JrCanDev</a></span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong class="text-primary">Adresse :</strong><br>
                                    <span class="text-secondary">19 Rue Louis David, 62100 Calais</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Propriété intellectuelle -->
                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-copyright me-2"></i>
                            Propriété intellectuelle
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>L'ensemble de ce site relève de la législation française et internationale sur le droit d'auteur et la propriété intellectuelle. Tous les droits de reproduction sont réservés, y compris pour les documents téléchargeables et les représentations iconographiques et photographiques.</p>

                        <div class="bg-glass p-3 rounded border-glow mt-3">
                            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                            <strong class="text-warning">Important :</strong> <span class="text-secondary">La reproduction de tout ou partie de ce site sur un support électronique quel qu'il soit est formellement interdite sauf autorisation expresse du directeur de la publication.</span>
                        </div>
                    </div>
                </div>

                <!-- Protection des données personnelles -->
                <div class="card slide-in-left mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-shield-alt me-2"></i>
                            Protection des données personnelles
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Ce site portfolio collecte uniquement les données que vous fournissez volontairement via le formulaire de contact (nom, email, message).</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-glass p-3 rounded mb-3">
                                    <h5 class="text-primary">
                                        <i class="fas fa-bullseye me-2"></i>
                                        Finalité
                                    </h5>
                                    <p class="mb-0">Ces données sont utilisées exclusivement pour répondre à votre demande de contact.</p>
                                </div>

                                <div class="bg-glass p-3 rounded mb-3">
                                    <h5 class="text-primary">
                                        <i class="fas fa-clock me-2"></i>
                                        Conservation
                                    </h5>
                                    <p class="mb-0">Vos données sont conservées le temps nécessaire pour traiter votre demande, puis supprimées.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-glass p-3 rounded mb-3">
                                    <h5 class="text-primary">
                                        <i class="fas fa-user-shield me-2"></i>
                                        Vos droits
                                    </h5>
                                    <p class="mb-0">Conformément au RGPD, vous disposez d'un droit d'accès, de rectification et de suppression de vos données.</p>
                                </div>

                                <div class="bg-glass p-3 rounded">
                                    <h5 class="text-primary">
                                        <i class="fas fa-user-tie me-2"></i>
                                        Responsable du traitement
                                    </h5>
                                    <p class="mb-0">Enzo Fournier</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-glass p-3 rounded border-glow mt-3">
                            <i class="fas fa-envelope me-2 text-success"></i>
                            <strong class="text-success">Contact pour vos droits :</strong> <span class="text-secondary">Pour exercer vos droits, contactez-moi à l'adresse : <strong class="text-primary">enzofournier.contact@gmail.com</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Cookies -->
                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-cookie-bite me-2"></i>
                            Cookies
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="bg-glass p-3 rounded border-glow">
                            <i class="fas fa-check-circle me-2 text-success"></i>
                            <strong class="text-success">Aucun cookie utilisé !</strong> <span class="text-secondary">Ce site n'utilise aucun cookie. Aucun système de tracking, d'analyse d'audience ou de publicité n'est mis en place sur ce site portfolio.</span>
                        </div>
                    </div>
                </div>

                <!-- Limitation de responsabilité -->
                <div class="card slide-in-left mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Limitation de responsabilité
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Les informations contenues sur ce site sont aussi précises que possible et le site est périodiquement remis à jour, mais peut toutefois contenir des inexactitudes, des omissions ou des lacunes.</p>

                        <p class="mb-0">Enzo Fournier ne pourra en aucun cas être tenu responsable de tout dommage de quelque nature qu'il soit résultant de l'interprétation ou de l'utilisation des informations et/ou documents disponibles sur ce site.</p>
                    </div>
                </div>

                <!-- Droit applicable -->
                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-balance-scale me-2"></i>
                            Droit applicable
                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Les présentes mentions légales sont régies par le droit français. En cas de litige, les tribunaux français seront seuls compétents.</p>
                    </div>
                </div>

                <!-- Contact -->
                <div class="card slide-in-left mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-phone me-2"></i>
                            Contact
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Pour toute question concernant ce site portfolio, vous pouvez me contacter :</p>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <span class="text-secondary"><strong class="text-success">Par email :</strong> enzofournier.contact@gmail.com</span>
                        </div>
                    </div>
                </div>

                <!-- Footer de la page -->
                <div class="text-center mt-5">
                    <div class="bg-glass p-3 rounded">
                        <p class="mb-0 text-info">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <strong>Dernière mise à jour :</strong> 7 Juillet 2025
                        </p>
                    </div>

                    <div class="mt-4">
                        <a href="/" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>