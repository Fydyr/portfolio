<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets - Enzo Fournier</title>
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

<div class="container-fluid">
    <!-- Header Section -->
    <div class="profile-header fade-in">
        <div class="profile-avatar">
            <i class="bi bi-laptop"></i>
        </div>
        <h1>Mes projets</h1>
        <h2>Voici la plupart des projets que j'ai pu réaliser et qui sont publique</h2>
    </div>

    <div class="container">
        <div class="row">
            <?php foreach ($projects as $project): ?>
                <div class="col-md-4 mb-4">
                    <a href="<?= url('project-detail/' . $project['id']) ?>" class="text-decoration-none text-dark">
                        <div class="card project-card h-100">
                            <div class="ratio ratio-4x3">
                                <img src="/assets/img/projects/<?= htmlspecialchars($project['img1']) ?>" class="card-img-top" alt="<?= htmlspecialchars($project['title']) ?>">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                                <p class="card-text">
                                    <?= htmlspecialchars(mb_strimwidth($project['description'], 0, 100, '...')) ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>