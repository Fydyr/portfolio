<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - À propos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Page À propos</h1>
        <a href="<?= url('admin') ?>" class="btn btn-outline-light">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <!-- === Settings === -->
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="mb-0"><i class="bi bi-gear-fill"></i> Contenu principal</h2>
        </div>
        <div class="card-body">
            <form method="post" action="<?= url('admin/about/save') ?>">
                <?php foreach ($settingsDef as $key => $def):
                    $value = $stored[$key]['value'] ?? '';
                    $rows  = $def['markdown'] ? 10 : 3;
                ?>
                    <div class="mb-4">
                        <label class="form-label">
                            <strong><?= htmlspecialchars($def['label']) ?></strong>
                            <?php if (!empty($def['markdown'])): ?>
                                <span class="badge bg-info ms-2">Markdown</span>
                            <?php endif; ?>
                        </label>
                        <textarea name="<?= htmlspecialchars($key) ?>" class="form-control" rows="<?= $rows ?>"
                                  style="font-family: <?= !empty($def['markdown']) ? "'JetBrains Mono', monospace" : 'inherit' ?>; font-size: 0.95rem;"><?= htmlspecialchars($value) ?></textarea>
                        <?php if (!empty($def['hint'])): ?>
                            <div class="form-text"><?= htmlspecialchars($def['hint']) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Enregistrer
                </button>
                <a href="<?= url('about') ?>" target="_blank" class="btn btn-outline-light">
                    <i class="bi bi-eye"></i> Aperçu de la page
                </a>
            </form>
        </div>
    </div>

    <!-- === Sections === -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0"><i class="bi bi-grid-3x3-gap-fill"></i> Sections "Ce que je cherche"</h2>
        <a href="<?= url('admin/about/section/add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nouvelle section
        </a>
    </div>

    <?php if (empty($sections)): ?>
        <div class="alert alert-warning">Aucune section.</div>
    <?php else: ?>
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Slug</th>
                    <th>Ordre</th>
                    <th>Visible</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sections as $s): ?>
                    <tr>
                        <td>
                            <?php if (!empty($s['icon'])): ?><i class="<?= htmlspecialchars($s['icon']) ?> me-2"></i><?php endif; ?>
                            <strong><?= htmlspecialchars($s['title']) ?></strong>
                        </td>
                        <td><code><?= htmlspecialchars($s['slug']) ?></code></td>
                        <td><?= (int)$s['sort_order'] ?></td>
                        <td>
                            <?php if ($s['visible']): ?>
                                <span class="badge bg-success">Oui</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Non</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="<?= url('admin/about/section/edit/' . $s['id']) ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="post" action="<?= url('admin/about/section/delete') ?>" class="d-inline"
                                  onsubmit="return confirm('Supprimer cette section ?');">
                                <input type="hidden" name="id" value="<?= $s['id'] ?>">
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
