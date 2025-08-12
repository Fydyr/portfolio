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
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="profile-header fade-in">
            <div class="profile-avatar">
                <i class="bi bi-arrow-up-circle-fill"></i>
            </div>
            <h1>Modifier un projet</h1>
        </div>

        <!-- Messages d'erreur ou de succès -->
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?=url('/admin/projects/edit-project/') . htmlspecialchars($project['id']) ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre du projet</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description du projet</label>
                        <textarea class="form-control" id="description" name="description" rows="5" required><?= htmlspecialchars($project['description']) ?></textarea>
                    </div>

                    <!-- Les 3 images du projet -->
                    <div class="mb-3">
                        <label for="image1" class="form-label">Image 1</label>
                        <input type="file" class="form-control" id="image1" name="image1">
                        <?php if ($project['image1']): ?>
                            <img src="/assets/images/projects/<?= htmlspecialchars($project['image1']) ?>" alt="Image 1" class="img-thumbnail mt-2" style="max-width: 200px;">
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="image2" class="form-label">Image 2</label>
                        <input type="file" class="form-control" id="image2" name="image2">
                        <?php if ($project['image2']): ?>
                            <img src="/assets/images/projects/<?= htmlspecialchars($project['image2']) ?>" alt="Image 2" class="img-thumbnail mt-2" style="max-width: 200px;">
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="image3" class="form-label">Image 3</label>
                        <input type="file" class="form-control" id="image3" name="image3">
                        <?php if ($project['image3']): ?>
                            <img src="/assets/images/projects/<?= htmlspecialchars($project['image3']) ?>" alt="Image 3" class="img-thumbnail mt-2" style="max-width: 200px;">
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Lien du projet</label>
                        <input type="url" class="form-control" id="link" name="link" value="<?= htmlspecialchars($project['link']) ?>">
                    </div>

                    <div class="mb-3">
                        <label for="tools" class="form-label">Outils/langages du projet</label>
                        <input type="text" class="form-control" id="tools" name="tools" value="<?= htmlspecialchars($project['languages']) ?>" required>
                    </div>

                    <!-- bouton de soumission -->
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

<?php
// Nettoyer les données de formulaire après affichage
unset($_SESSION['form_data']);
$content = ob_get_clean();
include 'layout.php';
?>