<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Modifier un projet</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Modifier un projet</h1>
        <a href="<?= url('admin/projects') ?>" class="btn btn-outline-light">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

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

    <form method="POST"
          action="<?= url('admin/projects/edit-project/' . htmlspecialchars($project['id'])) ?>"
          enctype="multipart/form-data" class="card">
        <?= csrfField() ?>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="title" class="form-control" required
                           value="<?= htmlspecialchars($project['title']) ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="projectStatus" value="visible"
                               id="projectStatus" <?= ((int)$project['visibilite'] === 1) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="projectStatus">Visible sur le site</label>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label d-flex align-items-center gap-2">
                        <span>Description *</span>
                        <span class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_markdown" value="1" id="is_markdown"
                                   <?= !empty($project['is_markdown']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="is_markdown">Markdown</label>
                        </span>
                    </label>
                    <textarea name="description" class="form-control" rows="8"
                              style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem;" required><?= htmlspecialchars($project['description']) ?></textarea>
                    <div class="form-text">Si "Markdown" est coché : **gras**, *italique*, [lien](url), listes, titres `#`, code, paragraphes (ligne vide).</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lien du projet</label>
                    <input type="url" name="link" class="form-control"
                           value="<?= htmlspecialchars($project['link'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Langages / outils *</label>
                    <input type="text" name="tools" class="form-control" required
                           value="<?= htmlspecialchars($project['languages'] ?? '') ?>"
                           placeholder="PHP, MySQL, Docker">
                    <div class="form-text">Séparés par des virgules (sert au filtre sur /projects).</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Catégories</label>
                    <input type="text" name="categories" class="form-control" list="known-categories"
                           value="<?= htmlspecialchars($project['categories'] ?? '') ?>"
                           placeholder="Web, Scolaire">
                    <datalist id="known-categories">
                        <?php foreach (($knownCategories ?? []) as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                    <div class="form-text">
                        Type de projet, séparé par des virgules. Distinct des langages :
                        ici « Web », « Jeu », « Scolaire », pas « PHP ».
                    </div>
                </div>

                <div class="col-12">
                    <!-- Un <label> sans contrôle associé : le bloc en compte
                         plusieurs, c'est un titre de section, pas une étiquette. -->
                    <span class="form-label d-block">Images du projet</span>
                    <?php partial('_project_images', ['projectImages' => $projectImages ?? []]); ?>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Enregistrer les modifications
                </button>
                <a href="<?= url('admin/projects') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </div>
    </form>
</div>
<script src="/assets/js/admin-project-images.js" defer></script>
</body>
</html>
<?php
unset($_SESSION['form_data']);
$content = ob_get_clean();
include 'layout.php';
?>
