/**
 * Comportement de la page d'accueil : les trois modales (technologies, passions,
 * BUT Informatique) et l'animation d'apparition au défilement.
 *
 * Les données viennent de balises <script type="application/json"> générées par
 * PHP dans views/home.php. Ce fichier ne contient donc que du comportement : il
 * est statique, donc mis en cache par le navigateur, et lisible sans PHP.
 *
 * Chargé avec `defer` : il s'exécute après l'analyse du document, les éléments
 * sont déjà présents, aucun besoin d'attendre DOMContentLoaded.
 */

// Tout est encapsulé dans une IIFE. Les scripts classiques partagent la portée
// globale : sans ça, `const observerOptions` entrerait en collision avec celui
// de includes/footer.php:246 et le second script chargé lèverait une
// SyntaxError, cassant l'intégralité de ce fichier.
(function () {

    function readJson(id) {
        const el = document.getElementById(id);
        if (!el) return {};
        try {
            return JSON.parse(el.textContent);
        } catch (e) {
            console.error(`Données illisibles dans #${id}`, e);
            return {};
        }
    }

    // `passionData` est au SINGULIER : c'est le nom qu'utilise le code ci-dessous.
    const techData    = readJson('tech-data');
    const passionData = readJson('passions-data');

    // Gestion de la modale
    const modal = document.getElementById('techModal');

    // IMPORTANT: Déplacer la modale directement dans le body pour éviter les problèmes de z-index
    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    const closeBtn = modal.querySelector('.tech-modal-close');
    const closeBtnBottom = modal.querySelector('.btn-modal-close');
    const techBadges = document.querySelectorAll('.tech-badge');
    const docBtn = modal.querySelector('.btn-modal-docs');

    function closeModal() {
        modal.classList.remove('active');
        setTimeout(() => modal.style.display = 'none', 300);
    }

    techBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            const techKey = this.getAttribute('data-tech');
            const tech = techData[techKey];

            if (tech) {
                // Titre et description
                document.querySelector('.tech-modal-title').textContent = tech.name;
                document.querySelector('.tech-modal-description').textContent = tech.description;
                document.querySelector('.tech-type').textContent = tech.type;
                document.querySelector('.tech-level').textContent = tech.level;

                // Icône
                const iconElement = document.querySelector('.tech-icon-display');
                iconElement.className = 'tech-icon-display ' + tech.icon;

                // Features
                const featuresList = document.querySelector('.tech-features-list');
                featuresList.innerHTML = '';
                tech.features.forEach(feature => {
                    const li = document.createElement('li');
                    li.innerHTML = `<i class="fas fa-check-circle"></i> ${feature}`;
                    featuresList.appendChild(li);
                });

                // Lien documentation
                docBtn.href = tech.docUrl;

                // Affichage de la modale
                modal.style.display = 'flex';
                setTimeout(() => modal.classList.add('active'), 10);
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Fermeture via bouton X
    closeBtn.addEventListener('click', function() {
        closeModal();
        document.body.style.overflow = 'auto';
    });

    // Fermeture via bouton Fermer
    closeBtnBottom.addEventListener('click', function() {
        closeModal();
        document.body.style.overflow = 'auto';
    });

    // Fermeture en cliquant sur l'overlay
    const modalOverlay = modal.querySelector('.tech-modal-overlay');
    modalOverlay.addEventListener('click', function(event) {
        closeModal();
        document.body.style.overflow = 'auto';
    });

    // Fermeture avec la touche Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
            document.body.style.overflow = 'auto';
        }
    });

    // Gestion de la modale des passions
    const passionModal = document.getElementById('passionModal');
    const passionCards = document.querySelectorAll('.passion-card');

    // Déplacer la modale directement dans le body pour éviter les problèmes de z-index
    if (passionModal && passionModal.parentElement !== document.body) {
        document.body.appendChild(passionModal);
    }

    const passionCloseBtn = passionModal.querySelector('.passion-modal-close');
    const passionCloseBtnBottom = passionModal.querySelector('.passion-btn-close');

    function closePassionModal() {
        passionModal.classList.remove('active');
        setTimeout(() => passionModal.style.display = 'none', 300);
    }

    passionCards.forEach(card => {
        card.addEventListener('click', function() {
            const passionKey = this.getAttribute('data-passion');
            const passion = passionData[passionKey];

            if (passion) {
                // Titre et description
                document.querySelector('.passion-modal-title').textContent = passion.name;
                document.querySelector('.passion-modal-description').textContent = passion.description;
                document.querySelector('.passion-modal-why').textContent = passion.why;

                // Icône
                const iconElement = document.querySelector('.passion-icon-display');
                iconElement.className = 'passion-icon-display ' + passion.icon;

                // Icône de fond avec gradient rouge
                const modalIcon = document.querySelector('.passion-modal-icon');
                modalIcon.style.background = 'linear-gradient(135deg, #EF4444 0%, #DC2626 100%)';

                // Liste de ce que j'aime
                const likesList = document.querySelector('.passion-likes-list');
                likesList.innerHTML = '';
                passion.likes.forEach(like => {
                    const li = document.createElement('li');
                    li.innerHTML = `<i class="fas fa-check-circle"></i> ${like}`;
                    likesList.appendChild(li);
                });

                // Affichage de la modale
                passionModal.style.display = 'flex';
                setTimeout(() => passionModal.classList.add('active'), 10);
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Fermeture via bouton X
    passionCloseBtn.addEventListener('click', function() {
        closePassionModal();
        document.body.style.overflow = 'auto';
    });

    // Fermeture via bouton Fermer
    passionCloseBtnBottom.addEventListener('click', function() {
        closePassionModal();
        document.body.style.overflow = 'auto';
    });

    // Fermeture en cliquant sur l'overlay
    const passionModalOverlay = passionModal.querySelector('.tech-modal-overlay');
    passionModalOverlay.addEventListener('click', function(event) {
        closePassionModal();
        document.body.style.overflow = 'auto';
    });

    // Fermeture avec la touche Escape (s'applique aussi aux passions)
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && passionModal.classList.contains('active')) {
            closePassionModal();
            document.body.style.overflow = 'auto';
        }
    });


    // Gestion de la modale BUT Informatique
    const butModal = document.getElementById('butModal');
    if (butModal && butModal.parentElement !== document.body) {
        document.body.appendChild(butModal);
    }

    const butCardEl = document.getElementById('but-info-card');
    const butCloseBtn = butModal.querySelector('.but-modal-close');
    const butCloseBtnBottom = butModal.querySelector('.but-btn-close');

    function closeButModal() {
        butModal.classList.remove('active');
        setTimeout(() => butModal.style.display = 'none', 300);
    }

    if (butCardEl) {
        butCardEl.addEventListener('click', function() {
            butModal.style.display = 'flex';
            setTimeout(() => butModal.classList.add('active'), 10);
            document.body.style.overflow = 'hidden';
        });
    }

    butCloseBtn.addEventListener('click', function() {
        closeButModal();
        document.body.style.overflow = 'auto';
    });

    butCloseBtnBottom.addEventListener('click', function() {
        closeButModal();
        document.body.style.overflow = 'auto';
    });

    const butModalOverlay = butModal.querySelector('.tech-modal-overlay');
    butModalOverlay.addEventListener('click', function() {
        closeButModal();
        document.body.style.overflow = 'auto';
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && butModal.classList.contains('active')) {
            closeButModal();
            document.body.style.overflow = 'auto';
        }
    });

    // Smooth scroll animations
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

    document.querySelectorAll('.skill-card, .stat-card, .timeline-item-modern').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
})();
