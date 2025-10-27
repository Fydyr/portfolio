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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Back Navigation -->
    <nav class="back-nav">
        <div class="container">
            <a href="<?= url('projects') ?>" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Retour aux projets
            </a>
        </div>
    </nav>

    <!-- Project Header -->
    <header class="project-header fade-in-up">
        <div class="container">
            <div class="project-category">
                <i class="fas fa-cube me-2"></i>
                Projet
            </div>
            <h1 class="project-title">
                <?= htmlspecialchars($project['title']) ?>
            </h1>
            <p class="project-lead">
                Découvrez les détails de ce projet, les technologies utilisées et les résultats obtenus
            </p>
        </div>
    </header>

    <!-- Main Image -->
    <?php
    $images = [];
    if (!empty($project['img1'])) $images[] = htmlspecialchars($project['img1']);
    if (!empty($project['img2'])) $images[] = htmlspecialchars($project['img2']);
    if (!empty($project['img3'])) $images[] = htmlspecialchars($project['img3']);
    ?>

    <?php if (!empty($images)): ?>
        <div class="container">
            <div class="project-image-main fade-in-up" onclick="openLightbox(0)">
                <img src="/assets/img/projects/<?= $images[0] ?>" alt="<?= htmlspecialchars($project['title']) ?>">
            </div>
        </div>
    <?php endif; ?>

    <!-- Project Content -->
    <div class="container project-content">
        <!-- Description Section -->
        <div class="content-section fade-in-up">
            <span class="section-label">
                <i class="fas fa-file-alt me-2"></i>
                Description
            </span>
            <h2 class="section-title">À propos du projet</h2>
            <div class="gradient-divider"></div>
            <p class="section-text">
                <?= nl2br(htmlspecialchars($project['description'])) ?>
            </p>
        </div>

        <!-- Technologies Section -->
        <?php if (!empty($project['languages'])): ?>
            <div class="content-section fade-in-up">
                <span class="section-label">
                    <i class="fas fa-code me-2"></i>
                    Stack Technique
                </span>
                <h2 class="section-title">Technologies utilisées</h2>
                <div class="gradient-divider"></div>
                <div class="tech-stack">
                    <?php foreach (explode(',', $project['languages']) as $tech): ?>
                        <span class="tech-tag">
                            <i class="fas fa-check-circle"></i>
                            <?= trim(htmlspecialchars($tech)) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Gallery Section -->
        <?php if (count($images) > 1): ?>
            <div class="content-section fade-in-up">
                <span class="section-label">
                    <i class="fas fa-images me-2"></i>
                    Galerie
                </span>
                <h2 class="section-title">Aperçus du projet</h2>
                <div class="gradient-divider"></div>
                <div class="gallery-grid">
                    <?php foreach ($images as $i => $img): ?>
                        <div class="gallery-item" onclick="openLightbox(<?= $i ?>)">
                            <img src="/assets/img/projects/<?= $img ?>" alt="<?= htmlspecialchars($project['title']) ?> - Image <?= $i + 1 ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Action Buttons -->
    <div class="project-actions">
        <?php if (!empty($project['link'])): ?>
            <a href="<?= htmlspecialchars($project['link']) ?>" class="btn-action btn-action-primary" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                Voir le projet en ligne
            </a>
        <?php endif; ?>
        <a href="<?= url('projects') ?>" class="btn-action btn-action-secondary">
            <i class="fas fa-th-large"></i>
            Tous les projets
        </a>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox">
        <button class="lightbox-btn close" onclick="closeLightbox()">
            <i class="fas fa-times"></i>
        </button>
        <button class="lightbox-btn prev" onclick="prevImage()">
            <i class="fas fa-chevron-left"></i>
        </button>
        <img id="lightbox-img" src="" alt="">
        <button class="lightbox-btn next" onclick="nextImage()">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        const images = <?= json_encode($images) ?>;
        let currentIndex = 0;

        function openLightbox(index) {
            currentIndex = index;
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            lightboxImg.src = `/assets/img/projects/${images[index]}`;
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            openLightbox(currentIndex);
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % images.length;
            openLightbox(currentIndex);
        }

        // Close lightbox on background click
        document.getElementById('lightbox').addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') closeLightbox();
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox').style.display === 'flex') {
                if (e.key === 'ArrowLeft') prevImage();
                if (e.key === 'ArrowRight') nextImage();
                if (e.key === 'Escape') closeLightbox();
            }
        });

        // Scroll animations
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

        document.querySelectorAll('.content-section, .project-image-main, .gallery-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>
