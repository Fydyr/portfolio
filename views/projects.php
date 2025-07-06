<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enzo Fournier - Développeur</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

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
            --text-muted: #666b6e;
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

<!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>