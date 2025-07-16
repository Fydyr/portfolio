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
                <i class="bi bi-plus-circle-fill"></i>
            </div>
            <h1>Ajout projet</h1>
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

        <!-- Formulaire d'ajout de projet -->
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="bi bi-plus-circle"></i>
                            Ajouter un projet
                        </h2>
                    </div>
                    <div class="card-body">
                        <form action="<?= url('admin/add-project') ?>" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="projectName" class="form-label">Nom du projet</label>
                                <input type="text" class="form-control" id="projectName" name="projectName"
                                    value="<?= htmlspecialchars($_SESSION['form_data']['projectName'] ?? '') ?>" required>
                                <div class="invalid-feedback">Veuillez saisir le nom du projet.</div>
                            </div>

                            <div class="mb-3">
                                <label for="projectDescription" class="form-label">Description du projet</label>
                                <textarea class="form-control" id="projectDescription" name="projectDescription"
                                    rows="3" required><?= htmlspecialchars($_SESSION['form_data']['projectDescription'] ?? '') ?></textarea>
                                <div class="invalid-feedback">Veuillez saisir une description du projet.</div>
                            </div>

                            <div class="mb-3">
                                <label for="projectImages" class="form-label">Images du projet</label>
                                <div class="mb-2">
                                    <label class="form-label small">Image 1</label>
                                    <input type="file" class="form-control" name="projectImage[]" accept="image/*" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Image 2 (optionnelle)</label>
                                    <input type="file" class="form-control" name="projectImage[]" accept="image/*">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Image 3 (optionnelle)</label>
                                    <input type="file" class="form-control" name="projectImage[]" accept="image/*">
                                </div>
                                <small class="form-text text-muted">
                                    Formats acceptés : JPG, PNG, GIF, WebP. Taille max : 5MB par image.
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="projectLink" class="form-label">Lien du projet</label>
                                <input type="url" class="form-control" id="projectLink" name="projectLink"
                                    value="<?= htmlspecialchars($_SESSION['form_data']['projectLink'] ?? '') ?>"
                                    placeholder="https://example.com" required>
                                <div class="invalid-feedback">Veuillez saisir un lien valide pour le projet.</div>
                            </div>

                            <div class="mb-3">
                                <label for="projectLanguage" class="form-label">Langages du projet</label>
                                <input type="text" class="form-control" id="projectLanguage" name="projectLanguage"
                                    value="<?= htmlspecialchars($_SESSION['form_data']['projectLanguage'] ?? '') ?>"
                                    placeholder="HTML, CSS, JavaScript" required>
                                <div class="invalid-feedback">Veuillez saisir les langages utilisés dans le projet.</div>
                            </div>

                            <div class="mb-3">
                                <label for="projectDate" class="form-label">Date de création</label>
                                <input type="date" class="form-control" id="projectDate" name="projectDate"
                                    value="<?= htmlspecialchars($_SESSION['form_data']['projectDate'] ?? '') ?>" required>
                                <div class="invalid-feedback">Veuillez sélectionner une date de création pour le projet.</div>
                            </div>

                            <div class="mb-3">
                                <label for="projectStatus" class="form-label">Statut du projet</label>
                                <select class="form-select" id="projectStatus" name="projectStatus">
                                    <option value="visible" <?= (($_SESSION['form_data']['projectStatus'] ?? '') === 'visible') ? 'selected' : '' ?>>
                                        Visible
                                    </option>
                                    <option value="non_visible" <?= (($_SESSION['form_data']['projectStatus'] ?? '') === 'non_visible') ? 'selected' : '' ?>>
                                        Non Visible
                                    </option>
                                </select>
                                <div class="invalid-feedback">Veuillez sélectionner un statut pour le projet.</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= url('admin') ?>" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-arrow-left"></i> Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Ajouter le projet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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