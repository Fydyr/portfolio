    <!-- Modale pour les technologies -->
    <div id="techModal" class="tech-modal" style="z-index: 999999 !important;">
        <div class="tech-modal-overlay" style="z-index: 999999 !important;"></div>
        <div class="tech-modal-content" style="z-index: 1000000 !important;">
            <button class="tech-modal-close" aria-label="Fermer">
                <i class="fas fa-times"></i>
            </button>
            <div class="tech-modal-header">
                <div class="tech-modal-icon">
                    <i class="tech-icon-display"></i>
                </div>
                <h2 class="tech-modal-title"></h2>
            </div>
            <div class="tech-modal-body">
                <p class="tech-modal-description"></p>
                <div class="tech-modal-info">
                    <div class="tech-info-item">
                        <i class="fas fa-layer-group"></i>
                        <span class="tech-info-label">Type:</span>
                        <span class="tech-info-value tech-type"></span>
                    </div>
                    <div class="tech-info-item">
                        <i class="fas fa-chart-line"></i>
                        <span class="tech-info-label">Niveau:</span>
                        <span class="tech-info-value tech-level"></span>
                    </div>
                </div>
                <div class="tech-modal-features">
                    <h4><i class="fas fa-lightbulb me-2"></i>Utilisation:</h4>
                    <ul class="tech-features-list"></ul>
                </div>
                <div class="tech-modal-actions">
                    <a href="#" class="btn-modal btn-modal-docs" target="_blank" rel="noopener noreferrer">
                        <i class="fas fa-book"></i>
                        <span>Documentation</span>
                    </a>
                    <button class="btn-modal btn-modal-close">
                        <i class="fas fa-times"></i>
                        <span>Fermer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale pour les passions -->
    <div id="passionModal" class="tech-modal" style="z-index: 999999 !important;">
        <div class="tech-modal-overlay" style="z-index: 999999 !important;"></div>
        <div class="tech-modal-content" style="z-index: 1000000 !important;">
            <button class="passion-modal-close tech-modal-close" aria-label="Fermer">
                <i class="fas fa-times"></i>
            </button>
            <div class="tech-modal-header">
                <div class="tech-modal-icon passion-modal-icon">
                    <i class="passion-icon-display"></i>
                </div>
                <h2 class="tech-modal-title passion-modal-title"></h2>
            </div>
            <div class="tech-modal-body">
                <p class="tech-modal-description passion-modal-description"></p>
                <div class="tech-modal-features">
                    <h4><i class="fas fa-heart me-2"></i>Ce que j'aime:</h4>
                    <ul class="tech-features-list passion-likes-list"></ul>
                </div>
                <div class="tech-modal-features" style="margin-top: 1.5rem;">
                    <h4><i class="fas fa-star me-2"></i>Pourquoi c'est important:</h4>
                    <p class="passion-modal-why"></p>
                </div>
                <div class="tech-modal-actions">
                    <button class="btn-modal btn-modal-close passion-btn-close">
                        <i class="fas fa-times"></i>
                        <span>Fermer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modale pour le BUT Informatique -->
    <div id="butModal" class="tech-modal" style="z-index: 999999 !important;">
        <div class="tech-modal-overlay" style="z-index: 999999 !important;"></div>
        <div class="tech-modal-content" style="z-index: 1000000 !important;">
            <button class="but-modal-close tech-modal-close" aria-label="Fermer">
                <i class="fas fa-times"></i>
            </button>
            <div class="tech-modal-header">
                <div class="tech-modal-icon" style="background: var(--gradient-primary);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h2 class="tech-modal-title">BUT Informatique &mdash; Parcours A</h2>
            </div>
            <div class="tech-modal-body">
                <p class="tech-modal-description">
                    Le BUT Informatique est une formation en 3 ans d&eacute;clin&eacute;e en diff&eacute;rents parcours. J&rsquo;ai suivi le <strong>Parcours A &mdash; R&eacute;alisation de logiciels</strong>, centr&eacute; sur le d&eacute;veloppement d&rsquo;applications et la ma&icirc;trise du cycle de vie logiciel.
                </p>
                <div class="tech-modal-features">
                    <h4><i class="fas fa-check-circle me-2" style="color: var(--primary-color);"></i>C1 &mdash; R&eacute;aliser un d&eacute;veloppement d&rsquo;application</h4>
                    <ul class="tech-features-list">
                        <li><i class="fas fa-check-circle"></i> Concevoir et d&eacute;velopper des applications informatiques</li>
                        <li><i class="fas fa-check-circle"></i> Appliquer des principes d&rsquo;architecture logicielle (MVC, API REST, etc.)</li>
                        <li><i class="fas fa-check-circle"></i> Utiliser des outils et m&eacute;thodologies de d&eacute;veloppement modernes</li>
                        <li><i class="fas fa-check-circle"></i> Garantir la qualit&eacute; du code (tests, revue, documentation)</li>
                    </ul>
                </div>
                <div class="tech-modal-features" style="margin-top: 1.5rem;">
                    <h4><i class="fas fa-check-circle me-2" style="color: var(--primary-color);"></i>C2 &mdash; Optimiser des applications informatiques</h4>
                    <ul class="tech-features-list">
                        <li><i class="fas fa-check-circle"></i> Analyser et am&eacute;liorer les performances d&rsquo;une application</li>
                        <li><i class="fas fa-check-circle"></i> Choisir les algorithmes et structures de donn&eacute;es adapt&eacute;s</li>
                        <li><i class="fas fa-check-circle"></i> Optimiser les requ&ecirc;tes et les acc&egrave;s aux bases de donn&eacute;es</li>
                        <li><i class="fas fa-check-circle"></i> R&eacute;duire la consommation de ressources (m&eacute;moire, CPU, r&eacute;seau)</li>
                    </ul>
                </div>
                <div class="tech-modal-features" style="margin-top: 1.5rem;">
                    <h4><i class="fas fa-check-circle me-2" style="color: var(--primary-color);"></i>C6 &mdash; Collaborer au sein d&rsquo;une &eacute;quipe informatique</h4>
                    <ul class="tech-features-list">
                        <li><i class="fas fa-check-circle"></i> Travailler en &eacute;quipe avec des m&eacute;thodologies agiles (Scrum, Kanban)</li>
                        <li><i class="fas fa-check-circle"></i> Utiliser des outils de versioning et de gestion de projets (Git, GitHub)</li>
                        <li><i class="fas fa-check-circle"></i> Communiquer efficacement sur les avanc&eacute;es et les probl&egrave;mes techniques</li>
                        <li><i class="fas fa-check-circle"></i> Int&eacute;grer et respecter les conventions et bonnes pratiques d&rsquo;&eacute;quipe</li>
                    </ul>
                </div>
                <div class="tech-modal-actions">
                    <button class="btn-modal btn-modal-close but-btn-close">
                        <i class="fas fa-times"></i>
                        <span>Fermer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
