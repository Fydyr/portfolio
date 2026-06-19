<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price - Enzo Fournier</title>
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

                <?php if (empty($prices ?? [])): ?>
                    <div class="alert alert-info">Aucun tarif configuré pour le moment.</div>
                <?php else: ?>
                    <?php foreach ($prices as $item): ?>
                        <div class="card fade-in mb-4">
                            <div class="card-header">
                                <h2 class="mb-0">
                                    <?php if (!empty($item['icon'])): ?>
                                        <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($item['title']) ?>
                                </h2>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($item['description'])): ?>
                                    <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($item['price'])): ?>
                                    <p class="card-text text-danger">Prix : <?= htmlspecialchars($item['price']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

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