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
                <i class="bi bi-list-columns"></i>
            </div>
            <h1>Liste des projet</h1>
        </div>
    </div>

    <!-- tableau avec liste des projets, pouvoir changer sa visibilité et le bouton de modification de projet et de suppression  -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="bi bi-list-ul"></i>
                            Liste des projets
                        </h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($projects) && count($projects) > 0): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom du projet</th>
                                        <th>Description</th>
                                        <th>Visibilité</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($projects as $project): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($project['title']) ?></td>
                                            <td><?= htmlspecialchars($project['description']) ?></td>
                                            <td>
                                                <form action="<?= url('admin/projects') ?>" method="POST" style="display:inline;" name="visibilityForm">
                                                    <input type="hidden" name="projectId" value="<?= $project['id'] ?>">
                                                    <input type="hidden" name="visible" value="0">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="visible" value="1" id="visibleSwitch<?= $project['id'] ?>" <?= (int)$project['visibilite'] == 1 ? 'checked' : '' ?> onchange="this.form.submit()">
                                                        <label class="form-check-label" for="visibleSwitch<?= $project['id'] ?>">
                                                            <?= (int)$project['visibilite'] == 1 ? 'Visible' : 'Invisible' ?>
                                                        </label>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="<?= url('admin/projects/edit-project/' . $project['id']) ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> Modifier</a>
                                                <form action="<?= url('admin/projects') ?>" method="POST" style="display:inline;" name="deleteForm">
                                                    <input type="hidden" name="projectId" value="<?= $project['id'] ?>">
                                                    <input type="hidden" name="delete" value="1">
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3 class="text-primary">Aucun projet trouvé.</h3>
                        <?php endif; ?>
                    </div>
</body>

<?php
$content = ob_get_clean();
include 'layout.php';
?>