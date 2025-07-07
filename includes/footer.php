</div>
</main>

<!-- Footer -->
<footer class="footer-section">
    <div class="footer-bg-effect"></div>

    <!-- Footer principal -->
    <div class="footer-main">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <!-- Colonne 1: À propos -->
                <div class="col-lg-4 col-md-12">
                    <div class="footer-widget">
                        <div class="footer-brand mb-4">
                            <h3 class="footer-title">
                                <span class="brand-icon">&lt;/&gt;</span>
                                <?php echo $site_title; ?>
                            </h3>
                            <p class="footer-tagline">Développeur Web & Application • Créatif • Passionné</p>
                        </div>
                        <p class="footer-description">
                            Passionné par la création d'expériences numériques.
                        </p>

                        <!-- Stats -->
                        <div class="footer-stats">
                            <div class="stat-item">
                                <span class="stat-number counter" data-target="19">0</span>
                                <span class="stat-label">Projets réalisé</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number counter" data-target="2">0</span>
                                <span class="stat-label">Année de BUT<br />(actuellement)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne 2: Contact & Réseaux -->
                <div class="col-lg-4 col-md-12">
                    <div class="footer-widget">
                        <h4 class="footer-widget-title">Restons connectés</h4>

                        <!-- Informations de contact -->
                        <div class="footer-contact mb-4">
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:contact@enzofournier.com">enzofournier.contact@gmail.com</a>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>France</span>
                            </div>
                        </div>

                        <!-- Réseaux sociaux -->
                        <div class="footer-social">
                            <h5 class="social-title">Suivez-moi</h5>
                            <div class="social-links">
                                <a href="https://github.com/Fydyr" target="_blank" class="social-link github" title="GitHub">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/enzo-fournier-2746ba2b3/" target="_blank" class="social-link linkedin" title="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://discord.gg/RT2XsGFFEr" target="_blank" class="social-link discord" title="Discord"><i class="fab fa-discord"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="footer-copyright">
                        <p>
                            &copy; <?php echo date('Y'); ?>
                            <strong><?php echo $site_title; ?></strong>.
                            Tous droits réservés.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-legal">
                        <ul class="legal-links">
                            <li><a href="<?= url('legal-mention')?>">Mentions légales</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Status indicator -->
            <div class="status-indicator">
                <div class="status-dot"></div>
                <span class="status-text">Disponible pour de nouveaux projets</span>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Particles.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser les particules
        if (typeof particlesJS !== 'undefined') {
            particlesJS('particles-bg', {
                particles: {
                    number: {
                        value: 60,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: "#00d4ff"
                    },
                    shape: {
                        type: "circle"
                    },
                    opacity: {
                        value: 0.3,
                        random: false
                    },
                    size: {
                        value: 3,
                        random: true
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#00d4ff",
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 2,
                        direction: "none",
                        random: false,
                        straight: false,
                        out_mode: "out",
                        bounce: false
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: {
                            enable: true,
                            mode: "repulse"
                        },
                        onclick: {
                            enable: false
                        },
                        resize: true
                    },
                    modes: {
                        repulse: {
                            distance: 100,
                            duration: 0.4
                        }
                    }
                },
                retina_detect: true
            });
        }

        // Auto-hide alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // Compteurs animés
        const counters = document.querySelectorAll('.counter');

        const observerOptions = {
            threshold: 0.7
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'));
                    const increment = target / 50;
                    let current = 0;

                    const updateCounter = () => {
                        if (current < target) {
                            current += increment;
                            counter.textContent = Math.ceil(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target;
                        }
                    };

                    updateCounter();
                    observer.unobserve(counter);
                }
            });
        }, observerOptions);

        counters.forEach(counter => observer.observe(counter));
    });
</script>

</body>

</html>