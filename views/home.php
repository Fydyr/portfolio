<?php ob_start();

// Calcul dynamique de l'âge
$birthDate = new DateTime('2005-03-15');
$today = new DateTime();
$age = $today->diff($birthDate)->y;

// Liste des langages
$languages = [
    'JavaScript',
    'TypeScript',
    'Python',
    'PHP',
    'Java',
    'C',
    'SQL',
    'HTML/CSS',
    'Bash',
    'Dart',
];

$languageCount = count($languages);
?>

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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Bonjour, je suis<br>Enzo Fournier
                </h1>
                <p class="hero-subtitle">
                    Étudiant en BUT Informatique, spécialisé dans le développement web backend & la création d'applications.
                </p>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?= $age ?></div>
                        <div class="stat-label">Ans</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">3e</div>
                        <div class="stat-label">Année BUT Info</div>
                    </div>
                    <a href="#langages" class="stat-card" style="text-decoration: none; color: inherit; transition: transform 0.3s ease;">
                        <div class="stat-number"><?= $languageCount ?></div>
                        <div class="stat-label">Langages</div>
                    </a>
                    <a href="<?= url('projects') ?>" class="stat-card" style="text-decoration: none; color: inherit; transition: transform 0.3s ease;">
                        <div class="stat-number"><?= $projectCount ?? 0 ?></div>
                        <div class="stat-label">Projets visible</div>
                    </a>
                </div>

                <div class="hero-cta">
                    <a href="<?= url('projects') ?>" class="btn btn-hero btn-hero-primary">
                        <i class="fas fa-folder-open"></i>
                        Voir mes projets
                    </a>
                    <a href="<?= url('contact') ?>" class="btn btn-hero btn-hero-secondary">
                        <i class="fas fa-envelope"></i>
                        Me contacter
                    </a>
                </div>

                <div class="social-links">
                    <a href="https://github.com/Fydyr" target="_blank" class="social-link">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/enzo-fournier-2746ba2b3/" target="_blank" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://discord.gg/RT2XsGFFEr" target="_blank" class="social-link">
                        <i class="fab fa-discord"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="py-5" id="langages">
        <div class="container">
            <div class="section-header">
                <a href="#langages" class="section-badge" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-laptop-code me-2"></i>
                    Compétences
                </a>
                <h2 class="section-title">Stack Technique</h2>
                <p class="section-description">
                    Technologies et outils que j'utilise pour créer des solutions innovantes
                </p>
            </div>

            <div class="skills-container">
                <div class="skill-card">
                    <div class="skill-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="skill-title">Langages</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">Langages de programmation maîtrisés</p>
                    <div class="skill-tags">
                        <?php foreach ($languages as $lang): ?>
                            <span class="skill-tag"><?= htmlspecialchars($lang) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="skill-card">
                    <div class="skill-icon" style="background: var(--gradient-secondary);">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="skill-title">Développement Web</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">Frontend & Backend</p>
                    <div class="skill-tags">
                        <span class="skill-tag">Vue.js</span>
                        <span class="skill-tag">Bootstrap</span>
                        <span class="skill-tag">Node.js</span>
                        <span class="skill-tag">Express</span>
                        <span class="skill-tag">PHP</span>
                        <span class="skill-tag">Flutter</span>
                    </div>
                </div>

                <div class="skill-card">
                    <div class="skill-icon" style="background: var(--gradient-warning);">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="skill-title">Bases de données</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">Systèmes de gestion de données</p>
                    <div class="skill-tags">
                        <span class="skill-tag">MySQL</span>
                        <span class="skill-tag">MongoDB</span>
                        <span class="skill-tag">PostgreSQL</span>
                    </div>
                </div>

                <div class="skill-card">
                    <div class="skill-icon" style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="skill-title">Outils</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">DevOps et environnements</p>
                    <div class="skill-tags">
                        <span class="skill-tag">Git</span>
                        <span class="skill-tag">Docker</span>
                        <span class="skill-tag">VS Code</span>
                        <span class="skill-tag">Postman</span>
                        <span class="skill-tag">Figma</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Passions Section -->
    <section class="py-5" id="passions" style="background: linear-gradient(180deg, transparent 0%, rgba(30, 41, 59, 0.3) 50%, transparent 100%);">
        <div class="container">
            <div class="section-header">
                <a href="#passions" class="section-badge" style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.3); color: #EF4444; text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-heart me-2"></i>
                    Passions
                </a>
                <h2 class="section-title">Au-delà du code</h2>
                <p class="section-description">
                    Ce qui me passionne et m'inspire au quotidien
                </p>
            </div>

            <div class="passions-grid">
                <div class="passion-card">
                    <div class="passion-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h3 class="passion-title">Gaming</h3>
                    <p class="passion-description">Jeux de stratégie</p>
                </div>

                <div class="passion-card">
                    <div class="passion-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <h3 class="passion-title">Musique</h3>
                    <p class="passion-description">Musique de jeu, d'animé et de pop rock</p>
                </div>

                <div class="passion-card">
                    <div class="passion-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="passion-title">Sci-Fi</h3>
                    <p class="passion-description">Science-fiction et univers futuristes (comme star wars)</p>
                </div>

                <div class="passion-card">
                    <div class="passion-icon">
                        <i class="fas fa-dice-d20"></i>
                    </div>
                    <h3 class="passion-title">Magic: The Gathering</h3>
                    <p class="passion-description">Jeu de cartes stratégique</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Timeline -->
    <section class="py-5" id="formation">
        <div class="container">
            <div class="section-header">
                <a href="#formation" class="section-badge" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Formation
                </a>
                <h2 class="section-title">Parcours Académique</h2>
                <p class="section-description">
                    Mon cheminement dans le monde de l'informatique
                </p>
            </div>

            <div class="timeline-modern">
                <div class="timeline-item-modern">
                    <div class="timeline-content-modern">
                        <span class="timeline-date">2023 - 2026</span>
                        <h3 class="timeline-title">BUT Informatique</h3>
                        <div class="timeline-subtitle">IUT de Calais • En cours</div>
                        <p class="timeline-description">
                            Formation universitaire technologique spécialisée en informatique avec focus sur le développement, les bases de données et la gestion de projets.
                        </p>
                    </div>
                </div>

                <div class="timeline-item-modern">
                    <div class="timeline-content-modern">
                        <span class="timeline-date">2020 - 2023</span>
                        <h3 class="timeline-title">Baccalauréat Général</h3>
                        <div class="timeline-subtitle">Lycée Mariette, Boulogne-Sur-Mer • Obtenu</div>
                        <p class="timeline-description">
                            Spécialités Mathématiques et NSI (Numérique et Sciences Informatiques) avec initiation à Python et à l'algorithmique.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container">
            <div class="card" style="background: var(--gradient-primary); border: none; text-align: center;">
                <div class="card-body" style="padding: 4rem 2rem;">
                    <h2 style="color: white; font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 800; margin-bottom: 1.5rem;">
                        Intéressé par mon profil ?
                    </h2>
                    <p style="color: rgba(255, 255, 255, 0.9); font-size: 1.125rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                        N'hésitez pas à consulter mon CV ou à découvrir mes projets
                    </p>
                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <a href="../assets/docs/mon_cv.pdf" class="btn btn-hero" style="background: white; color: var(--primary-color);" target="_blank" download="mon_cv.pdf">
                            <i class="fas fa-file-download"></i>
                            Télécharger mon CV
                        </a>
                        <a href="<?= url('projects') ?>" class="btn btn-hero" style="background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid white;">
                            <i class="fas fa-folder-open"></i>
                            Voir mes projets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scroll animations
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

        document.querySelectorAll('.skill-card, .stat-card, .timeline-item-modern').forEach(el => {
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
