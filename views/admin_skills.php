<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Skills</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Gestion des compétences</h1>
        <div>
            <a href="<?= url('admin/skills/category/add') ?>" class="btn btn-secondary">
                <i class="bi bi-folder-plus"></i> Nouvelle catégorie
            </a>
            <a href="<?= url('admin/skills/add') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau skill
            </a>
            <a href="<?= url('admin') ?>" class="btn btn-outline-light">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <?php if (empty($categories)): ?>
        <div class="alert alert-warning">Aucune catégorie. Crée-en une pour commencer.</div>
    <?php endif; ?>

    <?php foreach ($categories as $cat): ?>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">
                    <?php if (!empty($cat['icon'])): ?><i class="<?= htmlspecialchars($cat['icon']) ?> me-2"></i><?php endif; ?>
                    <?= htmlspecialchars($cat['name']) ?>
                    <?php if (!$cat['visible']): ?><span class="badge bg-secondary ms-2">Masquée</span><?php endif; ?>
                </h3>
                <div>
                    <a href="<?= url('admin/skills/category/edit/' . $cat['id']) ?>" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="post" action="<?= url('admin/skills/category/delete') ?>" class="d-inline"
                          onsubmit="return confirm('Supprimer la catégorie ET tous ses skills ?');">
                        <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <?php $catSkills = array_filter($skills, fn($s) => (int)$s['category_id'] === (int)$cat['id']); ?>
                <?php if (empty($catSkills)): ?>
                    <p class="text-muted mb-0">Aucun skill dans cette catégorie.</p>
                <?php else: ?>
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Slug</th>
                                <th>Niveau</th>
                                <th>Ordre</th>
                                <th>Visible</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($catSkills as $skill): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($skill['icon'])): ?><i class="<?= htmlspecialchars($skill['icon']) ?> me-2"></i><?php endif; ?>
                                        <strong><?= htmlspecialchars($skill['name']) ?></strong>
                                    </td>
                                    <td><code><?= htmlspecialchars($skill['slug']) ?></code></td>
                                    <td><?= htmlspecialchars($skill['level']) ?></td>
                                    <td><?= (int)$skill['sort_order'] ?></td>
                                    <td>
                                        <?php if ($skill['visible']): ?>
                                            <span class="badge bg-success">Oui</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="<?= url('admin/skills/edit/' . $skill['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="post" action="<?= url('admin/skills/delete') ?>" class="d-inline"
                                              onsubmit="return confirm('Supprimer ce skill ?');">
                                            <input type="hidden" name="id" value="<?= $skill['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
