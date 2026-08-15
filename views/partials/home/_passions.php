    <!-- Passions Section -->
    <section class="py-5" id="passions" style="background: linear-gradient(180deg, transparent 0%, rgba(30, 41, 59, 0.3) 50%, transparent 100%);">
        <div class="container">
            <div class="section-header">
                <a href="#passions" class="section-badge" style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.3); color: #EF4444; text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
                    <i class="fas fa-heart me-2"></i>
                    Passions
                </a>
                <h2 class="section-title">Au-delà du code</h2>
                <p class="section-description">
                    Ce qui me passionne et m'inspire au quotidien
                </p>
            </div>

            <div class="passions-grid">
                <?php foreach ($passions as $p): ?>
                    <div class="passion-card" data-passion="<?= htmlspecialchars($p['slug']) ?>">
                        <div class="passion-icon">
                            <i class="<?= htmlspecialchars($p['icon'] ?: 'fas fa-heart') ?>"></i>
                        </div>
                        <h3 class="passion-title"><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="passion-description"><?= htmlspecialchars($p['short_description'] ?? '') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
