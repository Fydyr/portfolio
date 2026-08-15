    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Bonjour, je suis<br>Enzo Fournier
                </h1>
                <p class="hero-subtitle">
                    Diplômé du BUT Informatique, spécialisé dans le développement web backend & la création d'applications.
                </p>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?= $age ?></div>
                        <div class="stat-label">Ans</div>
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
                </div>
            </div>
        </div>
    </section>
