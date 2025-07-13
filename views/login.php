<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Enzo Fournier</title>
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

<div class="container-fluid">
    <!-- Header Section -->
    <div class="profile-header fade-in">
        <div class="profile-avatar">
            <i class="bi bi-laptop"></i>
        </div>
        <h1>Connexion</h1>
        <h2>Page de connexion</h2>
    </div>
    <div class="container">
        <!-- formulaire de connexion -->
        <div class="card fade-in mb-4">
            <div class="card-body">
                <div class="form-container">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?= implode('<br>', $errors) ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= url('login') ?>" method="post" class="mt-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="mdp" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="mdp" name="mdp" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>