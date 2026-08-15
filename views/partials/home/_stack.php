    <!-- Skills Section -->
    <section class="py-5" id="langages">
        <div class="container">
            <div class="section-header">
                <a href="#langages" class="section-badge" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-laptop-code me-2"></i>
                    Compétences
                </a>
                <h2 class="section-title">Stack Technique</h2>
                <p class="section-description">
                    Technologies et outils que j'utilise pour créer des solutions innovantes
                </p>
            </div>

            <div class="skills-container">
                <?php foreach ($categories as $cat): ?>
                    <div class="skill-card">
                        <div class="skill-icon"<?= !empty($cat['icon_bg']) ? ' style="background: ' . htmlspecialchars($cat['icon_bg']) . ';"' : '' ?>>
                            <i class="<?= htmlspecialchars($cat['icon'] ?: 'fas fa-code') ?>"></i>
                        </div>
                        <h3 class="skill-title"><?= htmlspecialchars($cat['name']) ?></h3>
                        <?php if (!empty($cat['description'])): ?>
                            <p style="color: var(--text-muted); font-size: 0.95rem;"><?= htmlspecialchars($cat['description']) ?></p>
                        <?php endif; ?>
                        <div class="skill-tags">
                            <?php foreach (($skillsByCategory[(int)$cat['id']] ?? []) as $skill): ?>
                                <span class="skill-tag tech-badge" data-tech="<?= htmlspecialchars($skill['slug']) ?>">
                                    <?= htmlspecialchars($skill['name']) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
