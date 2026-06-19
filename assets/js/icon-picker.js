/**
 * Icon picker pour l'admin.
 * Utilisation : <input type="text" name="icon" data-icon-picker>
 *
 * Affiche à côté de l'input :
 *  - Une preview live de l'icône
 *  - Un bouton "Parcourir" qui ouvre une grille recherchable
 *
 * Sources d'icônes : Font Awesome 6 (fab/fas) + Bootstrap Icons (bi).
 */

(function () {
    const ICONS = [
        // === Font Awesome brands (langages / techs) ===
        'fab fa-python', 'fab fa-js', 'fab fa-php', 'fab fa-java', 'fab fa-html5', 'fab fa-css3-alt',
        'fab fa-react', 'fab fa-vuejs', 'fab fa-angular', 'fab fa-node-js', 'fab fa-npm', 'fab fa-yarn',
        'fab fa-git-alt', 'fab fa-github', 'fab fa-gitlab', 'fab fa-bitbucket',
        'fab fa-docker', 'fab fa-linux', 'fab fa-ubuntu', 'fab fa-redhat', 'fab fa-windows', 'fab fa-apple', 'fab fa-android',
        'fab fa-aws', 'fab fa-google', 'fab fa-microsoft', 'fab fa-digital-ocean',
        'fab fa-bootstrap', 'fab fa-sass', 'fab fa-less', 'fab fa-stripe', 'fab fa-paypal',
        'fab fa-wordpress', 'fab fa-drupal', 'fab fa-joomla', 'fab fa-laravel', 'fab fa-symfony',
        'fab fa-figma', 'fab fa-sketch', 'fab fa-trello', 'fab fa-slack', 'fab fa-discord',
        'fab fa-twitter', 'fab fa-linkedin-in', 'fab fa-youtube', 'fab fa-twitch', 'fab fa-instagram', 'fab fa-facebook',
        'fab fa-raspberry-pi', 'fab fa-unity', 'fab fa-steam', 'fab fa-playstation', 'fab fa-xbox',

        // === Font Awesome solid (concepts / actions) ===
        'fas fa-code', 'fas fa-terminal', 'fas fa-laptop-code', 'fas fa-file-code', 'fas fa-bug',
        'fas fa-database', 'fas fa-server', 'fas fa-cloud', 'fas fa-globe', 'fas fa-network-wired',
        'fas fa-mobile-alt', 'fas fa-tablet-alt', 'fas fa-desktop', 'fas fa-microchip', 'fas fa-memory',
        'fas fa-cogs', 'fas fa-cog', 'fas fa-tools', 'fas fa-wrench', 'fas fa-screwdriver', 'fas fa-hammer',
        'fas fa-palette', 'fas fa-paint-brush', 'fas fa-pen-fancy', 'fas fa-magic',
        'fas fa-paper-plane', 'fas fa-envelope', 'fas fa-phone', 'fas fa-map-marker-alt',
        'fas fa-shield-alt', 'fas fa-lock', 'fas fa-unlock', 'fas fa-key', 'fas fa-fingerprint',
        'fas fa-chart-line', 'fas fa-chart-bar', 'fas fa-chart-pie', 'fas fa-tachometer-alt',
        'fas fa-rocket', 'fas fa-bolt', 'fas fa-fire', 'fas fa-star', 'fas fa-trophy', 'fas fa-medal',
        'fas fa-heart', 'fas fa-gamepad', 'fas fa-music', 'fas fa-headphones', 'fas fa-film', 'fas fa-book',
        'fas fa-dice-d20', 'fas fa-chess', 'fas fa-puzzle-piece',
        'fas fa-graduation-cap', 'fas fa-user-graduate', 'fas fa-school',
        'fas fa-user', 'fas fa-users', 'fas fa-user-tie', 'fas fa-user-shield', 'fas fa-user-cog',
        'fas fa-folder', 'fas fa-folder-open', 'fas fa-file', 'fas fa-file-pdf', 'fas fa-file-alt',
        'fas fa-cube', 'fas fa-cubes', 'fas fa-layer-group', 'fas fa-project-diagram', 'fas fa-sitemap',
        'fas fa-leaf', 'fas fa-mountain', 'fas fa-info-circle', 'fas fa-question-circle', 'fas fa-exclamation-triangle',
        'fas fa-check-circle', 'fas fa-times-circle', 'fas fa-thumbs-up', 'fas fa-thumbs-down',
        'fas fa-search', 'fas fa-eye', 'fas fa-eye-slash', 'fas fa-edit', 'fas fa-trash', 'fas fa-plus', 'fas fa-minus',
        'fas fa-tag', 'fas fa-tags', 'fas fa-bookmark', 'fas fa-clock', 'fas fa-calendar-alt',
        'fas fa-shopping-cart', 'fas fa-credit-card', 'fas fa-euro-sign', 'fas fa-dollar-sign',
        'fas fa-link', 'fas fa-external-link-alt', 'fas fa-download', 'fas fa-upload',
        'fas fa-lightbulb', 'fas fa-brain', 'fas fa-coffee',

        // === Bootstrap Icons (utilisé sur le site) ===
        'bi bi-info-circle-fill', 'bi bi-journal-text', 'bi bi-palette-fill', 'bi bi-gear-fill',
        'bi bi-phone', 'bi bi-pencil-square', 'bi bi-tags-fill', 'bi bi-stars', 'bi bi-heart-fill',
        'bi bi-arrow-left', 'bi bi-plus-circle', 'bi bi-folder-plus', 'bi bi-folder', 'bi bi-folder-fill',
        'bi bi-trash', 'bi bi-pencil', 'bi bi-eye-fill', 'bi bi-eye-slash-fill',
        'bi bi-check-circle', 'bi bi-x-circle', 'bi bi-exclamation-triangle-fill',
        'bi bi-envelope-fill', 'bi bi-telephone-fill', 'bi bi-geo-alt-fill',
        'bi bi-laptop', 'bi bi-server', 'bi bi-database-fill', 'bi bi-cloud-fill', 'bi bi-globe',
        'bi bi-code-slash', 'bi bi-terminal-fill', 'bi bi-braces',
        'bi bi-house-fill', 'bi bi-person-fill', 'bi bi-people-fill', 'bi bi-shield-fill-check',
        'bi bi-bookmark-fill', 'bi bi-bell-fill', 'bi bi-calendar-fill',
    ];

    function styleEl(el, css) {
        Object.assign(el.style, css);
    }

    function buildPicker(input) {
        // Wrapper qui remplace l'input par : preview + input + bouton
        const wrap = document.createElement('div');
        wrap.className = 'input-group';
        input.parentNode.insertBefore(wrap, input);

        const previewSpan = document.createElement('span');
        previewSpan.className = 'input-group-text';
        previewSpan.style.minWidth = '46px';
        previewSpan.style.justifyContent = 'center';
        wrap.appendChild(previewSpan);

        wrap.appendChild(input);

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-outline-secondary';
        btn.innerHTML = '<i class="bi bi-grid-3x3-gap-fill"></i> Parcourir';
        wrap.appendChild(btn);

        const updatePreview = () => {
            const val = input.value.trim();
            previewSpan.innerHTML = val
                ? `<i class="${val}" style="font-size:1.25rem;"></i>`
                : '<span class="text-muted small">?</span>';
        };
        input.addEventListener('input', updatePreview);
        updatePreview();

        btn.addEventListener('click', () => openModal(input));
    }

    // === Modale custom vanilla JS (pas de dépendance Bootstrap) ===
    let modalEl = null;
    let onKeydown = null;

    function buildModal() {
        const backdrop = document.createElement('div');
        styleEl(backdrop, {
            position: 'fixed', inset: '0', background: 'rgba(0,0,0,0.7)',
            zIndex: '99999', display: 'flex', alignItems: 'center', justifyContent: 'center',
            padding: '20px',
        });

        const dialog = document.createElement('div');
        styleEl(dialog, {
            background: '#1a1a2e', color: '#fff',
            border: '1px solid rgba(0,212,255,0.4)', borderRadius: '12px',
            width: '100%', maxWidth: '900px', maxHeight: '90vh',
            display: 'flex', flexDirection: 'column', overflow: 'hidden',
            boxShadow: '0 20px 60px rgba(0,0,0,0.5)',
        });

        dialog.innerHTML = `
            <div style="display:flex; align-items:center; justify-content:space-between;
                        padding:1rem 1.25rem; border-bottom:1px solid rgba(255,255,255,0.1);">
                <h5 style="margin:0; color:#00d4ff;">Choisir une icône</h5>
                <button type="button" data-close
                        style="background:none; border:none; color:#fff; font-size:1.5rem; cursor:pointer; line-height:1;">
                    &times;
                </button>
            </div>
            <div style="padding:1rem 1.25rem; overflow-y:auto;">
                <input type="text" id="iconPickerSearch"
                       style="width:100%; padding:0.5rem 0.75rem; margin-bottom:1rem;
                              background:#0f0f1f; color:#fff;
                              border:1px solid rgba(255,255,255,0.2); border-radius:6px;"
                       placeholder="Rechercher (ex: python, database, heart...)">
                <div id="iconPickerGrid" style="display:flex; flex-wrap:wrap; gap:8px;"></div>
                <small style="display:block; margin-top:1rem; color:#a0a0a0;">
                    Pas trouvé ? Tape directement la classe dans le champ
                    (<code>fab fa-X</code>, <code>fas fa-X</code>, <code>bi bi-X</code>).
                </small>
            </div>
        `;

        backdrop.appendChild(dialog);
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) closeModal();
        });
        dialog.querySelector('[data-close]').addEventListener('click', closeModal);

        document.body.appendChild(backdrop);
        return backdrop;
    }

    function closeModal() {
        if (modalEl) {
            modalEl.style.display = 'none';
        }
        if (onKeydown) {
            document.removeEventListener('keydown', onKeydown);
            onKeydown = null;
        }
    }

    function openModal(input) {
        if (!modalEl) {
            modalEl = buildModal();
        } else {
            modalEl.style.display = 'flex';
        }

        const grid = modalEl.querySelector('#iconPickerGrid');
        const search = modalEl.querySelector('#iconPickerSearch');

        const render = (filter = '') => {
            const f = filter.toLowerCase();
            grid.innerHTML = '';
            const matches = ICONS.filter(c => !f || c.toLowerCase().includes(f));
            matches.forEach(cls => {
                const tile = document.createElement('button');
                tile.type = 'button';
                tile.title = cls;
                styleEl(tile, {
                    width: '60px', height: '60px', fontSize: '1.4rem', padding: '0',
                    background: '#0f0f1f', color: '#fff',
                    border: '1px solid rgba(255,255,255,0.15)', borderRadius: '8px',
                    transition: 'all .15s', cursor: 'pointer',
                    display: 'flex', alignItems: 'center', justifyContent: 'center',
                });
                tile.onmouseenter = () => {
                    tile.style.background = 'rgba(0,212,255,0.15)';
                    tile.style.borderColor = '#00d4ff';
                };
                tile.onmouseleave = () => {
                    tile.style.background = '#0f0f1f';
                    tile.style.borderColor = 'rgba(255,255,255,0.15)';
                };
                tile.innerHTML = `<i class="${cls}"></i>`;
                tile.addEventListener('click', () => {
                    input.value = cls;
                    input.dispatchEvent(new Event('input'));
                    closeModal();
                });
                grid.appendChild(tile);
            });
            if (matches.length === 0) {
                grid.innerHTML = '<p style="color:#a0a0a0;">Aucune icône ne correspond. Tape manuellement la classe dans le champ.</p>';
            }
        };

        search.value = '';
        render();
        search.oninput = () => render(search.value);

        // Fermer avec Escape
        onKeydown = (e) => { if (e.key === 'Escape') closeModal(); };
        document.addEventListener('keydown', onKeydown);

        setTimeout(() => search.focus(), 50);
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('input[data-icon-picker]').forEach(buildPicker);
    });
})();
