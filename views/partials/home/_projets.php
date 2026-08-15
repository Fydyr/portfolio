    <!-- Projets mis en avant (choisis depuis /admin/featured) -->
    <section class="py-5" id="projets">
        <div class="container">
            <div class="section-header">
                <a href="<?= url('projects') ?>" class="section-badge"
                   style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-folder-open me-2"></i>
                    Réalisations
                </a>
                <h2 class="section-title">Projets à la une</h2>
                <p class="section-description">
                    Une sélection de mes travaux
                </p>
            </div>

            <?php if (empty($recentProjects)): ?>
                <p class="text-center text-muted">Les projets arrivent bientôt.</p>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($recentProjects as $project): ?>
                        <div class="col-md-6 col-lg-4">
                            <?php partial('_project_card', ['project' => $project]); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-5">
                    <a href="<?= url('projects') ?>" class="btn btn-hero btn-hero-primary">
                        <i class="fas fa-folder-open"></i>
                        Voir tous les projets
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
