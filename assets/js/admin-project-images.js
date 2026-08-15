/**
 * Gestion des images d'un projet (formulaires d'ajout et d'édition).
 *
 * Deux listes cohabitent, parce que le serveur les traite différemment :
 *
 *   - les images DÉJÀ EN BASE ne voyagent que par `image_order` : la liste
 *     ordonnée des identifiants à CONSERVER. Retirer une image revient à la
 *     sortir de cette liste — pas de second champ « à supprimer » qui pourrait
 *     se désynchroniser de l'ordre.
 *
 *   - les fichiers EN ATTENTE partent par `images[]`. On tient nous-mêmes leur
 *     FileList, via DataTransfer : sans cela, un second passage par le sélecteur
 *     écrase la sélection précédente, et rien ne permet de retirer un fichier
 *     ouvert par erreur. C'était le principal reproche à l'ancienne version,
 *     qui posait le champ natif tel quel.
 *
 * Le glisser-déposer ne franchit pas la frontière entre les deux : syncProjectImages()
 * ajoute toujours les nouveaux fichiers APRÈS les images conservées, autant ne
 * pas laisser croire l'inverse.
 */
(function () {
    const root = document.getElementById('img-manager');
    if (!root) return;

    const order      = document.getElementById('image-order');
    const saved      = document.getElementById('image-list');
    const hint       = document.getElementById('image-hint');
    const empty      = document.getElementById('image-empty');
    const drop       = document.getElementById('img-drop');
    const input      = document.getElementById('images');
    const pending    = document.getElementById('pending-list');
    const pendingBox = document.getElementById('pending-box');
    const warning    = document.getElementById('pending-warning');

    const MAX_BYTES = 5 * 1024 * 1024;   // même plafond que uploadImage()
    const tilesOf = (grid) => Array.from(grid.querySelectorAll('.img-tile'));

    // Identifie un fichier sans dépendre de sa position, pour qu'il survive aux
    // réordonnancements et qu'un même fichier choisi deux fois n'entre qu'une.
    const queue = new Map();
    const keyOf = (f) => [f.name, f.size, f.lastModified].join('|');

    // --- État partagé --------------------------------------------------------

    function sync() {
        const savedTiles   = tilesOf(saved);
        const pendingTiles = tilesOf(pending);
        const all = savedTiles.concat(pendingTiles);

        // Le rang court d'une liste à l'autre : le serveur numérote les nouveaux
        // fichiers à la suite des images conservées, l'écran doit dire pareil.
        // La couverture est donc la première vignette de l'ensemble — sur la
        // page d'ajout, c'est un fichier en attente.
        all.forEach((el, i) => {
            el.classList.toggle('is-cover', i === 0);
            const rank = el.querySelector('.img-tile-rank');
            if (rank) rank.textContent = (i === 0) ? 'Couverture' : (i + 1);
        });

        // Les flèches, elles, restent dans leur liste.
        [savedTiles, pendingTiles].forEach(group => {
            group.forEach((el, i) => {
                const left  = el.querySelector('.js-img-left');
                const right = el.querySelector('.js-img-right');
                if (left)  left.disabled  = (i === 0);
                if (right) right.disabled = (i === group.length - 1);
            });
        });

        saved.hidden = hint.hidden = savedTiles.length === 0;
        empty.hidden = all.length > 0;
        order.value  = savedTiles.map(el => el.dataset.id).join(',');

        syncQueue(pendingTiles);
    }

    /** Réécrit input.files dans l'ordre des vignettes en attente. */
    function syncQueue(tiles) {
        pendingBox.hidden = tiles.length === 0;

        const dt = new DataTransfer();
        let heavy = 0;
        tiles.forEach(el => {
            const file = queue.get(el.dataset.key);
            if (!file) return;
            dt.items.add(file);
            if (file.size > MAX_BYTES) heavy++;
        });
        input.files = dt.files;

        // uploadImage() lève une exception au-delà de 5 Mo, et cette exception
        // interrompt tout l'enregistrement : mieux vaut le dire avant le clic
        // qu'après, sur un message d'erreur générique.
        warning.hidden = heavy === 0;
        warning.textContent = (heavy === 1)
            ? 'Une image dépasse 5 Mo : retirez-la, sinon l’enregistrement échouera.'
            : heavy + ' images dépassent 5 Mo : retirez-les, sinon l’enregistrement échouera.';
    }

    // --- Fichiers en attente -------------------------------------------------

    function addFiles(files) {
        Array.from(files).forEach(file => {
            // Le sélecteur filtre déjà sur accept, un dépôt non.
            if (!file.type.startsWith('image/')) return;
            const key = keyOf(file);
            if (queue.has(key)) return;
            queue.set(key, file);
            pending.appendChild(pendingTile(key, file));
        });
        sync();
    }

    function pendingTile(key, file) {
        const el = document.createElement('figure');
        el.className = 'img-tile';
        el.dataset.key = key;
        el.draggable = true;

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.alt = '';
        el.appendChild(img);

        const rank = document.createElement('figcaption');
        rank.className = 'img-tile-rank';
        el.appendChild(rank);

        if (file.size > MAX_BYTES) {
            el.classList.add('is-toobig');
            const warn = document.createElement('span');
            warn.className = 'img-tile-warn';
            warn.textContent = (file.size / 1048576).toFixed(1).replace('.', ',') + ' Mo';
            el.appendChild(warn);
        }

        const tools = document.createElement('div');
        tools.className = 'img-tile-tools';
        tools.innerHTML =
            '<button type="button" class="img-tool js-img-left" aria-label="Déplacer vers la gauche">' +
            '<i class="bi bi-arrow-left"></i></button>' +
            '<button type="button" class="img-tool js-img-right" aria-label="Déplacer vers la droite">' +
            '<i class="bi bi-arrow-right"></i></button>' +
            '<button type="button" class="img-tool is-danger js-img-del" aria-label="Retirer le fichier">' +
            '<i class="bi bi-x-lg"></i></button>';
        el.appendChild(tools);

        return el;
    }

    input.addEventListener('change', () => {
        // Le navigateur vient de remplacer input.files par la nouvelle sélection.
        // On la verse dans la file, puis syncQueue() réécrit input.files avec
        // l'ensemble : choisir en deux fois n'efface plus le premier lot.
        addFiles(input.files);
    });

    // --- Commandes des vignettes --------------------------------------------

    root.addEventListener('click', (e) => {
        const btn = e.target.closest('.img-tool');
        if (!btn) return;
        const el   = btn.closest('.img-tile');
        const grid = el && el.parentElement;
        if (!grid) return;

        if (btn.classList.contains('js-img-left') && el.previousElementSibling) {
            grid.insertBefore(el, el.previousElementSibling);
        } else if (btn.classList.contains('js-img-right') && el.nextElementSibling) {
            grid.insertBefore(el.nextElementSibling, el);
        } else if (btn.classList.contains('js-img-del')) {
            // Une image enregistrée n'est réellement effacée qu'à la sauvegarde.
            // Un fichier en attente, lui, n'a jamais quitté le navigateur : on
            // libère son aperçu, sinon les URL d'objet s'accumulent en mémoire.
            if (el.dataset.key) {
                queue.delete(el.dataset.key);
                URL.revokeObjectURL(el.querySelector('img').src);
            }
            el.remove();
        } else {
            return;
        }

        sync();
    });

    // --- Glisser-déposer -----------------------------------------------------
    // Les flèches restent indispensables à côté : le glisser-déposer HTML5 ne
    // répond ni au doigt sur mobile, ni au clavier.
    let dragged = null;

    root.addEventListener('dragstart', (e) => {
        const el = e.target.closest('.img-tile');
        if (!el) return;
        dragged = el;
        el.classList.add('is-dragging');
        e.dataTransfer.effectAllowed = 'move';
        // Firefox n'amorce pas un glisser sans charge utile.
        e.dataTransfer.setData('text/plain', '');
    });

    root.addEventListener('dragend', () => {
        if (dragged) dragged.classList.remove('is-dragging');
        dragged = null;
        sync();
    });

    root.addEventListener('dragover', (e) => {
        if (!dragged) return;                                  // dépôt de fichiers : pas notre affaire
        const over = e.target.closest('.img-tile');
        if (!over || over === dragged) return;
        if (over.parentElement !== dragged.parentElement) return;
        e.preventDefault();

        // Insère avant ou après selon que le curseur a dépassé le milieu de la
        // vignette survolée — les vignettes étant en ligne, on compare en X.
        const rect  = over.getBoundingClientRect();
        const after = (e.clientX - rect.left) > rect.width / 2;
        over.parentElement.insertBefore(dragged, after ? over.nextElementSibling : over);
    });

    root.addEventListener('drop', (e) => {
        if (dragged) e.preventDefault();
    });

    // --- Zone de dépôt -------------------------------------------------------
    // Le dépôt lui-même est natif : l'input recouvre la zone, le navigateur y
    // range les fichiers et déclenche « change ». Il ne reste que le surlignage
    // — avec un compteur, parce que « dragleave » part aussi quand le curseur
    // passe d'un enfant de la zone à un autre.
    let depth = 0;

    drop.addEventListener('dragenter', () => {
        if (dragged) return;                                   // réordonnancement en cours
        depth++;
        drop.classList.add('is-over');
    });

    drop.addEventListener('dragleave', () => {
        if (dragged) return;
        if (--depth <= 0) {
            depth = 0;
            drop.classList.remove('is-over');
        }
    });

    drop.addEventListener('drop', () => {
        depth = 0;
        drop.classList.remove('is-over');
    });

    sync();
})();
