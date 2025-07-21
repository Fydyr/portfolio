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

    <meta property="og:title" content="<?= htmlspecialchars($project['title']) ?>" />
    <meta property="og:description" content="<?= htmlspecialchars(mb_strimwidth($project['description'], 0, 100, '...')) ?>" />
    <meta property="og:image" content="/assets/img/projects/<?= htmlspecialchars($project['img1']) ?>" />

    <meta name="twitter:title" content="<?= htmlspecialchars($project['title']) ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars(mb_strimwidth($project['description'], 0, 100, '...')) ?>" />
    <meta name="twitter:image" content="/assets/img/projects/<?= htmlspecialchars($project['img1']) ?>" />
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
                        <div class="position-relative overflow-hidden">
                            <?php $images = [];
                            if (!empty($project['img1'])) $images[] = htmlspecialchars($project['img1']);
                            if (!empty($project['img2'])) $images[] = htmlspecialchars($project['img2']);
                            if (!empty($project['img3'])) $images[] = htmlspecialchars($project['img3']); ?>

                            <?php if (!empty($images)): ?>
                                <img src="/assets/img/projects/<?= $images[0] ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($project['title']) ?>"
                                    style="height: 400px; object-fit: cover; transition: transform 0.3s ease; cursor: zoom-in;"
                                    onclick="openLightbox(0)">
                            <?php endif; ?>
                        </div>

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
                                <h3 class="h5 text-primary mb-3">
                                    <i class="bi bi-file-text icon-highlight"></i>
                                    Description du projet
                                </h3>
                                <div class="project-description">
                                    <p class="text-secondary lh-lg">
                                        <?= nl2br(htmlspecialchars($project['description'])) ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Langages utilisées (si disponible) -->
                            <?php if (!empty($project['languages'])): ?>
                                <div class="mb-4">
                                    <h3 class="h5 text-primary mb-3">
                                        <i class="bi bi-gear icon-highlight"></i>
                                        Technologies utilisées
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
                                    <h3 class="h5 text-primary mb-3">
                                        <i class="bi bi-images icon-highlight"></i>
                                        Galerie
                                    </h3>
                                    <div class="row g-3">
                                        <?php foreach ($images as $i => $img): ?>
                                            <div class="col-md-6">
                                                <img src="/assets/img/projects/<?= $img ?>"
                                                    class="img-fluid rounded shadow-card"
                                                    alt="<?= htmlspecialchars($project['title']) ?> - Image <?= $i + 1 ?>"
                                                    style="height: 200px; object-fit: cover; width: 100%; cursor: zoom-in;"
                                                    onclick="openLightbox(<?= $i ?>)">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Actions -->
                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                <?php if (!empty($project['link'])): ?>
                                    <a href="<?= htmlspecialchars($project['link']) ?>"
                                        class="btn btn-primary btn-lg" target="_blank">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                        Voir le projet
                                    </a>
                                <?php endif; ?>
                                <a href="<?= url('projects') ?>" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                    Autres projets
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Lightbox HTML -->
    <div id="lightbox" class="lightbox">
        <button class="close" onclick="closeLightbox()">&times;</button>
        <button class="prev" onclick="prevImage()">&#10094;</button>
        <img id="lightbox-img" src="" alt="">
        <button class="next" onclick="nextImage()">&#10095;</button>
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
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            openLightbox(currentIndex);
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % images.length;
            openLightbox(currentIndex);
        }

        document.getElementById('lightbox').addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') closeLightbox();
        });

        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox').style.display === 'flex') {
                if (e.key === 'ArrowLeft') prevImage();
                if (e.key === 'ArrowRight') nextImage();
                if (e.key === 'Escape') closeLightbox();
            }
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>