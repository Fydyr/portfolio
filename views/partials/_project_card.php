<?php
/**
 * Carte projet, partagée par la page d'accueil et /projects.
 *
 * Attend un tableau $project contenant : id, title, img1, excerpt, tags, cats.
 * HomeController et ProjectsController produisent tous deux exactement ces clés.
 *
 * Les badges sont des <span>, jamais des boutons : la carte entière est un <a>,
 * et un élément interactif imbriqué dans un lien produirait du HTML invalide.
 * Le filtrage de /projects passe par les puces situées au-dessus de la grille.
 */
?>
<a href="<?= url('project-detail/' . $project['id']) ?>" class="project-card">
    <div class="project-image">
        <img src="/assets/img/projects/<?= htmlspecialchars($project['img1'] ?? '') ?>"
             alt="<?= htmlspecialchars($project['title']) ?>"
             loading="lazy" width="400" height="260">
        <div class="project-image-overlay">
            <button class="project-view-btn">
                <i class="fas fa-eye me-2"></i>
                Voir le projet
            </button>
        </div>
    </div>
    <div class="project-body">
        <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
        <p class="project-description">
            <?= htmlspecialchars($project['excerpt'] ?? '') ?>
        </p>
        <?php if (!empty($project['cats']) || !empty($project['tags'])): ?>
            <div class="project-meta">
                <?php foreach ($project['cats'] as $c): ?>
                    <span class="project-badge is-cat"><?= htmlspecialchars($c) ?></span>
                <?php endforeach; ?>
                <?php foreach ($project['tags'] as $t): ?>
                    <span class="project-badge is-tag"><?= htmlspecialchars($t) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</a>
