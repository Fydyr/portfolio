<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <!-- EmailJS SDK -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="profile-header fade-in">
            <div class="profile-avatar">
                <i class="bi bi-tags-fill"></i>
            </div>
            <h1>Prix des commissions</h1>
            <h2>Voici les prix pour mes commissions</h2>
        </div>

        <!-- Main Content Section -->
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="bi bi-info-circle-fill"></i>
                            Site vitrine statique
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Un site vitrine statique présente votre entreprise et vos services sur quelques pages, sans contenu dynamique. Idéal pour une première présence en ligne.</p>
                        <p class="card-text text-danger">Prix : 300 €</p>
                    </div>
                </div>

                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="bi bi-journal-text"></i>
                            Blog ou Portfolio
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Une plateforme de publication d'articles ou un site pour présenter vos créations. Cela inclut un design personnalisé et un système de gestion de contenu simple.</p>
                        <p class="card-text text-danger">Prix : 500 €</p>
                    </div>
                </div>

                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="bi bi-palette-fill"></i>
                            Refonte de site web
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Vous avez déjà un site web, mais il est obsolète ou a besoin d'un nouveau look ? Je peux moderniser son design et améliorer son ergonomie.</p>
                        <p class="card-text text-danger">Prix : à partir de 250 €</p>
                    </div>
                </div>

                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="bi bi-gear-fill"></i>
                            Maintenance et support
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Je propose également des services de maintenance pour assurer la sécurité, les mises à jour et le bon fonctionnement de votre site web, ainsi qu'un support technique en cas de besoin.</p>
                        <p class="card-text text-danger">Prix : sur devis (forfait mensuel ou à l'heure)</p>
                    </div>
                </div>

                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="bi bi-phone"></i>
                            Application Mobile (Hybride)
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Une application mobile avec des fonctionnalités de base, développée pour fonctionner à la fois sur iOS et Android (technologie hybride).</p>
                        <p class="card-text text-danger">Prix : 1 000 €</p>
                    </div>
                </div>

                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="bi bi-pencil-square"></i>
                            Projet sur mesure
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Pour un site ou une application avec des fonctionnalités avancées et des besoins spécifiques, nous discuterons ensemble d'un devis adapté à votre projet.</p>
                        <p class="card-text text-danger">Prix : sur devis</p>
                    </div>
                </div>

                <div class="card fade-in mb-4">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="bi bi-info-circle-fill"></i>
                            Informations supplémentaires
                        </h2>
                    </div>
                    <div class="card-body">
                        <p>Les prix indiqués sont des estimations de base et peuvent varier en fonction de la complexité du projet, des fonctionnalités demandées et des technologies utilisées. Pour un devis précis, n'hésitez pas à me contacter.</p>
                        <p>Je suis à votre disposition pour discuter de vos besoins et vous fournir un devis personnalisé. Vous pouvez me contacter via le formulaire de <a href="<?= url('contact')?>" class="text-primary">contact</a> ou par <a href="mailto:contact@enzofournier.com" class="text-primary">email</a>.</p>
                        <p>L'hébergement ainsi que le nom de domaine ne sont pas compris dans le prix, celà est à gérer de votre côté, cependant je peut vous aider à mettre en place tout ceci.</p>
                        <a class="btn btn-primary" href="<?= url('contact')?>"><i class="bi bi-envelope-fill"></i> Me contacter</a>
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