/**
 * Saisie d'un champ multivalué, en puces (views/partials/_tag_input.php).
 *
 * Le champ posté reste une chaîne séparée par des virgules : le serveur ne voit
 * aucune différence. Ce qui change est la saisie.
 *
 * Deux garde-fous contre les doublons, qui sont la raison d'être du composant :
 *
 *   - les suggestions sont comparées à la valeur EN COURS DE FRAPPE, ce qu'une
 *     <datalist> ne sait pas faire sur un champ à virgules — elle compare à la
 *     valeur entière, donc ne propose plus rien après la première virgule ;
 *   - une valeur qui ne diffère d'une valeur connue que par la casse ou les
 *     accents adopte l'orthographe déjà en base. « PYTHON » et « python »
 *     deviennent « Python ».
 *
 * Ce que ça n'attrape pas : « Base de donnée » contre « Base de données », qui
 * diffèrent d'une vraie lettre. C'est la liste de suggestions visible pendant la
 * frappe qui évite celui-là, en montrant la forme déjà employée.
 */
(function () {
    const roots = Array.from(document.querySelectorAll('.tag-input'));
    if (roots.length === 0) return;

    // Retire les accents et la casse, pour comparer « Réseau » et « reseau ».
    const fold = (s) => s.normalize('NFD').replace(/\p{Diacritic}/gu, '').trim().toLowerCase();

    roots.forEach(function (root) {
        const hidden   = root.querySelector('input[type="hidden"]');
        const chipsBox = root.querySelector('.js-tag-chips');
        const entry    = root.querySelector('.js-tag-entry');
        const list     = root.querySelector('.js-tag-list');
        const required = root.dataset.required === '1';

        let known = [];
        try { known = JSON.parse(root.dataset.known || '[]'); } catch (e) { known = []; }

        // extractTagList() côté PHP découpe sur , ; / | : on accepte les mêmes
        // séparateurs ici, sinon un collage depuis l'ancien champ se retrouverait
        // en une seule puce à rallonge.
        const SPLIT = /[,;/|]/;
        const split = (s) => s.split(SPLIT).map(v => v.trim()).filter(Boolean);

        let values = [];
        let highlight = -1;

        /** L'orthographe déjà employée pour cette valeur, si elle existe. */
        function canonical(raw) {
            const f = fold(raw);
            return known.find(k => fold(k) === f) || raw.trim();
        }

        function commit() {
            hidden.value = values.join(', ');
            // `required` sur un champ caché est ignoré par les navigateurs. On
            // le porte donc sur le champ visible, et seulement tant qu'aucune
            // valeur n'a été saisie : la validation native affiche alors son
            // message au bon endroit.
            if (required) entry.required = values.length === 0;
        }

        function renderChips() {
            chipsBox.textContent = '';
            values.forEach(function (v, i) {
                const chip = document.createElement('span');
                chip.className = 'tag-input-chip';
                chip.textContent = v;

                const del = document.createElement('button');
                del.type = 'button';
                del.className = 'tag-input-del';
                del.setAttribute('aria-label', 'Retirer ' + v);
                del.innerHTML = '<i class="bi bi-x" aria-hidden="true"></i>';

                // Sans cela le clic sortirait le focus du champ, le blur
                // validerait la frappe en cours, renderChips() reconstruirait
                // les puces — et ce bouton-ci disparaîtrait avant de recevoir
                // son clic. On retient donc le focus ; le clic suit son cours,
                // et le clavier passe toujours par l'écouteur ci-dessous.
                del.addEventListener('mousedown', (e) => e.preventDefault());

                del.addEventListener('click', function () {
                    values.splice(i, 1);
                    renderChips();
                    commit();
                    entry.focus();
                });

                chip.appendChild(del);
                chipsBox.appendChild(chip);
            });
        }

        function add(raw) {
            split(raw).forEach(function (part) {
                const v = canonical(part);
                // Comparaison souple : « web » n'entre pas si « Web » y est déjà.
                if (v !== '' && !values.some(x => fold(x) === fold(v))) values.push(v);
            });
            renderChips();
            commit();
        }

        // --- Suggestions ------------------------------------------------------

        function closeList() {
            list.hidden = true;
            list.textContent = '';
            highlight = -1;
            entry.setAttribute('aria-expanded', 'false');
        }

        function openList() {
            const q = fold(entry.value);
            const chosen = new Set(values.map(fold));

            // On propose ce qui contient la frappe et n'est pas déjà retenu.
            // Les valeurs commençant par la frappe passent devant : c'est ce
            // qu'on cherche en tapant les premières lettres.
            const hits = known
                .filter(k => !chosen.has(fold(k)) && (q === '' || fold(k).includes(q)))
                .sort((a, b) => (fold(b).startsWith(q) ? 1 : 0) - (fold(a).startsWith(q) ? 1 : 0))
                .slice(0, 8);

            list.textContent = '';
            highlight = -1;

            hits.forEach(function (k) {
                const li = document.createElement('li');
                li.className = 'tag-input-option';
                li.setAttribute('role', 'option');
                li.setAttribute('aria-selected', 'false');
                li.textContent = k;
                // mousedown plutôt que click : le clic viendrait après le blur
                // du champ, qui a déjà refermé la liste.
                li.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    add(k);
                    entry.value = '';
                    closeList();
                    entry.focus();
                });
                list.appendChild(li);
            });

            // Une valeur inédite est proposée explicitement : on doit voir qu'on
            // est en train d'en créer une, pas d'en réutiliser une.
            const typed = entry.value.trim();
            if (typed !== '' && !known.some(k => fold(k) === fold(typed))) {
                const li = document.createElement('li');
                li.className = 'tag-input-option is-new';
                li.setAttribute('role', 'option');
                li.setAttribute('aria-selected', 'false');
                li.textContent = 'Créer « ' + typed + ' »';
                li.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    add(typed);
                    entry.value = '';
                    closeList();
                    entry.focus();
                });
                list.appendChild(li);
            }

            const any = list.children.length > 0;
            list.hidden = !any;
            entry.setAttribute('aria-expanded', any ? 'true' : 'false');
        }

        function move(step) {
            const opts = Array.from(list.children);
            if (opts.length === 0) return;
            if (highlight >= 0) opts[highlight].setAttribute('aria-selected', 'false');
            highlight = (highlight + step + opts.length) % opts.length;
            opts[highlight].setAttribute('aria-selected', 'true');
            opts[highlight].scrollIntoView({ block: 'nearest' });
        }

        // --- Événements -------------------------------------------------------

        entry.addEventListener('input', function () {
            // Une virgule tapée (ou collée) vaut validation : c'est le geste
            // qu'avait l'ancien champ, autant le garder.
            if (SPLIT.test(entry.value)) {
                add(entry.value);
                entry.value = '';
                closeList();
                return;
            }
            openList();
        });

        entry.addEventListener('keydown', function (e) {
            const opts = Array.from(list.children);

            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                if (list.hidden) openList();
                move(e.key === 'ArrowDown' ? 1 : -1);
                return;
            }

            if (e.key === 'Enter') {
                // Toujours retenir la touche : sans cela, Entrée dans ce champ
                // enverrait le formulaire au lieu de valider la valeur tapée.
                if (!list.hidden && highlight >= 0) {
                    e.preventDefault();
                    opts[highlight].dispatchEvent(new MouseEvent('mousedown'));
                    return;
                }
                if (entry.value.trim() !== '') {
                    e.preventDefault();
                    add(entry.value);
                    entry.value = '';
                    closeList();
                }
                return;
            }

            if (e.key === 'Escape' && !list.hidden) {
                e.preventDefault();
                closeList();
                return;
            }

            // Retour arrière sur un champ vide : on reprend la dernière puce
            // pour la corriger, plutôt que de la supprimer sèchement.
            if (e.key === 'Backspace' && entry.value === '' && values.length > 0) {
                e.preventDefault();
                entry.value = values.pop();
                renderChips();
                commit();
                openList();
            }
        });

        entry.addEventListener('focus', openList);

        entry.addEventListener('blur', function () {
            // Ce qui reste tapé au moment de quitter le champ compte comme
            // saisi : personne ne s'attend à le voir disparaître.
            if (entry.value.trim() !== '') {
                add(entry.value);
                entry.value = '';
            }
            closeList();
        });

        // Cliquer dans le cadre revient à cliquer dans le champ.
        root.querySelector('.tag-input-box').addEventListener('click', function (e) {
            if (e.target.closest('.tag-input-chip')) return;
            entry.focus();
        });

        add(hidden.value);
        entry.value = '';
    });
})();
