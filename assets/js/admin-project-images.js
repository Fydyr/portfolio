/**
 * Gestion des images d'un projet (formulaire d'édition).
 *
 * Le formulaire ne poste qu'un champ pour tout l'existant : `image_order`, la
 * liste ordonnée des identifiants à CONSERVER. Retirer une image revient à la
 * sortir de cette liste — pas de second champ « à supprimer » qui pourrait se
 * désynchroniser de l'ordre.
 *
 * Les nouveaux fichiers arrivent séparément par `images[]`.
 */
(function () {
    const list  = document.getElementById('image-list');
    const order = document.getElementById('image-order');
    if (!list || !order) return;

    const empty = document.getElementById('image-empty');

    function sync() {
        const items = Array.from(list.querySelectorAll('.project-img'));

        items.forEach((el, i) => {
            // La première image est la couverture : autant le dire à l'écran
            // plutôt que de laisser deviner la règle.
            const badge = el.querySelector('.js-cover-badge');
            if (badge) {
                badge.textContent = (i === 0) ? 'couverture' : (i + 1);
                badge.classList.toggle('bg-primary', i === 0);
                badge.classList.toggle('bg-secondary', i !== 0);
            }
            el.querySelector('.js-img-left').disabled  = (i === 0);
            el.querySelector('.js-img-right').disabled = (i === items.length - 1);
        });

        if (empty) empty.hidden = items.length > 0;
        order.value = items.map(el => el.dataset.id).join(',');
    }

    list.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;
        const el = btn.closest('.project-img');
        if (!el) return;

        if (btn.classList.contains('js-img-left') && el.previousElementSibling) {
            list.insertBefore(el, el.previousElementSibling);
        } else if (btn.classList.contains('js-img-right') && el.nextElementSibling) {
            list.insertBefore(el.nextElementSibling, el);
        } else if (btn.classList.contains('js-img-del')) {
            // Retrait immédiat de l'affichage ; le fichier n'est réellement
            // effacé qu'à l'enregistrement du formulaire.
            el.remove();
        } else {
            return;
        }

        sync();
    });

    // --- Glisser-déposer ---------------------------------------------------
    // Même logique que la page des projets à la une. Les flèches restent
    // indispensables : le glisser-déposer HTML5 ne répond ni au doigt sur
    // mobile, ni au clavier.
    let dragged = null;

    list.addEventListener('dragstart', (e) => {
        const el = e.target.closest('.project-img');
        if (!el) return;
        dragged = el;
        el.style.opacity = '0.4';
        e.dataTransfer.effectAllowed = 'move';
        // Firefox exige une charge utile pour démarrer un glisser.
        e.dataTransfer.setData('text/plain', el.dataset.id);
    });

    list.addEventListener('dragend', () => {
        if (dragged) dragged.style.opacity = '';
        dragged = null;
        sync();
    });

    list.addEventListener('dragover', (e) => {
        if (!dragged) return;
        e.preventDefault();
        const over = e.target.closest('.project-img');
        if (!over || over === dragged) return;

        // Insère avant ou après selon que le curseur a dépassé le milieu de la
        // vignette survolée — les vignettes étant en ligne, on compare en X.
        const rect  = over.getBoundingClientRect();
        const after = (e.clientX - rect.left) > rect.width / 2;
        list.insertBefore(dragged, after ? over.nextElementSibling : over);
    });

    list.addEventListener('drop', (e) => e.preventDefault());

    sync();
})();
