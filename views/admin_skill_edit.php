<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($skill) && $skill ? 'Modifier' : 'Ajouter' ?> un skill</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1><?= $skill ? 'Modifier' : 'Ajouter' ?> un skill</h1>

    <?php
    $featuresText = '';
    if (!empty($skill['features'])) {
        $arr = json_decode($skill['features'], true);
        if (is_array($arr)) $featuresText = implode("\n", $arr);
    }
    ?>

    <form method="post" class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Catégorie *</label>
                    <select name="category_id" class="form-select" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= isset($skill) && $skill && (int)$skill['category_id'] === (int)$cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nom *</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($skill['name'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug (unique, kebab-case) *</label>
                    <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($skill['slug'] ?? '') ?>" required
                           pattern="[a-z0-9-]+" placeholder="ex: html-css">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Type</label>
                    <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($skill['type'] ?? '') ?>" placeholder="ex: Langage de programmation">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Niveau</label>
                    <select name="level" class="form-select">
                        <?php foreach (['Débutant', 'Intermédiaire', 'Avancé'] as $lvl): ?>
                            <option value="<?= $lvl ?>" <?= ($skill['level'] ?? '') === $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Icône</label>
                    <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($skill['icon'] ?? '') ?>" data-icon-picker placeholder="fab fa-python">
                </div>
                <div class="col-md-6">
                    <label class="form-label">URL doc</label>
                    <input type="url" name="doc_url" class="form-control" value="<?= htmlspecialchars($skill['doc_url'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= (int)($skill['sort_order'] ?? 0) ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="visible" value="1" id="visible" <?= !isset($skill) || $skill['visible'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="visible">Visible</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($skill['description'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Features (1 par ligne)</label>
                    <textarea name="features" class="form-control" rows="5" placeholder="Manipulation du DOM&#10;Applications web interactives"><?= htmlspecialchars($featuresText) ?></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Enregistrer
                </button>
                <a href="<?= url('admin/skills') ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </div>
    </form>
</div>
<script src="/assets/js/icon-picker.js"></script>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
