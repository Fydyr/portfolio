<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Tarifs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Gestion des tarifs</h1>
        <div>
            <a href="<?= url('admin/prices/add') ?>" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Ajouter</a>
            <a href="<?= url('admin') ?>" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Retour</a>
        </div>
    </div>

    <?php if (empty($prices)): ?>
        <div class="alert alert-warning">Aucun tarif encore.</div>
    <?php else: ?>
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Ordre</th>
                    <th>Visible</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prices as $p): ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['icon'])): ?><i class="<?= htmlspecialchars($p['icon']) ?> me-2"></i><?php endif; ?>
                            <strong><?= htmlspecialchars($p['title']) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($p['price'] ?? '') ?></td>
                        <td><?= (int)$p['sort_order'] ?></td>
                        <td>
                            <?php if ($p['visible']): ?>
                                <span class="badge bg-success">Oui</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Non</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="<?= url('admin/prices/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="post" action="<?= url('admin/prices/delete') ?>" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce tarif ?');">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
