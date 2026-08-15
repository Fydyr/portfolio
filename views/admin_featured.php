<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Projets à la une</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        .feat-list {
            list-style: none;
            margin: 0;
            padding: 0;
            min-height: 3.5rem;
        }

        .feat-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0.9rem;
            margin-bottom: 0.5rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-primary);
        }

        .feat-item.dragging { opacity: 0.4; }
        .feat-item.drop-target { border-color: var(--primary-color); }

        .feat-handle {
            cursor: grab;
            color: var(--text-muted);
            flex: 0 0 auto;
        }

        .feat-handle:active { cursor: grabbing; }

        .feat-rank {
            flex: 0 0 1.6rem;
            font-weight: 700;
            color: var(--primary-color);
            font-variant-numeric: tabular-nums;
        }

        .feat-title { flex: 1; min-width: 0; }

        .feat-actions { display: flex; gap: 0.25rem; flex: 0 0 auto; }

        .feat-btn {
            width: 2rem;
            height: 2rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid rgba(148, 163, 184, 0.25);
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .feat-btn:hover:not(:disabled) { border-color: var(--primary-color); color: var(--primary-color); }
        .feat-btn:disabled { opacity: 0.3; cursor: not-allowed; }
        .feat-btn.is-remove:hover { border-color: var(--danger-color); color: var(--danger-color); }
        .feat-btn.is-add:hover { border-color: var(--success-color); color: var(--success-color); }

        .feat-empty {
            padding: 1rem;
            text-align: center;
            color: var(--text-muted);
            border: 1px dashed rgba(148, 163, 184, 0.25);
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Projets à la une</h1>
        <a href="<?= url('admin') ?>" class="btn btn-outline-light">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <?php $success = getFlash('success'); ?>
    <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <p class="text-muted">
        Ces projets apparaissent sur la page d'accueil, dans l'ordre ci-dessous.
        Sans aucune sélection, l'accueil affiche automatiquement les 3 projets les plus récents.
    </p>

    <form method="post" action="<?= url('admin/featured/save') ?>">
        <?= csrfField() ?>
        <input type="hidden" name="order" id="order-input" value="">

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0"><i class="bi bi-star-fill"></i> À la une</h2>
            </div>
            <div class="card-body">
                <ul class="feat-list" id="list-featured">
                    <?php foreach ($featured as $p): ?>
                        <li class="feat-item" draggable="true" data-id="<?= (int)$p['id'] ?>">
                            <i class="bi bi-grip-vertical feat-handle" aria-hidden="true"></i>
                            <span class="feat-rank"></span>
                            <span class="feat-title">
                                <?= htmlspecialchars($p['title']) ?>
                                <?php if ((int)$p['visibilite'] !== 1): ?>
                                    <span class="badge bg-warning text-dark ms-2"
                                          title="Ce projet est masqué : il n'apparaîtra pas sur l'accueil.">
                                        <i class="bi bi-exclamation-triangle-fill"></i> masqué
                                    </span>
                                <?php endif; ?>
                            </span>
                            <span class="feat-actions">
                                <button type="button" class="feat-btn js-up" title="Monter" aria-label="Monter">
                                    <i class="bi bi-arrow-up"></i>
                                </button>
                                <button type="button" class="feat-btn js-down" title="Descendre" aria-label="Descendre">
                                    <i class="bi bi-arrow-down"></i>
                                </button>
                                <button type="button" class="feat-btn is-remove js-remove" title="Retirer de la une" aria-label="Retirer de la une">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="feat-empty" id="featured-empty" hidden>
                    Aucun projet à la une. L'accueil affichera les 3 plus récents.
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0"><i class="bi bi-collection"></i> Autres projets</h2>
            </div>
            <div class="card-body">
                <ul class="feat-list" id="list-others">
                    <?php foreach ($others as $p): ?>
                        <li class="feat-item" data-id="<?= (int)$p['id'] ?>">
                            <span class="feat-title">
                                <?= htmlspecialchars($p['title']) ?>
                                <?php if ((int)$p['visibilite'] !== 1): ?>
                                    <span class="badge bg-secondary ms-2">masqué</span>
                                <?php endif; ?>
                            </span>
                            <span class="feat-actions">
                                <button type="button" class="feat-btn is-add js-add" title="Mettre à la une" aria-label="Mettre à la une">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="feat-empty" id="others-empty" hidden>
                    Tous les projets sont à la une.
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Enregistrer
        </button>
    </form>
</div>

<script src="/assets/js/admin-featured.js" defer></script>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
