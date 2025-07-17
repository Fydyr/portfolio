<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($project['title']) ?> - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation de retour -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
        <div class="container">
            <a href="<?= url('projects') ?>" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Retour aux projets
            </a>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="main-content">
        <div class="container">
            <!-- En-tête du projet -->
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="text-center mb-5 fade-in">
                        <h1 class="display-4 text-gradient glow-effect mb-3">
                            <?= htmlspecialchars($project['title']) ?>
                        </h1>
                        <p class="lead text-secondary mb-4">
                            Découvrez les détails de ce projet passionnant
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contenu du projet -->
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="card fade-in">
                        <?php if (!empty($project['img1'])): ?>
                            <div class="position-relative overflow-hidden">
                                <img src="/assets/img/projects/<?= htmlspecialchars($project['img1']) ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($project['title']) ?>"
                                    style="height: 400px; object-fit: cover; transition: transform 0.3s ease;">
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 opacity-0 transition-opacity"
                                    style="transition: opacity 0.3s ease;"
                                    onmouseover="this.style.opacity='1'"
                                    onmouseout="this.style.opacity='0'">
                                    <i class="bi bi-zoom-in text-white" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <!-- Titre du projet -->
                            <div class="mb-4">
                                <h2 class="card-title text-primary mb-3">
                                    <i class="bi bi-code-square icon-highlight"></i>
                                    <?= htmlspecialchars($project['title']) ?>
                                </h2>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <h3 class="h5 text-accent mb-3">
                                    <i class="bi bi-file-text icon-highlight"></i>
                                    Description du projet
                                </h3>
                                <div class="project-description">
                                    <p class="text-secondary lh-lg">
                                        <?= nl2br(htmlspecialchars($project['description'])) ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Technologies utilisées (si disponible) -->
                            <?php if (!empty($project['languages'])): ?>
                                <div class="mb-4">
                                    <h3 class="h5 text-accent mb-3">
                                        <i class="bi bi-gear icon-highlight"></i>
                                        Langages utilisées
                                    </h3>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach (explode(',', $project['languages']) as $tech): ?>
                                            <span class="tech-badge"><?= trim(htmlspecialchars($tech)) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Galerie d'images supplémentaires -->
                            <?php if (!empty($project['img2']) || !empty($project['img3'])): ?>
                                <div class="mb-4">
                                    <h3 class="h5 text-accent mb-3">
                                        <i class="bi bi-images icon-highlight"></i>
                                        Galerie
                                    </h3>
                                    <div class="row g-3">
                                        <?php if (!empty($project['img2'])): ?>
                                            <div class="col-md-6">
                                                <img src="/assets/img/projects/<?= htmlspecialchars($project['img2']) ?>"
                                                    class="img-fluid rounded shadow-card"
                                                    alt="<?= htmlspecialchars($project['title']) ?> - Image 2"
                                                    style="height: 200px; object-fit: cover; width: 100%;">
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($project['img3'])): ?>
                                            <div class="col-md-6">
                                                <img src="/assets/img/projects/<?= htmlspecialchars($project['img3']) ?>"
                                                    class="img-fluid rounded shadow-card"
                                                    alt="<?= htmlspecialchars($project['title']) ?> - Image 3"
                                                    style="height: 200px; object-fit: cover; width: 100%;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Actions -->
                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                <?php if (!empty($project['link'])): ?>
                                    <a href="<?= htmlspecialchars($project['link']) ?>"
                                        class="btn btn-primary btn-lg"
                                        target="_blank">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                        Voir le projet
                                    </a>
                                <?php endif; ?>

                                <a href="<?= url('projects') ?>"
                                    class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                    Autres projets
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section similaire ou recommandations -->
            <div class="row justify-content-center mt-5">
                <div class="col-lg-10 col-xl-8">
                    <div class="text-center">
                        <h2 class="text-gradient mb-4">Explorez d'autres projets</h2>
                        <p class="text-secondary mb-4">
                            Découvrez mes autres réalisations et projets passionnants
                        </p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="<?= url('projects') ?>" class="btn btn-outline-primary">
                                <i class="bi bi-collection"></i> Tous les projets
                            </a>
                            <a href="<?= url('contact') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-envelope"></i> Me contacter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour les animations -->
    <script>
        // Animation d'apparition au scroll
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

        // Observer tous les éléments avec animation
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // Effet hover sur l'image principale
        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.querySelector('.card-img-top');
            if (mainImage) {
                mainImage.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                mainImage.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            }
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>