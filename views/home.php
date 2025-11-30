<?php ob_start();

// Calcul dynamique de l'âge
$birthDate = new DateTime('2005-03-15');
$today = new DateTime();
$age = $today->diff($birthDate)->y;

// Liste des langages
$languages = [
    'Python',
    'HTML/CSS',
    'PHP',
    'JavaScript',
    'TypeScript',
    'SQL',
    'Java',
    'C',
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
                            <span class="skill-tag tech-badge" data-tech="<?= strtolower(str_replace(['/', ' '], ['-', '-'], htmlspecialchars($lang))) ?>"><?= htmlspecialchars($lang) ?></span>
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
                        <span class="skill-tag tech-badge" data-tech="vuejs">Vue.js</span>
                        <span class="skill-tag tech-badge" data-tech="bootstrap">Bootstrap</span>
                        <span class="skill-tag tech-badge" data-tech="nodejs">Node.js</span>
                        <span class="skill-tag tech-badge" data-tech="express">Express</span>
                        <span class="skill-tag tech-badge" data-tech="php">PHP</span>
                        <span class="skill-tag tech-badge" data-tech="flutter">Flutter</span>
                    </div>
                </div>

                <div class="skill-card">
                    <div class="skill-icon" style="background: var(--gradient-warning);">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="skill-title">Bases de données</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">Systèmes de gestion de données</p>
                    <div class="skill-tags">
                        <span class="skill-tag tech-badge" data-tech="mysql">MySQL</span>
                        <span class="skill-tag tech-badge" data-tech="mongodb">MongoDB</span>
                        <span class="skill-tag tech-badge" data-tech="postgresql">PostgreSQL</span>
                    </div>
                </div>

                <div class="skill-card">
                    <div class="skill-icon" style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="skill-title">Outils</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem;">DevOps et environnements</p>
                    <div class="skill-tags">
                        <span class="skill-tag tech-badge" data-tech="git">Git</span>
                        <span class="skill-tag tech-badge" data-tech="docker">Docker</span>
                        <span class="skill-tag tech-badge" data-tech="vscode">VS Code</span>
                        <span class="skill-tag tech-badge" data-tech="postman">Postman</span>
                        <span class="skill-tag tech-badge" data-tech="figma">Figma</span>
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
                <div class="passion-card" data-passion="gaming">
                    <div class="passion-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h3 class="passion-title">Gaming</h3>
                    <p class="passion-description">Jeux de stratégie, de réflexion</p>
                </div>

                <div class="passion-card" data-passion="music">
                    <div class="passion-icon">
                        <i class="fas fa-music"></i>
                    </div>
                    <h3 class="passion-title">Musique</h3>
                    <p class="passion-description">Musique de jeu, d'animé et de pop rock</p>
                </div>

                <div class="passion-card" data-passion="scifi">
                    <div class="passion-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="passion-title">Sci-Fi</h3>
                    <p class="passion-description">Univers futuristes et Science-fiction (comme star wars)</p>
                </div>

                <div class="passion-card" data-passion="magic">
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

    <!-- Modale pour les technologies -->
    <div id="techModal" class="tech-modal" style="z-index: 999999 !important;">
        <div class="tech-modal-overlay" style="z-index: 999999 !important;"></div>
        <div class="tech-modal-content" style="z-index: 1000000 !important;">
            <button class="tech-modal-close" aria-label="Fermer">
                <i class="fas fa-times"></i>
            </button>
            <div class="tech-modal-header">
                <div class="tech-modal-icon">
                    <i class="tech-icon-display"></i>
                </div>
                <h2 class="tech-modal-title"></h2>
            </div>
            <div class="tech-modal-body">
                <p class="tech-modal-description"></p>
                <div class="tech-modal-info">
                    <div class="tech-info-item">
                        <i class="fas fa-layer-group"></i>
                        <span class="tech-info-label">Type:</span>
                        <span class="tech-info-value tech-type"></span>
                    </div>
                    <div class="tech-info-item">
                        <i class="fas fa-chart-line"></i>
                        <span class="tech-info-label">Niveau:</span>
                        <span class="tech-info-value tech-level"></span>
                    </div>
                </div>
                <div class="tech-modal-features">
                    <h4><i class="fas fa-lightbulb me-2"></i>Utilisation:</h4>
                    <ul class="tech-features-list"></ul>
                </div>
                <div class="tech-modal-actions">
                    <a href="#" class="btn-modal btn-modal-docs" target="_blank" rel="noopener noreferrer">
                        <i class="fas fa-book"></i>
                        <span>Documentation</span>
                    </a>
                    <button class="btn-modal btn-modal-close">
                        <i class="fas fa-times"></i>
                        <span>Fermer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale pour les passions -->
    <div id="passionModal" class="tech-modal" style="z-index: 999999 !important;">
        <div class="tech-modal-overlay" style="z-index: 999999 !important;"></div>
        <div class="tech-modal-content" style="z-index: 1000000 !important;">
            <button class="passion-modal-close tech-modal-close" aria-label="Fermer">
                <i class="fas fa-times"></i>
            </button>
            <div class="tech-modal-header">
                <div class="tech-modal-icon passion-modal-icon">
                    <i class="passion-icon-display"></i>
                </div>
                <h2 class="tech-modal-title passion-modal-title"></h2>
            </div>
            <div class="tech-modal-body">
                <p class="tech-modal-description passion-modal-description"></p>
                <div class="tech-modal-features">
                    <h4><i class="fas fa-heart me-2"></i>Ce que j'aime:</h4>
                    <ul class="tech-features-list passion-likes-list"></ul>
                </div>
                <div class="tech-modal-features" style="margin-top: 1.5rem;">
                    <h4><i class="fas fa-star me-2"></i>Pourquoi c'est important:</h4>
                    <p class="passion-modal-why" style="color: var(--text-secondary); line-height: 1.7;"></p>
                </div>
                <div class="tech-modal-actions">
                    <button class="btn-modal btn-modal-close passion-btn-close">
                        <i class="fas fa-times"></i>
                        <span>Fermer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Données des technologies
        const techData = {
            'javascript': {
                name: 'JavaScript',
                description: 'Langage de programmation polyvalent pour le développement web moderne, tant côté client que serveur.',
                type: 'Langage de programmation',
                level: 'Intermédiaire',
                features: ['Manipulation du DOM', 'Applications web interactives', 'Développement backend avec Node.js', 'Programmation asynchrone'],
                icon: 'fab fa-js',
                docUrl: 'https://developer.mozilla.org/fr/docs/Web/JavaScript'
            },
            'typescript': {
                name: 'TypeScript',
                description: 'Superset de JavaScript qui ajoute le typage statique, améliorant la maintenabilité du code.',
                type: 'Langage de programmation',
                level: 'Intermédiaire',
                features: ['Typage statique fort', 'Meilleure autocomplétion', 'Détection d\'erreurs à la compilation', 'Intégration avec frameworks modernes'],
                icon: 'fab fa-js',
                docUrl: 'https://www.typescriptlang.org/docs/'
            },
            'python': {
                name: 'Python',
                description: 'Langage de programmation polyvalent, idéal pour le scripting, l\'analyse de données et l\'automatisation.',
                type: 'Langage de programmation',
                level: 'Avancé',
                features: ['Scripts d\'automatisation', 'Analyse de données', 'Développement backend', 'APIs REST'],
                icon: 'fab fa-python',
                docUrl: 'https://docs.python.org/fr/3/'
            },
            'php': {
                name: 'PHP',
                description: 'Langage de script côté serveur, largement utilisé pour le développement web dynamique.',
                type: 'Langage backend',
                level: 'Intermédiaire',
                features: ['Développement web backend', 'APIs REST', 'Gestion de bases de données', 'Applications MVC'],
                icon: 'fab fa-php',
                docUrl: 'https://www.php.net/manual/fr/'
            },
            'java': {
                name: 'Java',
                description: 'Langage orienté objet robuste, utilisé pour des applications d\'entreprise et Android.',
                type: 'Langage de programmation',
                level: 'Intermédiaire',
                features: ['Programmation orientée objet', 'Applications d\'entreprise', 'Développement Android', 'Portabilité multiplateforme'],
                icon: 'fab fa-java',
                docUrl: 'https://docs.oracle.com/en/java/'
            },
            'c': {
                name: 'C',
                description: 'Langage de programmation de bas niveau, offrant un contrôle précis sur le matériel.',
                type: 'Langage de programmation',
                level: 'Intermédiaire',
                features: ['Programmation système', 'Gestion de la mémoire', 'Performance optimale', 'Algorithmique'],
                icon: 'fas fa-code',
                docUrl: 'https://devdocs.io/c/'
            },
            'sql': {
                name: 'SQL',
                description: 'Langage de requête pour la gestion et manipulation de bases de données relationnelles.',
                type: 'Langage de requête',
                level: 'Avancé',
                features: ['Requêtes complexes', 'Gestion de bases de données', 'Optimisation de performances', 'Modélisation de données'],
                icon: 'fas fa-database',
                docUrl: 'https://sql.sh/'
            },
            'html-css': {
                name: 'HTML/CSS',
                description: 'Technologies fondamentales pour la structure et le style des pages web.',
                type: 'Langages web',
                level: 'Avancé',
                features: ['Structure sémantique', 'Design responsive', 'Animations CSS', 'Flexbox & Grid'],
                icon: 'fab fa-html5',
                docUrl: 'https://developer.mozilla.org/fr/docs/Web/HTML'
            },
            'bash': {
                name: 'Bash',
                description: 'Shell Unix pour l\'automatisation de tâches et la gestion de systèmes.',
                type: 'Script shell',
                level: 'Intermédiaire',
                features: ['Automatisation de tâches', 'Scripts système', 'Gestion de fichiers', 'Déploiement'],
                icon: 'fas fa-terminal',
                docUrl: 'https://www.gnu.org/software/bash/manual/'
            },
            'dart': {
                name: 'Dart',
                description: 'Langage optimisé pour le développement d\'applications multiplateformes avec Flutter.',
                type: 'Langage de programmation',
                level: 'Débutant',
                features: ['Applications mobiles', 'Flutter framework', 'Hot reload', 'Performance native'],
                icon: 'fas fa-code',
                docUrl: 'https://dart.dev/guides'
            },
            'vuejs': {
                name: 'Vue.js',
                description: 'Framework JavaScript progressif pour construire des interfaces utilisateur interactives.',
                type: 'Framework frontend',
                level: 'Intermédiaire',
                features: ['Composants réactifs', 'Virtual DOM', 'Single Page Applications', 'Routing et state management'],
                icon: 'fab fa-vuejs',
                docUrl: 'https://vuejs.org/guide/introduction.html'
            },
            'bootstrap': {
                name: 'Bootstrap',
                description: 'Framework CSS pour créer rapidement des interfaces web responsives et modernes.',
                type: 'Framework CSS',
                level: 'Avancé',
                features: ['Design responsive', 'Composants prêts à l\'emploi', 'Grille flexible', 'Customisation facile'],
                icon: 'fab fa-bootstrap',
                docUrl: 'https://getbootstrap.com/docs/'
            },
            'nodejs': {
                name: 'Node.js',
                description: 'Environnement d\'exécution JavaScript côté serveur, basé sur le moteur V8 de Chrome.',
                type: 'Runtime JavaScript',
                level: 'Avancé',
                features: ['APIs REST', 'Applications temps réel', 'Microservices', 'Event-driven architecture'],
                icon: 'fab fa-node-js',
                docUrl: 'https://nodejs.org/docs/latest/api/'
            },
            'express': {
                name: 'Express',
                description: 'Framework web minimaliste et flexible pour Node.js, facilitant la création d\'APIs.',
                type: 'Framework backend',
                level: 'Intermédiaire',
                features: ['APIs RESTful', 'Middleware', 'Routing avancé', 'Gestion des requêtes HTTP'],
                icon: 'fas fa-server',
                docUrl: 'https://expressjs.com/'
            },
            'flutter': {
                name: 'Flutter',
                description: 'Framework UI de Google pour créer des applications multiplateformes natives.',
                type: 'Framework mobile',
                level: 'Débutant',
                features: ['Applications iOS/Android', 'Widgets personnalisables', 'Hot reload', 'Performance native'],
                icon: 'fas fa-mobile-alt',
                docUrl: 'https://docs.flutter.dev/'
            },
            'mysql': {
                name: 'MySQL',
                description: 'Système de gestion de base de données relationnelle open-source, très populaire.',
                type: 'Base de données SQL',
                level: 'Avancé',
                features: ['Bases de données relationnelles', 'Transactions ACID', 'Réplication', 'Haute performance'],
                icon: 'fas fa-database',
                docUrl: 'https://dev.mysql.com/doc/'
            },
            'mongodb': {
                name: 'MongoDB',
                description: 'Base de données NoSQL orientée documents, flexible et scalable.',
                type: 'Base de données NoSQL',
                level: 'Intermédiaire',
                features: ['Documents JSON', 'Scalabilité horizontale', 'Schéma flexible', 'Requêtes puissantes'],
                icon: 'fas fa-leaf',
                docUrl: 'https://www.mongodb.com/docs/'
            },
            'postgresql': {
                name: 'PostgreSQL',
                description: 'Système de gestion de base de données relationnelle avancé, open-source et robuste.',
                type: 'Base de données SQL',
                level: 'Intermédiaire',
                features: ['Conformité SQL', 'Extensions avancées', 'JSON natif', 'Haute fiabilité'],
                icon: 'fas fa-database',
                docUrl: 'https://www.postgresql.org/docs/'
            },
            'git': {
                name: 'Git',
                description: 'Système de contrôle de version distribué pour suivre les modifications du code.',
                type: 'Contrôle de version',
                level: 'Avancé',
                features: ['Gestion de versions', 'Branches et merge', 'Collaboration d\'équipe', 'Historique complet'],
                icon: 'fab fa-git-alt',
                docUrl: 'https://git-scm.com/doc'
            },
            'docker': {
                name: 'Docker',
                description: 'Plateforme de conteneurisation pour déployer des applications de manière isolée.',
                type: 'Conteneurisation',
                level: 'Intermédiaire',
                features: ['Conteneurs légers', 'Isolation d\'applications', 'Déploiement simplifié', 'Orchestration'],
                icon: 'fab fa-docker',
                docUrl: 'https://docs.docker.com/'
            },
            'vscode': {
                name: 'VS Code',
                description: 'Éditeur de code source léger mais puissant, développé par Microsoft.',
                type: 'IDE',
                level: 'Avancé',
                features: ['IntelliSense', 'Débogage intégré', 'Extensions riches', 'Git intégré'],
                icon: 'fas fa-code',
                docUrl: 'https://code.visualstudio.com/docs'
            },
            'postman': {
                name: 'Postman',
                description: 'Plateforme collaborative pour tester, développer et documenter des APIs.',
                type: 'Outil API',
                level: 'Intermédiaire',
                features: ['Test d\'APIs', 'Automatisation de tests', 'Documentation', 'Collections de requêtes'],
                icon: 'fas fa-paper-plane',
                docUrl: 'https://learning.postman.com/docs/'
            },
            'figma': {
                name: 'Figma',
                description: 'Outil de design collaboratif pour créer des interfaces et prototypes.',
                type: 'Design UI/UX',
                level: 'Intermédiaire',
                features: ['Design d\'interfaces', 'Prototypage', 'Collaboration temps réel', 'Composants réutilisables'],
                icon: 'fab fa-figma',
                docUrl: 'https://help.figma.com/'
            }
        };

        // Gestion de la modale
        const modal = document.getElementById('techModal');

        // IMPORTANT: Déplacer la modale directement dans le body pour éviter les problèmes de z-index
        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

        const closeBtn = modal.querySelector('.tech-modal-close');
        const closeBtnBottom = modal.querySelector('.btn-modal-close');
        const techBadges = document.querySelectorAll('.tech-badge');
        const docBtn = modal.querySelector('.btn-modal-docs');

        function closeModal() {
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }

        techBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                const techKey = this.getAttribute('data-tech');
                const tech = techData[techKey];

                if (tech) {
                    // Titre et description
                    document.querySelector('.tech-modal-title').textContent = tech.name;
                    document.querySelector('.tech-modal-description').textContent = tech.description;
                    document.querySelector('.tech-type').textContent = tech.type;
                    document.querySelector('.tech-level').textContent = tech.level;

                    // Icône
                    const iconElement = document.querySelector('.tech-icon-display');
                    iconElement.className = 'tech-icon-display ' + tech.icon;

                    // Features
                    const featuresList = document.querySelector('.tech-features-list');
                    featuresList.innerHTML = '';
                    tech.features.forEach(feature => {
                        const li = document.createElement('li');
                        li.innerHTML = `<i class="fas fa-check-circle"></i> ${feature}`;
                        featuresList.appendChild(li);
                    });

                    // Lien documentation
                    docBtn.href = tech.docUrl;

                    // Affichage de la modale
                    modal.style.display = 'flex';
                    setTimeout(() => modal.classList.add('active'), 10);
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        // Fermeture via bouton X
        closeBtn.addEventListener('click', function() {
            closeModal();
            document.body.style.overflow = 'auto';
        });

        // Fermeture via bouton Fermer
        closeBtnBottom.addEventListener('click', function() {
            closeModal();
            document.body.style.overflow = 'auto';
        });

        // Fermeture en cliquant sur l'overlay
        const modalOverlay = modal.querySelector('.tech-modal-overlay');
        modalOverlay.addEventListener('click', function(event) {
            closeModal();
            document.body.style.overflow = 'auto';
        });

        // Fermeture avec la touche Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
                document.body.style.overflow = 'auto';
            }
        });

        // Données des passions
        const passionData = {
            'gaming': {
                name: 'Gaming',
                description: 'Les jeux vidéo sont pour moi bien plus qu\'un simple passe-temps. Ils représentent un univers de créativité, de stratégie et de défis qui me permettent de me détendre tout en stimulant ma réflexion.',
                icon: 'fas fa-gamepad',
                likes: [
                    'Jeux de stratégie comme Magic The Gathering Arena',
                    'Jeux de réflexion et puzzles complexes',
                    'RPG avec des histoires riches et immersives',
                    'Jeux de gestion et simulation comme Planet Crafter ou Cult of the Lamb',
                    'Découvrir de nouveaux mécaniques de gameplay'
                ],
                why: 'Le gaming développe ma capacité à résoudre des problèmes complexes, à penser de manière stratégique et à m\'adapter rapidement. Les jeux m\'apprennent la persévérance et me permettent de décompresser après une longue journée de code.'
            },
            'music': {
                name: 'Musique',
                description: 'La musique est ma compagne de tous les instants. Elle m\'accompagne dans mes sessions de code, me motive et m\'inspire. J\'apprécie particulièrement les bandes originales de jeux vidéo et d\'animés pour leur richesse émotionnelle.',
                icon: 'fas fa-music',
                likes: [
                    'Soundtracks de jeux vidéo (Undertale, Minecraft)',
                    'Musiques d\'animés japonais (openings, endings)',
                    'Pop Rock alternatif',
                    'Musiques épiques et orchestrales',
                    'Découvrir de nouveaux artistes sur YouTube Music'
                ],
                why: 'La musique booste ma productivité lors du développement et m\'aide à me concentrer. Chaque style musical correspond à une humeur ou une tâche : orchestral pour la conception, rock pour le debugging, et lo-fi pour la réflexion.'
            },
            'scifi': {
                name: 'Science-Fiction',
                description: 'L\'univers de la science-fiction me fascine par ses questionnements sur l\'avenir, la technologie et l\'humanité. Star Wars, en particulier, représente pour moi l\'équilibre parfait entre technologie avancée et récits épiques.',
                icon: 'fas fa-rocket',
                likes: [
                    'Star Wars : l\'univers étendu et la mythologie',
                    'Films et séries de SF',
                    'Romans de science-fiction moderne',
                    'Exploration des futurs possibles et technologies',
                    'Réflexions philosophiques sur l\'IA et le transhumanisme'
                ],
                why: 'La science-fiction nourrit mon imagination et ma vision du futur de la technologie. Elle m\'inspire dans mon travail de développeur en me poussant à imaginer des solutions innovantes et à penser au-delà des limites actuelles.'
            },
            'magic': {
                name: 'Magic: The Gathering',
                description: 'Magic est bien plus qu\'un jeu de cartes : c\'est un exercice de stratégie, de gestion de ressources et de prise de décision. Chaque partie est unique et demande adaptation et réflexion tactique.',
                icon: 'fas fa-dice-d20',
                likes: [
                    'Construire et optimiser des decks compétitifs',
                    'Analyser les interactions entre cartes',
                    'Suivre le métagame et les nouvelles extensions',
                    'Collectionner des cartes avec des illustrations magnifiques'
                ],
                why: 'Magic développe mes compétences en analyse, planification et gestion de ressources - des compétences directement transférables en programmation. La construction de decks ressemble beaucoup à l\'architecture logicielle : il faut trouver le bon équilibre entre différents composants.'
            }
        };

        // Gestion de la modale des passions
        const passionModal = document.getElementById('passionModal');
        const passionCards = document.querySelectorAll('.passion-card');

        // Déplacer la modale directement dans le body pour éviter les problèmes de z-index
        if (passionModal && passionModal.parentElement !== document.body) {
            document.body.appendChild(passionModal);
        }

        const passionCloseBtn = passionModal.querySelector('.passion-modal-close');
        const passionCloseBtnBottom = passionModal.querySelector('.passion-btn-close');

        function closePassionModal() {
            passionModal.classList.remove('active');
            setTimeout(() => passionModal.style.display = 'none', 300);
        }

        passionCards.forEach(card => {
            card.addEventListener('click', function() {
                const passionKey = this.getAttribute('data-passion');
                const passion = passionData[passionKey];

                if (passion) {
                    // Titre et description
                    document.querySelector('.passion-modal-title').textContent = passion.name;
                    document.querySelector('.passion-modal-description').textContent = passion.description;
                    document.querySelector('.passion-modal-why').textContent = passion.why;

                    // Icône
                    const iconElement = document.querySelector('.passion-icon-display');
                    iconElement.className = 'passion-icon-display ' + passion.icon;

                    // Icône de fond avec gradient rouge
                    const modalIcon = document.querySelector('.passion-modal-icon');
                    modalIcon.style.background = 'linear-gradient(135deg, #EF4444 0%, #DC2626 100%)';

                    // Liste de ce que j'aime
                    const likesList = document.querySelector('.passion-likes-list');
                    likesList.innerHTML = '';
                    passion.likes.forEach(like => {
                        const li = document.createElement('li');
                        li.innerHTML = `<i class="fas fa-check-circle"></i> ${like}`;
                        likesList.appendChild(li);
                    });

                    // Affichage de la modale
                    passionModal.style.display = 'flex';
                    setTimeout(() => passionModal.classList.add('active'), 10);
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        // Fermeture via bouton X
        passionCloseBtn.addEventListener('click', function() {
            closePassionModal();
            document.body.style.overflow = 'auto';
        });

        // Fermeture via bouton Fermer
        passionCloseBtnBottom.addEventListener('click', function() {
            closePassionModal();
            document.body.style.overflow = 'auto';
        });

        // Fermeture en cliquant sur l'overlay
        const passionModalOverlay = passionModal.querySelector('.tech-modal-overlay');
        passionModalOverlay.addEventListener('click', function(event) {
            closePassionModal();
            document.body.style.overflow = 'auto';
        });

        // Fermeture avec la touche Escape (s'applique aussi aux passions)
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && passionModal.classList.contains('active')) {
                closePassionModal();
                document.body.style.overflow = 'auto';
            }
        });

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
