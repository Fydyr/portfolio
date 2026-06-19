<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Projets</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Gestion des projets</h1>
        <div>
            <a href="<?= url('admin/add-project') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau projet
            </a>
            <a href="<?= url('admin') ?>" class="btn btn-outline-light">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <?php if (empty($projects)): ?>
        <div class="alert alert-warning">
            Aucun projet. <a href="<?= url('admin/add-project') ?>" class="alert-link">Créer le premier</a>.
        </div>
    <?php else: ?>
        <table class="table table-dark table-hover align-middle">
            <thead>
                <tr>
                    <th>Aperçu</th>
                    <th>Titre</th>
                    <th>Langages</th>
                    <th>Visibilité</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td style="width: 90px;">
                            <?php if (!empty($project['img1'])): ?>
                                <img src="/assets/img/projects/<?= htmlspecialchars($project['img1']) ?>"
                                     alt="" style="width: 70px; height: 50px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                                <div style="width: 70px; height: 50px; background: rgba(255,255,255,0.05); border-radius: 6px; display:flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-image" style="opacity:.4;"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong style="color: var(--primary-color);">#<?= (int)$project['id'] ?></strong>
                            <span style="color: var(--text-primary);"> - <?= htmlspecialchars($project['title']) ?></span>
                            <?php if (!empty($project['link'])): ?>
                                <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" rel="noopener"
                                   class="ms-2 text-muted" title="<?= htmlspecialchars($project['link']) ?>">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                                $langs = preg_split('/[,;\/|]/', $project['languages'] ?? '');
                                foreach ($langs as $lang):
                                    $lang = trim($lang);
                                    if ($lang === '') continue;
                            ?>
                                <span class="badge bg-secondary me-1"><?= htmlspecialchars($lang) ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td style="width: 180px;">
                            <form action="<?= url('admin/projects') ?>" method="POST" class="d-inline">
                                <input type="hidden" name="projectId" value="<?= $project['id'] ?>">
                                <input type="hidden" name="visible" value="0">
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="visible" value="1"
                                           id="vis<?= $project['id'] ?>"
                                           <?= (int)$project['visibilite'] === 1 ? 'checked' : '' ?>
                                           onchange="this.form.submit()">
                                    <label class="form-check-label" for="vis<?= $project['id'] ?>">
                                        <?php if ((int)$project['visibilite'] === 1): ?>
                                            <span class="badge bg-success">Visible</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Masqué</span>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            </form>
                        </td>
                        <td class="text-end" style="width: 160px;">
                            <a href="<?= url('admin/projects/edit-project/' . $project['id']) ?>"
                               class="btn btn-sm btn-warning" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?= url('admin/projects') ?>" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer le projet \'<?= htmlspecialchars(addslashes($project['title']), ENT_QUOTES) ?>\' ? Cette action est définitive.');">
                                <input type="hidden" name="projectId" value="<?= $project['id'] ?>">
                                <input type="hidden" name="delete" value="1">
                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-muted mt-3 small">
            <i class="bi bi-info-circle"></i>
            <?= count($projects) ?> projet<?= count($projects) > 1 ? 's' : '' ?> au total.
            <?= count(array_filter($projects, fn($p) => (int)$p['visibilite'] === 1)) ?> visible<?= count(array_filter($projects, fn($p) => (int)$p['visibilite'] === 1)) > 1 ? 's' : '' ?>.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
