/**
 * Choix et ordre des projets à la une (/admin/featured).
 *
 * Deux moyens de réordonner, volontairement :
 *   - le glisser-déposer, via l'API native du navigateur, sans bibliothèque ;
 *   - des flèches monter/descendre.
 *
 * Les flèches ne sont pas une redondance décorative : le glisser-déposer HTML5
 * ne fonctionne pas au doigt sur mobile, ni au clavier. Sans elles, la page
 * serait inutilisable dans ces deux contextes.
 *
 * Le formulaire ne poste qu'un champ : la liste ordonnée des identifiants.
 */
(function () {
    const featured   = document.getElementById('list-featured');
    const others     = document.getElementById('list-others');
    const orderInput = document.getElementById('order-input');
    if (!featured || !others || !orderInput) return;

    const featEmpty  = document.getElementById('featured-empty');
    const otherEmpty = document.getElementById('others-empty');

    /** Recalcule les rangs, l'état des boutons, les listes vides et le champ posté. */
    function sync() {
        const items = Array.from(featured.children);

        items.forEach((li, i) => {
            li.querySelector('.feat-rank').textContent = i + 1;
            li.querySelector('.js-up').disabled   = (i === 0);
            li.querySelector('.js-down').disabled = (i === items.length - 1);
        });

        featEmpty.hidden  = items.length > 0;
        otherEmpty.hidden = others.children.length > 0;

        orderInput.value = items.map(li => li.dataset.id).join(',');
    }

    /** Transforme une ligne pour la liste d'accueil (rang, poignée, 3 boutons). */
    function toFeatured(li) {
        li.setAttribute('draggable', 'true');
        li.insertAdjacentHTML('afterbegin',
            '<i class="bi bi-grip-vertical feat-handle" aria-hidden="true"></i>' +
            '<span class="feat-rank"></span>');
        li.querySelector('.feat-actions').innerHTML =
            '<button type="button" class="feat-btn js-up" title="Monter" aria-label="Monter"><i class="bi bi-arrow-up"></i></button>' +
            '<button type="button" class="feat-btn js-down" title="Descendre" aria-label="Descendre"><i class="bi bi-arrow-down"></i></button>' +
            '<button type="button" class="feat-btn is-remove js-remove" title="Retirer de la une" aria-label="Retirer de la une"><i class="bi bi-x-lg"></i></button>';
    }

    /** Transforme une ligne pour la liste des autres projets (un seul bouton). */
    function toOther(li) {
        li.removeAttribute('draggable');
        const handle = li.querySelector('.feat-handle');
        const rank   = li.querySelector('.feat-rank');
        if (handle) handle.remove();
        if (rank) rank.remove();
        li.querySelector('.feat-actions').innerHTML =
            '<button type="button" class="feat-btn is-add js-add" title="Mettre à la une" aria-label="Mettre à la une"><i class="bi bi-plus-lg"></i></button>';
    }

    // --- Boutons ---------------------------------------------------------
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.feat-btn');
        if (!btn) return;
        const li = btn.closest('.feat-item');
        if (!li) return;

        if (btn.classList.contains('js-up') && li.previousElementSibling) {
            featured.insertBefore(li, li.previousElementSibling);
        } else if (btn.classList.contains('js-down') && li.nextElementSibling) {
            featured.insertBefore(li.nextElementSibling, li);
        } else if (btn.classList.contains('js-remove')) {
            toOther(li);
            others.prepend(li);
        } else if (btn.classList.contains('js-add')) {
            toFeatured(li);
            featured.appendChild(li);
        } else {
            return;
        }

        sync();
        // Garde le focus sur le bouton équivalent après réorganisation : sans ça,
        // la navigation au clavier repart du début de la page à chaque clic.
        const again = li.querySelector('.' + [...btn.classList].find(c => c.startsWith('js-')));
        if (again && !again.disabled) again.focus();
    });

    // --- Glisser-déposer -------------------------------------------------
    let dragged = null;

    featured.addEventListener('dragstart', (e) => {
        const li = e.target.closest('.feat-item');
        if (!li) return;
        dragged = li;
        li.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
        // Firefox exige une charge utile pour démarrer un glisser.
        e.dataTransfer.setData('text/plain', li.dataset.id);
    });

    featured.addEventListener('dragend', () => {
        if (dragged) dragged.classList.remove('dragging');
        featured.querySelectorAll('.drop-target')
                .forEach(el => el.classList.remove('drop-target'));
        dragged = null;
        sync();
    });

    featured.addEventListener('dragover', (e) => {
        if (!dragged) return;
        e.preventDefault();
        const over = e.target.closest('.feat-item');
        if (!over || over === dragged) return;

        featured.querySelectorAll('.drop-target')
                .forEach(el => el.classList.remove('drop-target'));
        over.classList.add('drop-target');

        // Insère avant ou après selon que le curseur est au-dessus ou en dessous
        // du milieu de la ligne survolée.
        const rect  = over.getBoundingClientRect();
        const after = (e.clientY - rect.top) > rect.height / 2;
        featured.insertBefore(dragged, after ? over.nextElementSibling : over);
    });

    featured.addEventListener('drop', (e) => e.preventDefault());

    sync();
})();
