<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        .projects-hero {
            text-align: center;
            padding: 4rem 0 3rem;
            position: relative;
        }

        .projects-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
        }

        .projects-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .projects-subtitle {
            color: var(--text-secondary);
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .project-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: var(--border-glow);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            position: relative;
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: var(--transition);
        }

        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-glow);
            border-color: var(--primary-color);
            text-decoration: none;
        }

        .project-card:hover::before {
            opacity: 1;
        }

        .project-image {
            position: relative;
            width: 100%;
            height: 280px;
            overflow: hidden;
            background: var(--dark-card);
        }

        .project-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .project-card:hover .project-image img {
            transform: scale(1.1);
        }

        .project-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
            opacity: 0;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .project-card:hover .project-image-overlay {
            opacity: 1;
        }

        .project-view-btn {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            transform: translateY(10px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .project-card:hover .project-view-btn {
            transform: translateY(0);
            opacity: 1;
        }

        .project-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .project-title {
            color: var(--text-primary);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            line-height: 1.3;
        }

        .project-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
            flex: 1;
            margin-bottom: 0;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-state-title {
            color: var(--text-secondary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state-description {
            color: var(--text-muted);
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .projects-hero {
                padding: 2rem 0 1.5rem;
            }

            .project-image {
                height: 220px;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="projects-hero">
        <div class="container">
            <div class="projects-badge">
                <i class="fas fa-folder-open"></i>
                Portfolio
            </div>
            <h1 class="projects-title">Mes Projets</h1>
            <p class="projects-subtitle">
                Découvrez les projets que j'ai réalisés, allant du développement backend aux applications complètes
            </p>
        </div>
    </section>

    <!-- Projects Grid -->
    <section class="py-4">
        <div class="container">
            <?php if (empty($projects)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h2 class="empty-state-title">Aucun projet disponible</h2>
                    <p class="empty-state-description">Les projets seront bientôt disponibles</p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($projects as $project): ?>
                        <div class="col-md-6 col-lg-4">
                            <a href="<?= url('project-detail/' . $project['id']) ?>" class="project-card">
                                <div class="project-image">
                                    <img src="/assets/img/projects/<?= htmlspecialchars($project['img1']) ?>"
                                         alt="<?= htmlspecialchars($project['title']) ?>">
                                    <div class="project-image-overlay">
                                        <button class="project-view-btn">
                                            <i class="fas fa-eye me-2"></i>
                                            Voir le projet
                                        </button>
                                    </div>
                                </div>
                                <div class="project-body">
                                    <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
                                    <p class="project-description">
                                        <?= htmlspecialchars(mb_strimwidth($project['description'], 0, 120, '...')) ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.project-card').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
            observer.observe(el);
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>