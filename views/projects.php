<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        .projects-hero {
            text-align: center;
            padding: 4rem 0 3rem;
            position: relative;
        }

        .projects-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
        }

        .projects-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .projects-subtitle {
            color: var(--text-secondary);
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        /* Le style de la carte projet vit desormais dans assets/css/style.css :
           le fragment views/partials/_project_card.php est partage avec la page
           d accueil, qui ne charge pas ce bloc <style>. */


        /* === Panneau de filtrage ===
           Un seul objet plutôt que trois éléments empilés : c'est ce qui
           distingue un panneau de contrôle d'une liste. */
        /* Largeur de lecture, centrée. En pleine largeur du conteneur, les puces
           s'arrêtaient au tiers et laissaient un vide de 600 px à droite. Un
           panneau resserré au-dessus d'une grille large se lit comme un poste de
           commande au-dessus d'une galerie — la différence de largeur devient un
           choix, pas un accident. */
        .filter-panel {
            max-width: 960px;
            margin: 0 auto 3rem;
            background: rgba(30, 41, 59, 0.35);
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: var(--border-radius, 16px);
            backdrop-filter: blur(12px);
            overflow: hidden;
        }

        .filter-panel-head {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.12);
        }

        .filter-search-wrap {
            position: relative;
            flex: 1 1 240px;
            max-width: 440px;
        }

        .filter-search-wrap > i {
            position: absolute;
            left: 0.95rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.85rem;
            pointer-events: none;
        }

        .filter-search {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.4rem;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            background: rgba(10, 10, 15, 0.4);
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .filter-search::placeholder { color: var(--text-muted); }

        .filter-search:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.15);
        }

        /* Le décompte pousse à droite : c'est le résultat, il termine la lecture. */
        .filter-tally {
            display: flex;
            align-items: baseline;
            gap: 0.9rem;
            margin-left: auto;
            font-size: 0.8rem;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .filter-tally strong {
            color: var(--text-primary);
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1;
            font-variant-numeric: tabular-nums;
            margin-right: 0.15rem;
        }

        .filter-reset {
            background: none;
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 999px;
            color: var(--text-secondary);
            font-size: 0.75rem;
            cursor: pointer;
            padding: 0.28rem 0.75rem;
            transition: var(--transition);
        }

        .filter-reset:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .filter-reset:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        .filter-panel-body { padding: 0.25rem 1.25rem 1rem; }

        .filter-row {
            display: flex;
            align-items: baseline;
            gap: 0.9rem;
            padding: 0.8rem 0;
        }

        .filter-row + .filter-row { border-top: 1px solid rgba(148, 163, 184, 0.09); }

        /* Le libellé est aligné à droite contre sa rangée de puces : les deux
           colonnes se rejoignent sur une arête nette au lieu de flotter. */
        .filter-row-label {
            flex: 0 0 5rem;
            text-align: right;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--text-muted);
        }

        .filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
            flex: 1;
        }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border-radius: 999px;
            border: 1px solid transparent;
            background: transparent;
            cursor: pointer;
            transition: var(--transition);
        }

        /* Le compteur est séparé du libellé par un filet, pas par un espace :
           sans lui, « Outil 2 » se lit comme un seul mot. */
        .filter-chip .chip-count {
            font-size: 0.66rem;
            font-variant-numeric: tabular-nums;
            opacity: 0.7;
            padding-left: 0.4rem;
            border-left: 1px solid currentColor;
            border-left-color: rgba(255, 255, 255, 0.18);
        }

        /* Une puce qui ne ramènerait aucun résultat s'efface, mais reste
           cliquable : la désactiver piégerait l'utilisateur dans son filtre. */
        .filter-chip.is-empty { opacity: 0.3; }

        /* Catégories : pleines et affirmées, elles structurent — et reprennent
           le violet des badges `is-cat` portés par les cartes. */
        .filter-chip.for-cat {
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            background: rgba(114, 9, 183, 0.14);
            border-color: rgba(114, 9, 183, 0.35);
            color: #c9a6ff;
        }

        .filter-chip.for-cat:hover { border-color: rgba(114, 9, 183, 0.75); }

        .filter-chip.for-cat[aria-pressed="true"] {
            background: var(--gradient-primary);
            border-color: transparent;
            color: #fff;
        }

        /* Technos : plus petites, en monospace système — elles détaillent.
           Monospace *système* : aucune requête réseau supplémentaire. */
        .filter-chip.for-tag {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 0.72rem;
            padding: 0.25rem 0.7rem;
            border-color: rgba(148, 163, 184, 0.22);
            color: var(--text-secondary);
        }

        .filter-chip.for-tag:hover {
            border-color: var(--primary-color);
            color: var(--text-primary);
        }

        .filter-chip.for-tag[aria-pressed="true"] {
            background: rgba(0, 212, 255, 0.14);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .filter-chip:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        @media (prefers-reduced-motion: reduce) {
            .filter-chip { transition: none; }
        }

        @media (max-width: 575px) {
            .filter-row { flex-direction: column; align-items: flex-start; gap: 0.45rem; }
            /* Empilé, l'alignement à droite n'a plus de colonne en face : il
               laisserait le libellé flotter loin de ses puces. */
            .filter-row-label { flex: none; text-align: left; }
            .filter-panel-head { gap: 0.75rem; }
            .filter-search-wrap { max-width: none; }
            .filter-tally { margin-left: 0; }
        }

        .no-results {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-state-title {
            color: var(--text-secondary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state-description {
            color: var(--text-muted);
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .projects-hero {
                padding: 2rem 0 1.5rem;
            }

            .project-image {
                height: 220px;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="projects-hero">
        <div class="container">
            <div class="projects-badge">
                <i class="fas fa-folder-open"></i>
                Portfolio
            </div>
            <h1 class="projects-title">Mes Projets</h1>
            <p class="projects-subtitle">
                Découvrez les projets que j'ai réalisés, allant du développement backend aux applications complètes
            </p>
        </div>
    </section>

    <!-- Projects Grid -->
    <section class="py-4">
        <div class="container">
            <?php if (!empty($projects)): ?>
                <div class="filter-panel">
                    <div class="filter-panel-head">
                        <div class="filter-search-wrap">
                            <i class="fas fa-magnifying-glass"></i>
                            <label for="project-search" class="visually-hidden">Rechercher un projet</label>
                            <input type="search" id="project-search" class="filter-search"
                                   placeholder="Rechercher un projet, une techno, une catégorie…"
                                   autocomplete="off">
                        </div>
                        <div class="filter-tally" aria-live="polite">
                            <span id="filter-count-text"></span>
                            <button type="button" id="filter-reset" class="filter-reset" hidden>Réinitialiser</button>
                        </div>
                    </div>

                    <div class="filter-panel-body">
                        <?php if (!empty($allCategories)): ?>
                            <div class="filter-row">
                                <span class="filter-row-label" id="lbl-cat">Catégories</span>
                                <div class="filter-chips" role="group" aria-labelledby="lbl-cat">
                                    <?php foreach ($allCategories as $c): ?>
                                        <button type="button" class="filter-chip for-cat" aria-pressed="false"
                                                data-kind="cat" data-value="<?= htmlspecialchars(mb_strtolower($c)) ?>">
                                            <?= htmlspecialchars($c) ?><span class="chip-count"></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($allTags)): ?>
                            <div class="filter-row">
                                <span class="filter-row-label" id="lbl-tag">Technos</span>
                                <div class="filter-chips" role="group" aria-labelledby="lbl-tag">
                                    <?php foreach ($allTags as $t): ?>
                                        <button type="button" class="filter-chip for-tag" aria-pressed="false"
                                                data-kind="tag" data-value="<?= htmlspecialchars(mb_strtolower($t)) ?>">
                                            <?= htmlspecialchars($t) ?><span class="chip-count"></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (empty($projects)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h2 class="empty-state-title">Aucun projet disponible</h2>
                    <p class="empty-state-description">Les projets seront bientôt disponibles</p>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($projects as $project): ?>
                        <div class="col-md-6 col-lg-4 project-item"
                             data-cats="<?= htmlspecialchars(implode('|', $project['cats_key'])) ?>"
                             data-tags="<?= htmlspecialchars(implode('|', $project['tags_key'])) ?>"
                             data-search="<?= htmlspecialchars(mb_strtolower(
                                 $project['title'] . ' ' . ($project['excerpt'] ?? '') . ' '
                                 . implode(' ', $project['tags']) . ' ' . implode(' ', $project['cats'])
                             )) ?>">
                            <?php partial('_project_card', ['project' => $project]); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="no-results" id="no-results" hidden>
                    <div class="empty-state-icon"><i class="fas fa-magnifying-glass"></i></div>
                    <h2 class="empty-state-title">Aucun projet ne correspond</h2>
                    <p class="empty-state-description">Essayez d'élargir votre recherche ou de retirer un filtre.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        (function () {
            const search  = document.getElementById('project-search');
            if (!search) return; // aucun projet : pas de barre de filtres

            const items   = Array.from(document.querySelectorAll('.project-item'));
            const chips   = Array.from(document.querySelectorAll('.filter-chip'));
            const countEl = document.getElementById('filter-count-text');
            const resetEl = document.getElementById('filter-reset');
            const noneEl  = document.getElementById('no-results');

            // Retire les accents : « Réseau » doit se trouver en tapant « reseau ».
            // NFD sépare la lettre de son diacritique, puis \p{Diacritic} supprime
            // ce dernier.
            const fold = (s) => s.normalize('NFD').replace(/\p{Diacritic}/gu, '').toLowerCase();

            const active = (kind) => chips
                .filter(c => c.dataset.kind === kind && c.getAttribute('aria-pressed') === 'true')
                .map(c => c.dataset.value);

            const listOf = (item, kind) =>
                (kind === 'cat' ? item.dataset.cats : item.dataset.tags || '')
                    .split('|').filter(Boolean);

            /**
             * Combien de projets resteraient si on cliquait cette puce ?
             *
             * On applique la recherche et les filtres de l'AUTRE rangée, puis
             * cette valeur — mais pas les puces déjà actives de la même rangée,
             * puisqu'elles s'y cumulent en OU. C'est le décompte à facettes
             * habituel : il répond à « et si je cliquais là ? ».
             */
            function facetCount(kind, value) {
                const q     = fold(search.value.trim());
                const other = kind === 'cat' ? active('tag') : active('cat');
                const otherKind = kind === 'cat' ? 'tag' : 'cat';

                return items.filter(item => {
                    if (q !== '' && !fold(item.dataset.search || '').includes(q)) return false;
                    if (!listOf(item, kind).includes(value)) return false;
                    if (other.length > 0 && !other.some(v => listOf(item, otherKind).includes(v))) return false;
                    return true;
                }).length;
            }

            // Passe à true dès que l'utilisateur touche à la recherche ou aux puces.
            let interacted = false;

            function apply() {
                const q    = fold(search.value.trim());
                const cats = active('cat');
                const tags = active('tag');

                let shown = 0;
                items.forEach(item => {
                    const itemCats = (item.dataset.cats || '').split('|').filter(Boolean);
                    const itemTags = (item.dataset.tags || '').split('|').filter(Boolean);

                    // ET entre les trois critères, OU à l'intérieur de chaque rangée.
                    const okSearch = q === '' || fold(item.dataset.search || '').includes(q);
                    const okCats   = cats.length === 0 || cats.some(c => itemCats.includes(c));
                    const okTags   = tags.length === 0 || tags.some(t => itemTags.includes(t));
                    const visible  = okSearch && okCats && okTags;

                    item.hidden = !visible;
                    if (visible) shown++;

                    // L'animation au scroll met les cartes à opacity:0 en attendant
                    // l'IntersectionObserver. Une carte que l'utilisateur fait
                    // réapparaître par un filtre a pu manquer son passage devant
                    // l'observateur : on la dévoile donc nous-mêmes. Uniquement
                    // après une interaction, pour laisser l'animation d'entrée
                    // jouer normalement au premier chargement.
                    if (visible && interacted) {
                        const card = item.querySelector('.project-card');
                        if (card) {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }
                    }
                });

                // Compteurs par puce : chacune annonce ce qu'un clic donnerait.
                // Celles qui ne ramèneraient rien s'effacent, sans être désactivées.
                chips.forEach(chip => {
                    const n = facetCount(chip.dataset.kind, chip.dataset.value);
                    chip.querySelector('.chip-count').textContent = n;
                    chip.classList.toggle('is-empty', n === 0 && chip.getAttribute('aria-pressed') === 'false');
                });

                const filtering = q !== '' || cats.length > 0 || tags.length > 0;
                countEl.innerHTML = filtering
                    ? `<strong>${shown}</strong> sur ${items.length} projet${items.length > 1 ? 's' : ''}`
                    : `<strong>${items.length}</strong> projet${items.length > 1 ? 's' : ''}`;
                resetEl.hidden = !filtering;
                noneEl.hidden  = shown !== 0;
            }

            search.addEventListener('input', () => { interacted = true; apply(); });

            chips.forEach(chip => chip.addEventListener('click', () => {
                const on = chip.getAttribute('aria-pressed') === 'true';
                chip.setAttribute('aria-pressed', on ? 'false' : 'true');
                interacted = true;
                apply();
            }));

            resetEl.addEventListener('click', () => {
                search.value = '';
                chips.forEach(c => c.setAttribute('aria-pressed', 'false'));
                interacted = true;
                apply();
            });

            apply();
        })();
    </script>

    <script>
        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.project-card').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = `opacity 0.6s ease ${Math.min(index, 8) * 0.1}s, transform 0.6s ease ${Math.min(index, 8) * 0.1}s`;
            observer.observe(el);
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>