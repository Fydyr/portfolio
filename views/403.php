<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <!-- EmailJS SDK -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
</head>

<body class="d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="container">
        <div class="profile-header fade-in">
            <div class="profile-avatar mb-4">
                <i class="fas fa-ban fa-3x"></i>
            </div>
            <h1 class="display-3 text-danger">403</h1>
            <h2 class="mb-4">Accès interdit</h2>
            <p class="lead text-secondary mb-4">
                Vous n'avez pas l'autorisation d'accéder à cette page.<br>
                Si vous pensez qu'il s'agit d'une erreur, contactez l'administrateur.
            </p>
            <a href="/" class="btn btn-primary mt-3"><i class="fas fa-home"></i> Retour à l'accueil</a>
        </div>
    </div>

</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>