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

            <!-- Section Parcours scolaire -->
            <div class="card fade-in mt-5">
                <div class="card-body">
                    <h3><i class="fas fa-graduation-cap icon-highlight"></i>Parcours scolaire</h3>

                    <div class="timeline">
                        <!-- Études actuelles -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="status-badge">En cours</div>
                                <div class="timeline-period">2023 - 2026</div>
                                <div class="timeline-title">BUT Informatique</div>
                                <div class="timeline-subtitle">IUT de Calais</div>
                                <div class="timeline-description">
                                    Formation universitaire technologique spécialisée en informatique.
                                    Actuellement en 2e année, apprentissage approfondi du développement web,
                                    des bases de données, de l'algorithmique et des méthodologies de projet.
                                </div>
                                <div class="timeline-details">
                                    <span class="detail-badge"><i class="fas fa-code"></i> Développement</span>
                                    <span class="detail-badge"><i class="fas fa-database"></i> Base de données</span>
                                    <span class="detail-badge"><i class="fas fa-project-diagram"></i> Gestion de projet</span>
                                    <span class="detail-badge"><i class="fas fa-network-wired"></i> Réseaux</span>
                                </div>
                            </div>
                        </div>

                        <!-- Baccalauréat -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="status-badge completed">Obtenu</div>
                                <div class="timeline-period">2020 - 2023</div>
                                <div class="timeline-title">Baccalauréat Général</div>
                                <div class="timeline-subtitle">Lycée Mariette - Boulogne-Sur-Mer</div>
                                <div class="timeline-description">
                                    Baccalauréat général avec spécialités Mathématiques et NSI (Numérique et Sciences Informatiques).
                                    Formation solide en sciences et découverte approfondie de la programmation.
                                </div>
                                <div class="timeline-details">
                                    <span class="detail-badge"><i class="fas fa-square-root-alt"></i> Mathématiques</span>
                                    <span class="detail-badge"><i class="fas fa-microchip"></i> NSI</span>
                                    <span class="detail-badge"><i class="bi bi-filetype-py"></i> Python</span>
                                    <span class="detail-badge"><i class="fas fa-chart-line"></i> Algorithmique</span>
                                </div>
                            </div>
                        </div>

                        <!-- Collège -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="status-badge completed">Obtenu</div>
                                <div class="timeline-period">2016 - 2020</div>
                                <div class="timeline-title">Diplôme National du Brevet</div>
                                <div class="timeline-subtitle">Collège Pilâtre de Rozier - Wimille</div>
                                <div class="timeline-description">
                                    Formation secondaire complète avec acquisition des fondamentaux
                                    en sciences, littérature et découverte de la technologie.
                                </div>
                                <div class="timeline-details">
                                    <span class="detail-badge"><i class="fas fa-atom"></i> Sciences</span>
                                    <span class="detail-badge"><i class="fas fa-book-open"></i> Littérature</span>
                                    <span class="detail-badge"><i class="fas fa-cogs"></i> Technologie</span>
                                    <span class="detail-badge"><i class="fas fa-globe"></i> Langues</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lien vers les réseaux sociaux -->
            <div class="card fade-in mb-4">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        Mes réseaux sociaux
                    </h2>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <h3 class="text-primary">
                                <a href="https://github.com/Fydyr" target="_blank" class="text-decoration-none">
                                    <i class="fab fa-github text-muted me-2"></i>
                                    Github
                                </a>
                            </h3>
                            <p class="text-muted small">Découvrez mes projets open source</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h3 class="text-primary">
                                <a href="https://www.linkedin.com/in/enzo-fournier-2746ba2b3/" target="_blank" class="text-decoration-none">
                                    <i class="fab fa-linkedin-in text-muted me-2"></i>
                                    Linkedin
                                </a>
                            </h3>
                            <p class="text-muted small">Mon profil professionnel</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h3 class="text-primary">
                                <a href="https://discord.gg/RT2XsGFFEr" target="_blank" class="text-decoration-none">
                                    <i class="fab fa-discord text-muted me-2"></i>
                                    Discord
                                </a>
                            </h3>
                            <p class="text-muted small">Rejoignez ma communauté</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section qui mène à mon CV -->
            <div class="card fade-in mt-5">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fas fa-file-alt icon-highlight"></i>
                        Mon CV
                    </h2>
                </div>
                <div class="card-body">
                    <p>Pour en savoir plus sur mon parcours, mes compétences et mes expériences, consultez mon CV.</p>
                    <a href="../assets/docs/mon_cv.pdf" class="btn btn-primary" target="_blank">
                        <i class="fas fa-file-download"></i> Télécharger le CV
                    </a>
                </div>
            </div>

            <!-- Section qui mène aux projets -->
            <div class="card fade-in mt-5">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fas fa-project-diagram icon-highlight"></i>
                        Mes projets
                    </h2>
                </div>
                <div class="card-body">
                    <p>Découvrez mes projets récents et mes contributions open source.</p>
                    <a href="<?= url('projects') ?>" class="btn btn-primary">
                        <i class="fas fa-folder-open"></i> Voir les projets
                    </a>
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

        // Animation au scroll pour les éléments de timeline
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, {
            threshold: 0.2
        });

        document.querySelectorAll('.timeline-item').forEach(item => {
            item.style.animationPlayState = 'paused';
            timelineObserver.observe(item);
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>