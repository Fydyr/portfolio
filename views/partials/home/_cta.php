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
