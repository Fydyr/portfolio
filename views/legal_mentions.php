<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <!-- En-tête de la page -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h1 class="glow-effect">Mentions Légales</h1>
                    <p class="lead text-secondary">Informations légales concernant ce site portfolio</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Identification de l'éditeur -->
                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-user-circle me-2"></i>
                            Identification de l'éditeur
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong class="text-primary">Nom/Dénomination sociale :</strong><br>
                                    <span class="text-secondary">Enzo Fournier</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong class="text-primary">Email :</strong><br>
                                    <span><a href="mailto:contact@enzofournier.com" class="text-secondary">enzofournier.contact@gmail.com</a></span>
                                </p>
                            </div>
                        </div>
                        <div class="bg-glass p-3 rounded border-glow">
                            <i class="fas fa-info-circle me-2 text-info"></i>
                            <strong class="text-primary">Directeur de la publication :</strong> <span class="text-secondary">Enzo Fournier</span>
                        </div>
                    </div>
                </div>

                <!-- Hébergement -->
                <div class="card slide-in-left mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-server me-2"></i>
                            Hébergement
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong class="text-primary">Nom de l'hébergeur :</strong><br>
                                    <span class="text-secondary"><a href="https://jrcan.dev" target="_blank" class="text-decoration-none text-reset">JrCanDev</a></span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong class="text-primary">Adresse :</strong><br>
                                    <span class="text-secondary">19 Rue Louis David, 62100 Calais</span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong class="text-primary">Lien de l'hébergeur :</strong><br>
                                    <span class="text-secondary"><a href="https://jrcan.dev" target="_blank" class="text-decoration-none text-reset">https://jrcan.dev</a></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Propriété intellectuelle -->
                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-copyright me-2"></i>
                            Propriété intellectuelle
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>L'ensemble de ce site relève de la législation française et internationale sur le droit d'auteur et la propriété intellectuelle. Tous les droits de reproduction sont réservés, y compris pour les documents téléchargeables et les représentations iconographiques et photographiques.</p>

                        <div class="bg-glass p-3 rounded border-glow mt-3">
                            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                            <strong class="text-warning">Important :</strong> <span class="text-secondary">La reproduction de tout ou partie de ce site sur un support électronique quel qu'il soit est formellement interdite sauf autorisation expresse du directeur de la publication.</span>
                        </div>
                    </div>
                </div>

                <!-- Protection des données personnelles -->
                <div class="card slide-in-left mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-shield-alt me-2"></i>
                            Protection des données personnelles
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Ce site portfolio respecte votre vie privée et limite la collecte de données au strict minimum.</p>

                        <div class="bg-glass p-3 rounded mb-4" style="border: 1px solid rgba(59, 130, 246, 0.3);">
                            <h5 style="color: var(--info-color);">
                                <i class="fas fa-database me-2"></i>
                                Données collectées
                            </h5>
                            <p class="mb-2" style="color: var(--text-secondary);">Ce site collecte <strong style="color: var(--text-primary);">uniquement</strong> :</p>
                            <ul class="mb-0" style="color: var(--text-secondary);">
                                <li><strong style="color: var(--text-primary);">Le nombre total de visiteurs</strong> : Un compteur anonyme et global du nombre de visites sur le site, sans aucune information personnelle identifiable</li>
                                <li><strong style="color: var(--text-primary);">Les données du formulaire de contact</strong> (nom, email, message) : Uniquement si vous choisissez de nous contacter volontairement</li>
                            </ul>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-glass p-3 rounded mb-3">
                                    <h5 class="text-primary">
                                        <i class="fas fa-bullseye me-2"></i>
                                        Finalité
                                    </h5>
                                    <p class="mb-0"><strong>Compteur de visiteurs :</strong> Statistique globale et anonyme d'audience<br>
                                    <strong>Formulaire de contact :</strong> Répondre à vos demandes de contact</p>
                                </div>

                                <div class="bg-glass p-3 rounded mb-3">
                                    <h5 class="text-primary">
                                        <i class="fas fa-clock me-2"></i>
                                        Conservation
                                    </h5>
                                    <p class="mb-0"><strong>Compteur :</strong> Conservé indéfiniment (nombre total anonyme)<br>
                                    <strong>Données de contact :</strong> Conservées le temps nécessaire pour traiter votre demande, puis supprimées</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-glass p-3 rounded mb-3">
                                    <h5 class="text-primary">
                                        <i class="fas fa-user-shield me-2"></i>
                                        Vos droits
                                    </h5>
                                    <p class="mb-0">Conformément au RGPD, vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles (formulaire de contact).</p>
                                </div>

                                <div class="bg-glass p-3 rounded">
                                    <h5 class="text-primary">
                                        <i class="fas fa-user-tie me-2"></i>
                                        Responsable du traitement
                                    </h5>
                                    <p class="mb-0">Enzo Fournier</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-glass p-3 rounded mt-3" style="border: 1px solid rgba(59, 130, 246, 0.3);">
                            <i class="fas fa-info-circle me-2" style="color: var(--info-color);"></i>
                            <strong style="color: var(--info-color);">Information importante :</strong> <span style="color: var(--text-secondary);">Aucune adresse IP, aucun identifiant unique, aucune donnée de navigation n'est collectée ou conservée. Le compteur de visiteurs est purement statistique et totalement anonyme.</span>
                        </div>

                        <div class="bg-glass p-3 rounded mt-3" style="border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-envelope me-2" style="color: var(--success-color);"></i>
                            <strong style="color: var(--success-color);">Contact pour vos droits :</strong> <span style="color: var(--text-secondary);">Pour exercer vos droits, contactez-moi à l'adresse : <strong style="color: var(--primary-color);">enzofournier.contact@gmail.com</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Cookies et technologies de suivi -->
                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-cookie-bite me-2"></i>
                            Cookies et technologies de suivi
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="bg-glass p-3 rounded mb-3" style="border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-check-circle me-2" style="color: var(--success-color);"></i>
                            <strong style="color: var(--success-color);">Aucun cookie utilisé !</strong> <span style="color: var(--text-secondary);">Ce site n'utilise aucun cookie. Aucun système de tracking, d'analyse d'audience avancée ou de publicité n'est mis en place.</span>
                        </div>

                        <div class="bg-glass p-3 rounded" style="border: 1px solid rgba(59, 130, 246, 0.3);">
                            <h5 class="mb-3" style="color: var(--primary-color);">
                                <i class="fas fa-chart-line me-2"></i>
                                Technologies utilisées
                            </h5>
                            <p class="mb-2" style="color: var(--text-secondary);"><strong style="color: var(--text-primary);">Compteur de visiteurs :</strong></p>
                            <ul class="mb-0" style="color: var(--text-secondary);">
                                <li>Simple compteur stocké côté serveur</li>
                                <li>Aucun cookie déposé sur votre appareil</li>
                                <li>Aucune donnée personnelle collectée</li>
                                <li>Aucun suivi de navigation</li>
                                <li>Données 100% anonymes et agrégées</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Limitation de responsabilité -->
                <div class="card slide-in-left mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Limitation de responsabilité
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Les informations contenues sur ce site sont aussi précises que possible et le site est périodiquement remis à jour, mais peut toutefois contenir des inexactitudes, des omissions ou des lacunes.</p>

                        <p class="mb-0">Enzo Fournier ne pourra en aucun cas être tenu responsable de tout dommage de quelque nature qu'il soit résultant de l'interprétation ou de l'utilisation des informations et/ou documents disponibles sur ce site.</p>
                    </div>
                </div>

                <!-- Droit applicable -->
                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-balance-scale me-2"></i>
                            Droit applicable
                        </h2>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Les présentes mentions légales sont régies par le droit français. En cas de litige, les tribunaux français seront seuls compétents.</p>
                    </div>
                </div>

                <!-- Contact -->
                <div class="card slide-in-left mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-phone me-2"></i>
                            Contact
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Pour toute question concernant ce site portfolio, vous pouvez me contacter :</p>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <span class="text-secondary"><strong class="text-success">Par email :</strong> <a href="mailto:contact@enzofournier.com" class="text-primary">enzofournier.contact@gmail.com</a></span>
                        </div>
                    </div>
                </div>

                <!-- Footer de la page -->
                <div class="text-center mt-5">
                    <div class="bg-glass p-3 rounded">
                        <p class="mb-0 text-info">
                            <i class="fas fa-calendar-alt me-2"></i>
                            <strong>Dernière mise à jour :</strong> 28 Décembre 2025
                        </p>
                    </div>

                    <div class="mt-4">
                        <a href="/" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>