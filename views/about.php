<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - Enzo Fournier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

    <style>
        .about-hero {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        @media (min-width: 768px) {
            .about-hero { grid-template-columns: 220px 1fr; align-items: center; }
        }
        .about-avatar {
            width: 220px; height: 220px;
            border-radius: 50%;
            background: var(--gradient-primary, linear-gradient(135deg,#00d4ff,#7209b7));
            display: flex; align-items: center; justify-content: center;
            font-size: 5rem; color: #fff;
            box-shadow: 0 10px 40px rgba(0,212,255,0.3);
            margin: 0 auto;
        }
        .about-mini-stats {
            display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1.5rem;
        }
        .about-mini-stats .pill {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 999px;
            padding: 0.4rem 0.9rem;
            font-size: 0.9rem;
            display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .about-mini-stats .pill strong { color: var(--primary-color, #00d4ff); }

        .repo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }
        .repo-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 1.25rem;
            transition: all .2s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .repo-card:hover {
            border-color: var(--primary-color, #00d4ff);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,212,255,0.2);
            color: inherit;
        }
        .repo-card h4 {
            color: var(--primary-color, #00d4ff);
            margin: 0;
            font-size: 1.1rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .repo-card .repo-desc {
            color: var(--text-secondary, #a0a0a0);
            font-size: 0.92rem;
            min-height: 2.5em;
        }
        .repo-meta {
            display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;
            font-size: 0.85rem;
            color: var(--text-secondary, #a0a0a0);
            margin-top: auto;
        }
        .repo-meta .lang-dot {
            display: inline-block; width: 10px; height: 10px; border-radius: 50%;
            background: #00d4ff; margin-right: 0.4rem;
        }
        .empty-repos {
            background: rgba(255,255,255,0.04);
            border: 1px dashed rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            color: var(--text-secondary, #a0a0a0);
        }

        .section-title-about {
            color: var(--primary-color, #00d4ff);
            margin: 3rem 0 1.5rem;
            display: flex; align-items: center; gap: 0.75rem;
        }
    </style>
</head>
<body>
<div class="container py-5">

    <!-- ===== Hero ===== -->
    <div class="about-hero fade-in">
        <div class="about-avatar"><i class="fas fa-user-astronaut"></i></div>
        <div>
            <h1 style="margin: 0;">Enzo Fournier</h1>
            <p class="lead mt-3" style="color: var(--text-secondary, #a0a0a0);">
                <?= $heroSubtitle ?>
            </p>
            <div class="about-mini-stats">
                <span class="pill"><i class="bi bi-folder-fill"></i> <strong><?= (int)$projectsCount ?></strong> projets visibles</span>
                <span class="pill"><i class="bi bi-stars"></i> <strong><?= (int)$skillsCount ?></strong> compétences</span>
                <span class="pill"><i class="bi bi-heart-fill"></i> <strong><?= (int)$passionsCount ?></strong> passions</span>
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <?php if ($hasCv): ?>
                    <a href="/assets/docs/mon_cv.pdf" target="_blank" class="btn btn-primary">
                        <i class="fas fa-file-download"></i> Mon CV
                    </a>
                <?php endif; ?>
                <a href="<?= url('projects') ?>" class="btn btn-outline-light">
                    <i class="fas fa-folder-open"></i> Mes projets
                </a>
                <a href="<?= url('contact') ?>" class="btn btn-outline-light">
                    <i class="fas fa-envelope"></i> Me contacter
                </a>
                <a href="https://github.com/<?= rawurlencode($githubUser) ?>" target="_blank" rel="noopener" class="btn btn-outline-light">
                    <i class="fab fa-github"></i> GitHub
                </a>
            </div>
        </div>
    </div>

    <!-- ===== Bio détaillée ===== -->
    <?php if (!empty($bioHtml)): ?>
        <h2 class="section-title-about"><i class="bi bi-person-vcard"></i> Qui suis-je ?</h2>
        <div class="card">
            <div class="card-body">
                <?= $bioHtml ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ===== Sections personnalisées (Ce que je cherche, etc.) ===== -->
    <?php if (!empty($sections)): ?>
        <h2 class="section-title-about"><i class="bi bi-briefcase-fill"></i> Ce que je cherche</h2>
        <div class="row g-3">
            <?php foreach ($sections as $sec): ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5>
                                <?php if (!empty($sec['icon'])): ?>
                                    <i class="<?= htmlspecialchars($sec['icon']) ?> text-info"></i>
                                <?php endif; ?>
                                <?= htmlspecialchars($sec['title']) ?>
                            </h5>
                            <div class="mb-0">
                                <?= !empty($sec['is_markdown'])
                                    ? renderMarkdown($sec['content'] ?? '')
                                    : nl2br(htmlspecialchars($sec['content'] ?? '')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- ===== Derniers repos GitHub ===== -->
    <h2 class="section-title-about">
        <i class="bi bi-github"></i> Activité GitHub récente
        <a href="https://github.com/<?= htmlspecialchars($githubUser) ?>" target="_blank" rel="noopener"
           style="font-size: 0.85rem; margin-left: auto; color: var(--text-secondary, #a0a0a0);">
            Voir le profil <i class="bi bi-arrow-up-right"></i>
        </a>
    </h2>

    <?php if (empty($repos)): ?>
        <div class="empty-repos">
            <i class="bi bi-cloud-slash" style="font-size: 2rem;"></i>
            <p class="mt-2 mb-0">Impossible de récupérer les repos GitHub pour le moment.<br>
            <a href="https://github.com/<?= htmlspecialchars($githubUser) ?>" target="_blank">Voir directement sur GitHub.</a></p>
        </div>
    <?php else: ?>
        <div class="repo-grid">
            <?php foreach ($repos as $r): ?>
                <a href="<?= htmlspecialchars($r['html_url']) ?>" target="_blank" rel="noopener" class="repo-card">
                    <h4>
                        <i class="bi bi-journal-code"></i>
                        <?= htmlspecialchars($r['name']) ?>
                    </h4>
                    <p class="repo-desc">
                        <?= htmlspecialchars($r['description'] ?: 'Pas de description.') ?>
                    </p>
                    <div class="repo-meta">
                        <?php if (!empty($r['language'])): ?>
                            <span><span class="lang-dot"></span><?= htmlspecialchars($r['language']) ?></span>
                        <?php endif; ?>
                        <span><i class="bi bi-star-fill"></i> <?= (int)$r['stars'] ?></span>
                        <span><i class="bi bi-diagram-2"></i> <?= (int)$r['forks'] ?></span>
                        <?php if (!empty($r['pushed_at'])): ?>
                            <span title="<?= htmlspecialchars($r['pushed_at']) ?>">
                                <i class="bi bi-clock-history"></i>
                                <?= date('d/m/Y', strtotime($r['pushed_at'])) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
