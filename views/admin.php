<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Enzo Fournier</title>
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

<body>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="profile-header fade-in">
            <div class="profile-avatar">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h1>administration</h1>
        </div>

        <!-- les cards qui redirige vers les pages -->
        <div class="row mt-4">

            <!-- Carte pour l'ajout de projets -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Ajout de projet</h5>
                        <p class="card-text">Ajouter un nouveau projet dans la page des projets.</p>
                        <a href="#" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Ajouter</a>
                    </div>
                </div>
            </div>

            <!-- Carte pour modifier les projets -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Modifier les projets</h5>
                        <p class="card-text">Modifier les projets existants dans la page des projets.</p>
                        <a href="#" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carte au cas où -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Autres options</h5>
                        <p class="card-text">D'autres options seront disponibles ici.</p>
                        <a href="#" class="btn btn-secondary disabled"><i class="bi bi-gear-fill"></i> À venir</a>
                    </div>
                </div>
            </div>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>