<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="profile-header fade-in">
            <div class="profile-avatar">
                <i class="fas fa-code"></i>
            </div>
            <h1>Enzo Fournier</h1>
            <h2>👋 Hey salut moi c'est Enzo Fournier</h2>
            <p class="lead text-secondary">Développeur passionné • 2e année BUT Informatique • @fydyr</p>
        </div>

        <div class="container">
            <div class="info-grid">
                <!-- Section Qui suis-je -->
                <div class="card fade-in">
                    <div class="card-body">
                        <h3><i class="fas fa-user icon-highlight"></i>Qui suis-je ?</h3>
                        <div class="passion-item">
                            <strong><i class="fas fa-at icon-highlight"></i>Pseudo :</strong> fydyr
                        </div>
                        <div class="passion-item">
                            <strong><i class="fas fa-map-marker-alt icon-highlight"></i>Localisation :</strong> France
                        </div>
                        <div class="passion-item">
                            <strong><i class="fas fa-birthday-cake icon-highlight"></i>Âge :</strong> 20 ans
                        </div>
                        <div class="passion-item">
                            <strong><i class="fas fa-graduation-cap icon-highlight"></i>Formation :</strong> 2e année de BUT informatique
                        </div>
                    </div>
                </div>

                <!-- Section Langages -->
                <div class="card fade-in">
                    <div class="card-body">
                        <h3><i class="fas fa-code icon-highlight"></i>Langages utilisés</h3>
                        <div class="mt-3">
                            <span class="language-item">JavaScript/TypeScript</span>
                            <span class="language-item">Python</span>
                            <span class="language-item">PHP</span>
                            <span class="language-item">HTML/CSS</span>
                            <span class="language-item">C</span>
                            <span class="language-item">C++</span>
                            <span class="language-item">Java</span>
                            <span class="language-item">Dart</span>
                        </div>
                    </div>
                </div>

                <!-- Section Technologies Frontend -->
                <div class="card fade-in">
                    <div class="card-body">
                        <h3><i class="fas fa-palette icon-highlight"></i>Frontend</h3>
                        <div class="mt-3">
                            <span class="tech-badge">Vue.js</span>
                            <span class="tech-badge">Flutter</span>
                            <span class="tech-badge">Bootstrap</span>
                        </div>
                    </div>
                </div>

                <!-- Section Technologies Backend -->
                <div class="card fade-in">
                    <div class="card-body">
                        <h3><i class="fas fa-server icon-highlight"></i>Backend</h3>
                        <div class="mt-3">
                            <span class="tech-badge backend">Node.js</span>
                            <span class="tech-badge backend">Express</span>
                        </div>
                    </div>
                </div>

                <!-- Section Base de données -->
                <div class="card fade-in">
                    <div class="card-body">
                        <h3><i class="fas fa-database icon-highlight"></i>Base de données</h3>
                        <div class="mt-3">
                            <span class="tech-badge database">MySQL</span>
                            <span class="tech-badge database">MongoDB</span>
                            <span class="tech-badge database">PostgreSQL</span>
                        </div>
                    </div>
                </div>

                <!-- Section Outils -->
                <div class="card fade-in">
                    <div class="card-body">
                        <h3><i class="fas fa-tools icon-highlight"></i>Outils</h3>
                        <div class="mt-3">
                            <span class="tech-badge tools">Git</span>
                            <span class="tech-badge tools">Docker</span>
                            <span class="tech-badge tools">VS Code</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Passions -->
            <div class="card fade-in mt-5">
                <div class="card-body">
                    <h3><i class="fas fa-heart icon-highlight"></i>Mes passions</h3>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="passion-item">
                                <strong><i class="fas fa-music icon-highlight"></i>Musique :</strong> Musique de jeux
                            </div>
                            <div class="passion-item">
                                <strong><i class="fas fa-gamepad icon-highlight"></i>Gaming :</strong> Jeux de réflexion, de stratégie, de musique et d'action
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="passion-item">
                                <strong><i class="fas fa-book icon-highlight"></i>Lecture :</strong> Science-fiction
                            </div>
                            <div class="passion-item">
                                <strong><i class="fas fa-dice-d20 icon-highlight"></i>Jeu de société :</strong> Magic the Gathering
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Animation d'apparition progressive des cartes
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

        // Observer toutes les cartes
        document.querySelectorAll('.card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Effet de brillance sur les badges technologiques
        document.querySelectorAll('.tech-badge, .language-item').forEach(badge => {
            badge.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 0 20px rgba(0, 212, 255, 0.5)';
            });

            badge.addEventListener('mouseleave', function() {
                this.style.boxShadow = '';
            });
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>