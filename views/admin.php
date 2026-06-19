<?php
ob_start();

function fmtBytes($n) {
    if ($n === null) return '-';
    if ($n < 1024) return $n . ' o';
    if ($n < 1024 * 1024) return number_format($n / 1024, 1, ',', ' ') . ' Ko';
    return number_format($n / (1024 * 1024), 1, ',', ' ') . ' Mo';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Enzo Fournier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

    <style>
        .stat-tile {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 1.25rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all .2s;
            text-decoration: none;
            color: inherit;
        }
        .stat-tile:hover {
            border-color: rgba(0,212,255,0.5);
            transform: translateY(-2px);
            color: inherit;
        }
        .stat-tile .stat-icon {
            font-size: 1.75rem;
            width: 48px; height: 48px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px;
            background: var(--gradient-primary, linear-gradient(135deg,#00d4ff,#7209b7));
            color: #fff;
            flex-shrink: 0;
        }
        .stat-tile .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }
        .stat-tile .stat-label {
            font-size: .85rem;
            color: var(--text-secondary, #a0a0a0);
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .admin-card-link { text-decoration: none; color: inherit; display: block; height: 100%; }
        .admin-card-link .card { height: 100%; transition: all .2s; cursor: pointer; }
        .admin-card-link:hover .card { transform: translateY(-3px); box-shadow: 0 0 25px rgba(0,212,255,0.25); }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="profile-header fade-in mb-4">
        <div class="profile-avatar"><i class="bi bi-speedometer2"></i></div>
        <h1>Dashboard administration</h1>
    </div>

    <!-- === Stats === -->
    <h2 class="mt-4 mb-3"><i class="bi bi-bar-chart-fill"></i> Aperçu</h2>
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <a href="<?= url('admin/projects') ?>" class="stat-tile">
                <div class="stat-icon"><i class="bi bi-folder-fill"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['projects_total'] ?></div>
                    <div class="stat-label">Projets total</div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="<?= url('projects') ?>" class="stat-tile" target="_blank">
                <div class="stat-icon" style="background: linear-gradient(135deg,#00ff88,#00d4ff);"><i class="bi bi-eye-fill"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['projects_visible'] ?></div>
                    <div class="stat-label">Projets visibles</div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-tile">
                <div class="stat-icon" style="background: linear-gradient(135deg,#ffaa00,#ff006e);"><i class="bi bi-eye-slash-fill"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['projects_hidden'] ?></div>
                    <div class="stat-label">Projets masqués</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-tile">
                <div class="stat-icon" style="background: linear-gradient(135deg,#7209b7,#00d4ff);"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="stat-value"><?= number_format((int)$stats['visitors'], 0, ',', ' ') ?></div>
                    <div class="stat-label">Visites totales</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="<?= url('admin/skills') ?>" class="stat-tile">
                <div class="stat-icon" style="background: linear-gradient(135deg,#00d4ff,#7209b7);"><i class="bi bi-stars"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['skills_total'] ?></div>
                    <div class="stat-label">Compétences (<?= (int)$stats['skill_cats_total'] ?> cat.)</div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="<?= url('admin/passions') ?>" class="stat-tile">
                <div class="stat-icon" style="background: linear-gradient(135deg,#EF4444,#DC2626);"><i class="bi bi-heart-fill"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['passions_total'] ?></div>
                    <div class="stat-label">Passions</div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="<?= url('admin/prices') ?>" class="stat-tile">
                <div class="stat-icon" style="background: linear-gradient(135deg,#ffaa00,#ff006e);"><i class="bi bi-tags-fill"></i></div>
                <div>
                    <div class="stat-value"><?= (int)$stats['prices_total'] ?></div>
                    <div class="stat-label">Tarifs</div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="<?= url('admin/cv') ?>" class="stat-tile">
                <div class="stat-icon" style="background: linear-gradient(135deg,#00d4ff,#0080ff);"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <div>
                    <div class="stat-value">
                        <?= !empty($stats['cv_size']) ? fmtBytes($stats['cv_size']) : '-' ?>
                    </div>
                    <div class="stat-label">
                        CV
                        <?= !empty($stats['cv_modified']) ? '· MAJ ' . date('d/m/Y', $stats['cv_modified']) : '· absent' ?>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-3">
        <!-- === Derniers projets === -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="mb-0"><i class="bi bi-clock-history"></i> Derniers projets</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($latestProjects)): ?>
                        <p class="text-muted mb-0">Aucun projet pour l'instant.</p>
                    <?php else: ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($latestProjects as $p): ?>
                                <li class="d-flex justify-content-between align-items-center py-2"
                                    style="border-bottom: 1px solid rgba(255,255,255,0.08); color: var(--text-primary);">
                                    <span style="color: var(--text-primary);">
                                        <strong style="color: var(--primary-color);">#<?= (int)$p['id'] ?></strong>
                                        <span style="color: var(--text-primary);"> - <?= htmlspecialchars($p['title']) ?></span>
                                        <?php if ((int)$p['visibilite'] === 1): ?>
                                            <span class="badge bg-success ms-2">visible</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary ms-2">masqué</span>
                                        <?php endif; ?>
                                    </span>
                                    <a href="<?= url('admin/projects/edit-project/' . (int)$p['id']) ?>" class="btn btn-sm btn-outline-light">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- === Infos système === -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="mb-0"><i class="bi bi-info-circle-fill"></i> Système</h3>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Utilisateurs admin :</strong> <?= (int)$stats['users_total'] ?></p>
                    <p class="mb-2"><strong>PHP :</strong> <?= htmlspecialchars(PHP_VERSION) ?></p>
                    <?php if (!empty($stats['last_migration'])): ?>
                        <p class="mb-0">
                            <strong>Dernière migration :</strong><br>
                            <code><?= htmlspecialchars($stats['last_migration']['filename']) ?></code>
                            <br>
                            <small class="text-muted">appliquée le <?= htmlspecialchars($stats['last_migration']['applied_at']) ?></small>
                        </p>
                    <?php else: ?>
                        <p class="mb-0 text-muted">Aucune migration trouvée.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- === Raccourcis === -->
    <h2 class="mt-5 mb-3"><i class="bi bi-grid-3x3-gap-fill"></i> Gestion</h2>
    <div class="row g-3">

        <div class="col-md-4">
            <a href="<?= url('admin/add-project') ?>" class="admin-card-link">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-plus-circle" style="font-size:2rem;color:var(--primary-color,#00d4ff);"></i>
                        <h5 class="card-title mt-2">Ajouter un projet</h5>
                        <p class="card-text text-muted">Créer une nouvelle entrée projet</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= url('admin/projects') ?>" class="admin-card-link">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-folder2-open" style="font-size:2rem;color:#ffaa00;"></i>
                        <h5 class="card-title mt-2">Gérer les projets</h5>
                        <p class="card-text text-muted">Modifier, masquer, supprimer</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= url('admin/skills') ?>" class="admin-card-link">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-stars" style="font-size:2rem;color:#00d4ff;"></i>
                        <h5 class="card-title mt-2">Compétences</h5>
                        <p class="card-text text-muted">Catégories &amp; skills</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= url('admin/passions') ?>" class="admin-card-link">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-heart-fill" style="font-size:2rem;color:#EF4444;"></i>
                        <h5 class="card-title mt-2">Passions</h5>
                        <p class="card-text text-muted">Liste affichée sur la home</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= url('admin/prices') ?>" class="admin-card-link">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-tags-fill" style="font-size:2rem;color:#ffaa00;"></i>
                        <h5 class="card-title mt-2">Tarifs</h5>
                        <p class="card-text text-muted">Prestations &amp; prix</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= url('admin/cv') ?>" class="admin-card-link">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-pdf-fill" style="font-size:2rem;color:#00d4ff;"></i>
                        <h5 class="card-title mt-2">Mon CV</h5>
                        <p class="card-text text-muted">Uploader / remplacer le PDF</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="<?= url('admin/about') ?>" class="admin-card-link">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="bi bi-person-vcard" style="font-size:2rem;color:#7209b7;"></i>
                        <h5 class="card-title mt-2">Page À propos</h5>
                        <p class="card-text text-muted">Bio, sections, compte GitHub</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>
</body>
</html>

<?php $content = ob_get_clean(); include 'layout.php'; ?>
