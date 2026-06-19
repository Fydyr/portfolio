<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $section ? 'Modifier' : 'Ajouter' ?> une section À propos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1><?= $section ? 'Modifier' : 'Ajouter' ?> une section</h1>
    <form method="post" class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Slug (unique, kebab-case) *</label>
                    <input type="text" name="slug" class="form-control" required pattern="[a-z0-9-]+"
                           value="<?= htmlspecialchars($section['slug'] ?? '') ?>" placeholder="ex: stage-alternance">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="title" class="form-control" required
                           value="<?= htmlspecialchars($section['title'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icône</label>
                    <input type="text" name="icon" class="form-control" data-icon-picker
                           value="<?= htmlspecialchars($section['icon'] ?? '') ?>" placeholder="bi bi-rocket-takeoff-fill">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= (int)($section['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-3 d-flex flex-column justify-content-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="visible" value="1" id="visible"
                               <?= !$section || $section['visible'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="visible">Visible</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_markdown" value="1" id="is_markdown"
                               <?= !$section || $section['is_markdown'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_markdown">Markdown</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Contenu</label>
                    <textarea name="content" class="form-control" rows="6"
                              style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem;"><?= htmlspecialchars($section['content'] ?? '') ?></textarea>
                    <div class="form-text">Si "Markdown" est coché : **gras**, *italique*, [lien](url), listes.</div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Enregistrer</button>
                <a href="<?= url('admin/about') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </div>
    </form>
</div>
<script src="/assets/js/icon-picker.js"></script>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
