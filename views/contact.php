<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Enzo Fournier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Style CSS personnalisé -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <!-- EmailJS SDK -->
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="profile-header fade-in">
            <div class="profile-avatar">
                <i class="bi bi-envelope-fill"></i>
            </div>
            <h1>Me Contacter</h1>
            <h2>Formulaire pour me contacter</h2>
        </div>

        <!-- Container pour les messages de statut -->
        <div id="message-container"></div>

        <!-- Formulaire de contact avec EmailJS -->
        <div class="card fade-in mb-4">
            <div class="card-body">
                <form id="contact-form">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Nom *</label>
                        <input type="text"
                            class="form-control"
                            id="user_name"
                            name="user_name"
                            placeholder="Votre nom complet"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="user_email" class="form-label">Email *</label>
                        <input type="email"
                            class="form-control"
                            id="user_email"
                            name="user_email"
                            placeholder="votre.email@exemple.com"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Sujet *</label>
                        <input type="text"
                            class="form-control"
                            id="subject"
                            name="subject"
                            placeholder="Sujet de votre message"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control"
                            id="message"
                            name="message"
                            rows="6"
                            placeholder="Votre message détaillé..."
                            required></textarea>
                    </div>

                    <!-- Protection anti-spam (honeypot) -->
                    <div class="mb-3" style="display: none;">
                        <label for="honeypot">Ne pas remplir ce champ</label>
                        <input type="text" id="honeypot" name="honeypot" tabindex="-1">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>
                            <span id="btn-text">Envoyer le message</span>
                        </button>
                        <small class="text-muted">* Champs obligatoires</small>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lien vers les réseaux sociaux -->
        <div class="card fade-in mb-4">
            <div class="card-header">
                <h2 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i>
                    Mes réseaux sociaux
                </h2>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h3 class="text-primary">
                            <a href="https://github.com/Fydyr" target="_blank" class="text-decoration-none">
                                <i class="fab fa-github text-muted me-2"></i>
                                Github
                            </a>
                        </h3>
                        <p class="text-muted small">Découvrez mes projets open source</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h3 class="text-primary">
                            <a href="https://www.linkedin.com/in/enzo-fournier-2746ba2b3/" target="_blank" class="text-decoration-none">
                                <i class="fab fa-linkedin-in text-muted me-2"></i>
                                Linkedin
                            </a>
                        </h3>
                        <p class="text-muted small">Mon profil professionnel</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h3 class="text-primary">
                            <a href="https://discord.gg/RT2XsGFFEr" target="_blank" class="text-decoration-none">
                                <i class="fab fa-discord text-muted me-2"></i>
                                Discord
                            </a>
                        </h3>
                        <p class="text-muted small">Rejoignez ma communauté</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // ⚠️ CONFIGURATION EMAILJS - À REMPLACER PAR TES VALEURS
        const EMAIL_CONFIG = {
            serviceID: 'service_u8szg5e', // Service ID depuis emailjs.com
            templateID: 'template_44x6gab', // Template ID depuis emailjs.com
            publicKey: 'urMgueUb4s3PG7SLq' // Public Key depuis emailjs.com
        };

        // Initialisation d'EmailJS
        emailjs.init(EMAIL_CONFIG.publicKey);

        // Gestionnaire du formulaire
        document.getElementById('contact-form').addEventListener('submit', function(event) {
            event.preventDefault();

            // Vérification anti-spam
            if (document.querySelector('input[name="honeypot"]').value !== '') {
                showMessage('Tentative de spam détectée.', 'error');
                return;
            }

            // Validation simple côté client
            const requiredFields = ['user_name', 'user_email', 'subject', 'message'];
            let hasErrors = false;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    hasErrors = true;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            });

            if (hasErrors) {
                showMessage('Veuillez remplir tous les champs obligatoires.', 'error');
                return;
            }

            // Animation du bouton
            const submitBtn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');

            submitBtn.disabled = true;
            btnText.textContent = 'Envoi en cours...';
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' + btnText.textContent;

            // Envoi via EmailJS
            emailjs.sendForm(EMAIL_CONFIG.serviceID, EMAIL_CONFIG.templateID, this)
                .then(function(response) {
                    console.log('SUCCESS!', response.status, response.text);
                    showMessage('Message envoyé avec succès ! Je vous répondrai dans les plus brefs délais.', 'success');
                    document.getElementById('contact-form').reset();

                    // Retirer les classes de validation
                    document.querySelectorAll('.is-valid, .is-invalid').forEach(el => {
                        el.classList.remove('is-valid', 'is-invalid');
                    });
                }, function(error) {
                    console.log('FAILED...', error);
                    showMessage('Une erreur est survenue lors de l\'envoi. Veuillez réessayer ou me contacter directement sur les réseaux sociaux.', 'error');
                })
                .finally(function() {
                    // Restaurer le bouton
                    submitBtn.disabled = false;
                    btnText.textContent = 'Envoyer le message';
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>' + btnText.textContent;
                });
        });

        // Fonction d'affichage des messages (style identique à tes alertes)
        function showMessage(text, type) {
            const container = document.getElementById('message-container');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

            container.innerHTML = `
                <div class="alert ${alertClass} fade-in">
                    <i class="fas ${icon} me-2"></i>
                    ${text}
                </div>
            `;

            // Scroll vers le message
            container.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Masquer le message après 8 secondes
            setTimeout(() => {
                const alert = container.querySelector('.alert');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        container.innerHTML = '';
                    }, 300);
                }
            }, 8000);
        }

        // Validation en temps réel améliorée
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[required], textarea[required]');

            inputs.forEach(input => {
                // Validation lors de la perte de focus
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                // Validation lors de la saisie
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });

            // Validation spéciale pour l'email
            const emailInput = document.getElementById('user_email');
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value.trim() === '' || !emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>