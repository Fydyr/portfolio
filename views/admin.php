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
                        <a href="<?= url('admin/add-project')?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Ajouter</a>
                    </div>
                </div>
            </div>

            <!-- Carte pour modifier les projets -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Modifier les projets</h5>
                        <p class="card-text">Modifier les projets existants dans la page des projets.</p>
                        <a href="<?= url('/admin/projects') ?>" class="btn btn-warning">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carte gestion des compétences -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Compétences</h5>
                        <p class="card-text">Gérer les catégories et les compétences (skills) affichées sur la page d'accueil.</p>
                        <a href="<?= url('admin/skills') ?>" class="btn btn-info"><i class="bi bi-stars"></i> Gérer</a>
                    </div>
                </div>
            </div>

            <!-- Carte gestion des passions -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Passions</h5>
                        <p class="card-text">Gérer la liste des passions affichées sur la page d'accueil.</p>
                        <a href="<?= url('admin/passions') ?>" class="btn btn-info"><i class="bi bi-heart-fill"></i> Gérer</a>
                    </div>
                </div>
            </div>

            <!-- Carte gestion des tarifs -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Tarifs</h5>
                        <p class="card-text">Gérer les prestations et tarifs affichés sur la page des tarifs.</p>
                        <a href="<?= url('admin/prices') ?>" class="btn btn-info"><i class="bi bi-tags-fill"></i> Gérer</a>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>