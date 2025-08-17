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
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>

    <div class="container main-content text-center py-5">
        <div class="card shadow-glow mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <div class="mb-4">
                    <span class="display-1 floating-animation" style="font-size:6rem;">🫖</span>
                </div>
                <h1 class="glow-effect mb-3">418 - Je suis une théière</h1>
                <p class="lead mb-4">
                    Désolé, je ne peux pas faire de café car je suis une théière.<br>
                    <span class="badge bg-warning mt-2">Erreur HTTP 418</span>
                </p>
                <a href="/" class="btn btn-primary">
                    <i class="fa fa-home me-2"></i>Retour à l'accueil
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>