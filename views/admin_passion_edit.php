<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $passion ? 'Modifier' : 'Ajouter' ?> une passion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1><?= $passion ? 'Modifier' : 'Ajouter' ?> une passion</h1>

    <?php
    $likesText = '';
    if (!empty($passion['likes'])) {
        $arr = json_decode($passion['likes'], true);
        if (is_array($arr)) $likesText = implode("\n", $arr);
    }
    ?>

    <form method="post" class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Slug (unique, kebab-case) *</label>
                    <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($passion['slug'] ?? '') ?>" required pattern="[a-z0-9-]+">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nom *</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($passion['name'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icône</label>
                    <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($passion['icon'] ?? '') ?>" data-icon-picker placeholder="fas fa-gamepad">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= (int)($passion['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="visible" value="1" id="visible" <?= !$passion || $passion['visible'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="visible">Visible</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Description courte (sous la carte)</label>
                    <input type="text" name="short_description" class="form-control" value="<?= htmlspecialchars($passion['short_description'] ?? '') ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Description longue (dans la modale)</label>
                    <textarea name="long_description" class="form-control" rows="3"><?= htmlspecialchars($passion['long_description'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Pourquoi c'est important</label>
                    <textarea name="why" class="form-control" rows="3"><?= htmlspecialchars($passion['why'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Ce que j'aime (1 par ligne)</label>
                    <textarea name="likes" class="form-control" rows="5"><?= htmlspecialchars($likesText) ?></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Enregistrer</button>
                <a href="<?= url('admin/passions') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </div>
    </form>
</div>
<script src="/assets/js/icon-picker.js"></script>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
