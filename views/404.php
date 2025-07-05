<?php ob_start(); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Numéro 404 avec animation -->
            <div class="text-center mb-4">
                <div class="display-1 text-gradient glow-effect" style="font-size: clamp(4rem, 15vw, 8rem); font-weight: 900; line-height: 1;">
                    404
                </div>
                <div class="floating-animation" style="font-size: 3rem; margin: -1rem 0 1rem 0;">
                    🚀💫
                </div>
            </div>

            <!-- Titre principal -->
            <div class="text-center mb-4">
                <h2 class="text-primary mb-3"><?= $title ?></h2>

                <?php if (isset($message)): ?>
                    <p class="lead text-secondary fs-5 mb-0"><?= $message ?></p>
                <?php endif; ?>
            </div>

            <!-- Card principale avec suggestions -->
            <div class="card fade-in mb-4">
                <div class="card-body text-center p-4">
                    <h3 class="card-title text-accent mb-4">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Que faire maintenant ?
                    </h3>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="d-flex flex-column align-items-center p-3 rounded bg-glass border-glow h-100">
                                <div class="text-primary mb-2" style="font-size: 2rem;">🏠</div>
                                <h6 class="text-accent">Retour à l'accueil</h6>
                                <p class="text-secondary small mb-0">Repartez du début</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column align-items-center p-3 rounded bg-glass border-glow h-100">
                                <div class="text-primary mb-2" style="font-size: 2rem;">🔍</div>
                                <h6 class="text-accent">Rechercher</h6>
                                <p class="text-secondary small mb-0">Trouvez ce que vous cherchez</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column align-items-center p-3 rounded bg-glass border-glow h-100">
                                <div class="text-primary mb-2" style="font-size: 2rem;">📧</div>
                                <h6 class="text-accent">Contactez-nous</h6>
                                <p class="text-secondary small mb-0">Nous sommes là pour aider</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="<?= homeUrl() ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            Retour à l'accueil
                        </a>
                        <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Page précédente
                        </a>
                    </div>
                </div>
            </div>

            <!-- Liste des suggestions détaillées -->
            <div class="card slide-in-left">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-info-circle text-info me-2"></i>
                    Conseils pour continuer
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge bg-primary rounded-pill me-3 mt-1">1</span>
                                <div>
                                    <strong class="text-accent">Vérifiez l'URL</strong>
                                    <p class="text-secondary small mb-0">Assurez-vous que l'adresse est correcte</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge bg-secondary rounded-pill me-3 mt-1">2</span>
                                <div>
                                    <strong class="text-accent">Utilisez la navigation</strong>
                                    <p class="text-secondary small mb-0">Explorez le menu principal</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge bg-success rounded-pill me-3 mt-1">3</span>
                                <div>
                                    <strong class="text-accent">Recherchez</strong>
                                    <p class="text-secondary small mb-0">Utilisez notre fonction de recherche</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-start mb-3">
                                <span class="badge bg-warning rounded-pill me-3 mt-1">4</span>
                                <div>
                                    <strong class="text-accent">Contactez le support</strong>
                                    <p class="text-secondary small mb-0">Si le problème persiste</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques amusantes -->
            <div class="text-center mt-4">
                <div class="alert alert-info d-inline-block">
                    <i class="fas fa-chart-bar me-2"></i>
                    <strong>Le saviez-vous ?</strong> Cette page fait partie des 4% de pages introuvables sur Internet !
                    <span class="badge bg-primary ms-1">Félicitations ! 🎉</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Particules flottantes d'arrière-plan (CSS pur) -->
<!--<style>
    .error-bg-particles {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    .error-bg-particles::before,
    .error-bg-particles::after {
        content: '';
        position: absolute;
        width: 4px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 50%;
        animation: float-particles 6s infinite linear;
        opacity: 0.6;
    }

    .error-bg-particles::before {
        top: 10%;
        left: 20%;
        animation-delay: -2s;
    }

    .error-bg-particles::after {
        top: 70%;
        right: 30%;
        animation-delay: -4s;
    }

    @keyframes float-particles {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 0.6;
        }

        50% {
            transform: translateY(-20px) rotate(180deg);
            opacity: 1;
        }
    }

    /* Animation supplémentaire pour le glow effect */
    .glow-effect {
        text-shadow:
            0 0 10px rgba(0, 212, 255, 0.5),
            0 0 20px rgba(0, 212, 255, 0.3),
            0 0 30px rgba(0, 212, 255, 0.2);
    }

    /* Hover effects pour les cards */
    .bg-glass:hover {
        transform: translateY(-2px);
        transition: var(--transition);
    }
</style>-->

<div class="error-bg-particles"></div>

<?php $content = ob_get_clean();
include 'layout.php'; ?>