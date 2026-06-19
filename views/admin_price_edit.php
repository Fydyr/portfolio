<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $price ? 'Modifier' : 'Ajouter' ?> un tarif</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1><?= $price ? 'Modifier' : 'Ajouter' ?> un tarif</h1>
    <form method="post" class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Titre *</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($price['title'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prix (texte libre, ex: 180 €, sur devis)</label>
                    <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($price['price'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icône</label>
                    <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($price['icon'] ?? '') ?>" data-icon-picker placeholder="bi bi-tags-fill">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= (int)($price['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="visible" value="1" id="visible" <?= !$price || $price['visible'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="visible">Visible</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($price['description'] ?? '') ?></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Enregistrer</button>
                <a href="<?= url('admin/prices') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </div>
    </form>
</div>
<script src="/assets/js/icon-picker.js"></script>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
