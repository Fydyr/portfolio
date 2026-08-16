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
        /* Ni `overflow: hidden`, qui rognerait le menu des technos, ni stacking
           par défaut : sans z-index, ce menu passerait sous la grille de cartes
           qui le suit dans le document. */
        .filter-panel {
            position: relative;
            z-index: 20;
            max-width: 960px;
            margin: 0 auto 3rem;
            background: rgba(30, 41, 59, 0.35);
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: var(--border-radius, 16px);
            backdrop-filter: blur(12px);
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

        /* === Sélecteur de facette ===
           Les deux rangées portent désormais le même composant : un bouton qui
           ouvre une liste à cocher. Une rangée de puces ne tenait ni les 44
           technos ni les 11 catégories sans être coupée quelque part, et une
           coupure arbitraire n'apprend rien sur le portfolio.

           Ce qui distingue les deux facettes n'est plus la mécanique mais la
           couleur, déjà portée par les badges des cartes : violet pour les
           catégories, qui structurent, cyan pour les technos, qui détaillent. */
        .facet-picker {
            /* `backdrop-filter` sur .filter-panel en ferait le bloc conteneur
               des descendants absolus : c'est ce picker qui doit servir de
               repère au menu. */
            position: relative;
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.45rem;
        }

        .facet-trigger {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.28);
            background: rgba(10, 10, 15, 0.35);
            color: var(--text-secondary);
            cursor: pointer;
            white-space: nowrap;
            transition: var(--transition);
        }

        .facet-trigger:hover,
        .facet-trigger[aria-expanded="true"] { color: var(--text-primary); }

        .facet-picker[data-kind="cat"] .facet-trigger:hover,
        .facet-picker[data-kind="cat"] .facet-trigger[aria-expanded="true"] {
            border-color: rgba(114, 9, 183, 0.75);
        }

        .facet-picker[data-kind="tag"] .facet-trigger:hover,
        .facet-picker[data-kind="tag"] .facet-trigger[aria-expanded="true"] {
            border-color: var(--primary-color);
        }

        .facet-trigger:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Le total reprend le filet des puces : le bouton répond à « combien
           y en a-t-il ? » sans qu'on ait à l'ouvrir. */
        .facet-trigger .chip-count {
            font-size: 0.68rem;
            font-variant-numeric: tabular-nums;
            opacity: 0.75;
            padding-left: 0.45rem;
            border-left: 1px solid rgba(255, 255, 255, 0.18);
        }

        .facet-caret {
            font-size: 0.6rem;
            transition: transform 0.2s ease;
        }

        .facet-trigger[aria-expanded="true"] .facet-caret { transform: rotate(180deg); }

        /* Les valeurs retenues se rangent dans la ligne du bouton, pas dans un
           conteneur à elles : `display: contents` les remonte au picker. */
        .facet-selected { display: contents; }

        /* Le menu recouvre la grille au lieu de la pousser : les cartes filtrées
           restent en place pendant qu'on coche. */
        .facet-panel {
            position: absolute;
            top: calc(100% + 0.5rem);
            left: 0;
            z-index: 30;
            width: min(320px, calc(100vw - 3rem));
            background: #131c2e;
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: var(--border-radius, 16px);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.55);
            overflow: hidden;
        }

        .facet-panel-search {
            position: relative;
            padding: 0.6rem 0.6rem 0.5rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.12);
        }

        /* Centrée sur la hauteur du bloc plutôt qu'à une distance fixe du haut :
           la loupe suit la taille du champ au lieu de dériver. */
        .facet-panel-search > i {
            position: absolute;
            left: 1.35rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            color: var(--text-muted);
            pointer-events: none;
        }

        .facet-search {
            width: 100%;
            padding: 0.4rem 0.7rem 0.4rem 2rem;
            border-radius: 999px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            background: rgba(10, 10, 15, 0.45);
            color: var(--text-primary);
            font-size: 0.85rem;
        }

        .facet-search::placeholder { color: var(--text-muted); }
        .facet-search:focus { outline: none; border-color: var(--primary-color); }

        .facet-panel-list {
            max-height: 15rem;
            overflow-y: auto;
            padding: 0.3rem;
        }

        .facet-option {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            width: 100%;
            margin: 0;
            padding: 0.35rem 0.5rem;
            border-radius: var(--border-radius-sm, 8px);
            font-size: 0.8rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition-fast, all 0.15s ease);
        }

        /* Technos en monospace *système* : aucune requête réseau de plus. */
        .facet-panel[data-kind="tag"] .facet-option {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 0.78rem;
        }

        .facet-option:hover { background: rgba(148, 163, 184, 0.1); }

        .facet-panel[data-kind="cat"] .facet-option:has(:checked) {
            background: rgba(114, 9, 183, 0.2);
            color: #c9a6ff;
        }

        .facet-panel[data-kind="tag"] .facet-option:has(:checked) {
            background: rgba(0, 212, 255, 0.12);
            color: var(--primary-color);
        }

        .facet-option:focus-within {
            outline: 2px solid var(--primary-color);
            outline-offset: -2px;
        }

        .facet-option input { accent-color: var(--primary-color); margin: 0; flex: none; }
        .facet-option-name { flex: 1; }

        /* Le compteur annonce ce qu'un clic donnerait. Sa largeur est réservée
           pour le plus grand décompte possible (le script pose --chip-count-w) :
           sans cela, chaque frappe dans la recherche ferait respirer toute la
           liste au rythme des chiffres. */
        .facet-option .chip-count {
            font-size: 0.7rem;
            font-variant-numeric: tabular-nums;
            opacity: 0.7;
            padding-left: 0.4rem;
            min-width: calc(0.4rem + var(--chip-count-w, 2ch));
            text-align: right;
            border-left: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Une valeur qui ne ramènerait rien s'efface, mais reste cochable : la
           désactiver piégerait l'utilisateur dans son filtre. */
        .facet-option.is-empty { opacity: 0.35; }
        .facet-option.is-hidden { display: none; }

        .facet-panel-none,
        .facet-panel-foot {
            padding: 0.6rem 0.85rem;
            margin: 0;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .facet-panel-foot {
            border-top: 1px solid rgba(148, 163, 184, 0.12);
            text-align: right;
        }

        /* Rien à décocher : le pied n'a plus de raison d'occuper de la place. */
        .facet-panel-foot:has(.js-facet-clear[hidden]) { display: none; }

        /* --- Puces des valeurs retenues ---
           Elles vivent hors du menu : un filtre en vigueur ne doit pas dépendre
           de l'ouverture d'un panneau pour se voir. */

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border-radius: 999px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: var(--transition);
        }

        /* Catégories pleines et affirmées, technos plus discrètes : les puces
           reprennent les badges `is-cat` / `is-tag` portés par les cartes. */
        .filter-chip.for-cat {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 0.8rem;
            background: var(--gradient-primary);
            color: #fff;
        }

        .filter-chip.for-tag {
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 0.72rem;
            padding: 0.25rem 0.7rem;
            background: rgba(0, 212, 255, 0.14);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* La croix dit qu'un clic retire la valeur. */
        .filter-chip > i { font-size: 0.62rem; opacity: 0.7; }
        .filter-chip:hover > i { opacity: 1; }

        .filter-chip:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        @media (prefers-reduced-motion: reduce) {
            .filter-chip,
            .facet-trigger,
            .facet-option,
            .facet-caret { transition: none; }
        }

        @media (max-width: 575px) {
            .filter-row { flex-direction: column; align-items: flex-start; gap: 0.45rem; }
            /* Empilé, l'alignement à droite n'a plus de colonne en face : il
               laisserait le libellé flotter loin de son contrôle. */
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
                        <?php
                        /* Les deux facettes portent le même composant : seules
                           changent leurs valeurs et leur couleur. Le tableau
                           évite d'en dupliquer le balisage — et garantit qu'une
                           correction sur l'une profite à l'autre. */
                        $facets = [
                            [
                                'kind'   => 'cat',
                                'label'  => 'Catégories',
                                'browse' => 'Parcourir les catégories',
                                'find'   => 'Filtrer la liste des catégories',
                                'none'   => 'Aucune catégorie ne correspond.',
                                'values' => $allCategories ?? [],
                            ],
                            [
                                'kind'   => 'tag',
                                'label'  => 'Technos',
                                'browse' => 'Parcourir les technos',
                                'find'   => 'Filtrer la liste des technos',
                                'none'   => 'Aucune techno ne correspond.',
                                'values' => $allTags ?? [],
                            ],
                        ];
                        ?>

                        <?php foreach ($facets as $f): ?>
                            <?php if (empty($f['values'])) continue; ?>
                            <?php $k = $f['kind']; ?>
                            <div class="filter-row">
                                <span class="filter-row-label" id="lbl-<?= $k ?>"><?= htmlspecialchars($f['label']) ?></span>

                                <div class="facet-picker" data-kind="<?= $k ?>">
                                    <button type="button" class="facet-trigger js-facet-trigger"
                                            aria-expanded="false" aria-controls="panel-<?= $k ?>">
                                        <span><?= htmlspecialchars($f['browse']) ?></span>
                                        <span class="chip-count"><?= count($f['values']) ?></span>
                                        <i class="fas fa-chevron-down facet-caret" aria-hidden="true"></i>
                                    </button>

                                    <!-- Les valeurs retenues restent affichées hors du menu :
                                         un filtre en vigueur ne doit pas dépendre de
                                         l'ouverture d'un panneau pour se voir. -->
                                    <div class="facet-selected js-facet-selected"></div>

                                    <div class="facet-panel" id="panel-<?= $k ?>" data-kind="<?= $k ?>" hidden>
                                        <div class="facet-panel-search">
                                            <i class="fas fa-magnifying-glass" aria-hidden="true"></i>
                                            <label for="find-<?= $k ?>" class="visually-hidden"><?= htmlspecialchars($f['find']) ?></label>
                                            <input type="search" id="find-<?= $k ?>" class="facet-search js-facet-find"
                                                   placeholder="Filtrer la liste…" autocomplete="off">
                                        </div>

                                        <div class="facet-panel-list" role="group" aria-labelledby="lbl-<?= $k ?>">
                                            <?php foreach ($f['values'] as $v): ?>
                                                <label class="facet-option">
                                                    <input type="checkbox" data-kind="<?= $k ?>"
                                                           data-value="<?= htmlspecialchars(mb_strtolower($v)) ?>">
                                                    <span class="facet-option-name"><?= htmlspecialchars($v) ?></span>
                                                    <span class="chip-count"></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>

                                        <p class="facet-panel-none js-facet-none" hidden><?= htmlspecialchars($f['none']) ?></p>

                                        <div class="facet-panel-foot">
                                            <button type="button" class="filter-reset js-facet-clear" hidden>
                                                Tout décocher
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
            const countEl = document.getElementById('filter-count-text');
            const resetEl = document.getElementById('filter-reset');
            const noneEl  = document.getElementById('no-results');

            /* Catégories et technos portent le même composant : un bouton qui
               ouvre une liste à cocher. Les cases sont la source de vérité de
               l'état des filtres — de vraies cases dans des <label>, que le
               clavier, le lecteur d'écran et le clic manipulent nativement,
               sans réimplémenter une liste ARIA. */
            const boxes = Array.from(document.querySelectorAll('.facet-option input'));

            // Aucun décompte ne peut dépasser le nombre de projets : on réserve
            // cette largeur une fois pour toutes (voir .chip-count).
            document.documentElement.style.setProperty(
                '--chip-count-w', String(items.length).length + 'ch'
            );

            // Retire les accents : « Réseau » doit se trouver en tapant « reseau ».
            // NFD sépare la lettre de son diacritique, puis \p{Diacritic} supprime
            // ce dernier.
            const fold = (s) => s.normalize('NFD').replace(/\p{Diacritic}/gu, '').toLowerCase();

            const rowOf   = (box) => box.closest('.facet-option');
            const labelOf = (box) => rowOf(box).querySelector('.facet-option-name').textContent;

            const active = (kind) => boxes
                .filter(b => b.dataset.kind === kind && b.checked)
                .map(b => b.dataset.value);

            const listOf = (item, kind) =>
                ((kind === 'cat' ? item.dataset.cats : item.dataset.tags) || '')
                    .split('|').filter(Boolean);

            /* === État dans l'URL ===
             *
             * Sans cela une sélection ne survit à rien : impossible d'envoyer un
             * résultat filtré à quelqu'un, de le mettre en favori, ou de défaire
             * un filtre — le bouton retour quittait la page.
             *
             * Deux poids, deux mesures sur l'historique : cocher une valeur ou
             * réinitialiser sont des gestes délibérés, qui méritent une entrée à
             * laquelle revenir (pushState). Taper dans la recherche est continu :
             * une entrée par frappe rendrait le bouton retour inutilisable, on se
             * contente donc de réécrire l'adresse en place (replaceState).
             *
             * Les valeurs ne peuvent pas contenir de virgule — extractTagList()
             * découpe justement là-dessus — donc la joindre est sans ambiguïté.
             */
            const KINDS = ['cat', 'tag'];

            function stateToUrl() {
                const p = new URLSearchParams();
                const q = search.value.trim();
                if (q !== '') p.set('q', q);
                KINDS.forEach(kind => {
                    const on = active(kind);
                    if (on.length > 0) p.set(kind, on.join(','));
                });
                const qs = p.toString();
                return location.pathname + (qs === '' ? '' : '?' + qs);
            }

            function urlToState() {
                const p = new URLSearchParams(location.search);
                search.value = p.get('q') || '';
                KINDS.forEach(kind => {
                    // Les data-value sont posées en minuscules par PHP : on
                    // compare sur le même pied, pour qu'une adresse tapée à la
                    // main avec des majuscules fonctionne aussi.
                    const want = new Set(
                        (p.get(kind) || '').split(',').map(v => v.trim().toLowerCase()).filter(Boolean)
                    );
                    boxes.filter(b => b.dataset.kind === kind)
                         .forEach(b => { b.checked = want.has(b.dataset.value); });
                });
            }

            function syncUrl(push) {
                const url = stateToUrl();
                if (url === location.pathname + location.search) return;  // rien de neuf
                history[push ? 'pushState' : 'replaceState']({}, '', url);
            }

            // Safari plafonne le nombre d'appels à l'historique : on ne réécrit
            // l'adresse qu'une fois la frappe retombée.
            let urlTimer = 0;
            const syncUrlSoon = () => {
                clearTimeout(urlTimer);
                urlTimer = setTimeout(() => syncUrl(false), 250);
            };

            /**
             * Combien de projets resteraient si on cochait cette valeur ?
             *
             * On applique la recherche et les filtres de l'AUTRE facette, puis
             * cette valeur — mais pas les cases déjà cochées de la même facette,
             * puisqu'elles s'y cumulent en OU. C'est le décompte à facettes
             * habituel : il répond à « et si je cochais là ? ».
             */
            function facetCount(kind, value) {
                const q         = fold(search.value.trim());
                const otherKind = (kind === 'cat') ? 'tag' : 'cat';
                const other     = active(otherKind);

                return items.filter(item => {
                    if (q !== '' && !fold(item.dataset.search || '').includes(q)) return false;
                    if (!listOf(item, kind).includes(value)) return false;
                    if (other.length > 0 && !other.some(v => listOf(item, otherKind).includes(v))) return false;
                    return true;
                }).length;
            }

            // Passe à true dès que l'utilisateur touche à la recherche ou aux filtres.
            let interacted = false;

            function apply() {
                const q    = fold(search.value.trim());
                const cats = active('cat');
                const tags = active('tag');

                let shown = 0;
                items.forEach(item => {
                    const itemCats = (item.dataset.cats || '').split('|').filter(Boolean);
                    const itemTags = (item.dataset.tags || '').split('|').filter(Boolean);

                    // ET entre les trois critères, OU à l'intérieur de chaque facette.
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

                // Chaque ligne de menu annonce ce qu'un clic donnerait. Celles
                // qui ne ramèneraient rien s'effacent, sans être désactivées :
                // les désactiver piégerait l'utilisateur dans son filtre.
                boxes.forEach(box => {
                    const n = facetCount(box.dataset.kind, box.dataset.value);
                    const row = rowOf(box);
                    row.querySelector('.chip-count').textContent = n;
                    row.classList.toggle('is-empty', n === 0 && !box.checked);
                });

                pickers.forEach(p => p.render());

                const filtering = q !== '' || cats.length > 0 || tags.length > 0;
                countEl.innerHTML = filtering
                    ? `<strong>${shown}</strong> sur ${items.length} projet${items.length > 1 ? 's' : ''}`
                    : `<strong>${items.length}</strong> projet${items.length > 1 ? 's' : ''}`;
                resetEl.hidden = !filtering;
                noneEl.hidden  = shown !== 0;
            }

            /**
             * Câble un sélecteur de facette et renvoie de quoi le rafraîchir.
             *
             * Le menu ne détient aucun état : il ouvre, il ferme, il filtre sa
             * propre liste. Ce sont les cases qu'il contient qui portent la
             * sélection, et apply() les lit directement.
             */
            function initPicker(root) {
                const kind     = root.dataset.kind;
                const trigger  = root.querySelector('.js-facet-trigger');
                const panel    = root.querySelector('.facet-panel');
                const find     = root.querySelector('.js-facet-find');
                const none     = root.querySelector('.js-facet-none');
                const clear    = root.querySelector('.js-facet-clear');
                const selected = root.querySelector('.js-facet-selected');
                const mine     = boxes.filter(b => b.dataset.kind === kind);

                const open = (on) => {
                    panel.hidden = !on;
                    trigger.setAttribute('aria-expanded', on ? 'true' : 'false');
                    if (on) find.focus();
                };

                trigger.addEventListener('click', () => open(panel.hidden));

                mine.forEach(box => box.addEventListener('change', () => {
                    interacted = true;
                    apply();
                    syncUrl(true);
                }));

                // Filtrage de la liste elle-même. Il ne touche pas aux cases
                // cochées : une valeur retenue puis masquée par ce filtre reste
                // active, et sa puce reste visible à côté du bouton.
                find.addEventListener('input', () => {
                    const q = fold(find.value.trim());
                    let hits = 0;
                    mine.forEach(box => {
                        const hit = q === '' || fold(labelOf(box)).includes(q);
                        rowOf(box).classList.toggle('is-hidden', !hit);
                        if (hit) hits++;
                    });
                    none.hidden = hits > 0;
                });

                clear.addEventListener('click', () => {
                    mine.forEach(box => { box.checked = false; });
                    interacted = true;
                    apply();
                    syncUrl(true);
                });

                // Fermeture : clic au-dehors, ou Échap — qui rend la main au
                // bouton, sinon le focus resterait dans un panneau disparu.
                document.addEventListener('click', (e) => {
                    if (!panel.hidden && !root.contains(e.target)) open(false);
                });

                root.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !panel.hidden) {
                        open(false);
                        trigger.focus();
                    }
                });

                /** Les valeurs retenues, en puces retirables à côté du bouton. */
                function render() {
                    selected.textContent = '';

                    mine.filter(b => b.checked).forEach(box => {
                        const name = labelOf(box);
                        const chip = document.createElement('button');
                        chip.type = 'button';
                        chip.className = 'filter-chip for-' + kind;
                        chip.setAttribute('aria-label', 'Retirer le filtre ' + name);
                        chip.textContent = name;

                        const cross = document.createElement('i');
                        cross.className = 'fas fa-xmark';
                        cross.setAttribute('aria-hidden', 'true');
                        chip.appendChild(cross);

                        chip.addEventListener('click', () => {
                            box.checked = false;
                            interacted = true;
                            apply();
                            syncUrl(true);
                            // apply() vient de reconstruire ces puces : le focus
                            // était sur celle qu'on retire, il faut le reposer.
                            trigger.focus();
                        });

                        selected.appendChild(chip);
                    });

                    clear.hidden = !mine.some(b => b.checked);
                }

                return { render };
            }

            const pickers = Array.from(document.querySelectorAll('.facet-picker')).map(initPicker);

            search.addEventListener('input', () => {
                interacted = true;
                apply();
                syncUrlSoon();
            });

            resetEl.addEventListener('click', () => {
                search.value = '';
                boxes.forEach(box => { box.checked = false; });
                interacted = true;
                apply();
                syncUrl(true);
            });

            // Retour ou avance dans l'historique : l'adresse fait foi, on relit
            // tout depuis elle. Une réécriture en attente n'a plus lieu d'être,
            // elle porterait l'état d'avant la navigation.
            window.addEventListener('popstate', () => {
                clearTimeout(urlTimer);
                urlToState();
                interacted = true;
                apply();
            });

            // Premier rendu depuis l'adresse : une page ouverte sur un lien
            // filtré doit s'afficher filtrée. `interacted` reste faux pour que
            // l'animation d'entrée des cartes joue normalement.
            urlToState();
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