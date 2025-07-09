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

        <!-- Affichage des messages flash -->
        <?php if (isset($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> fade-in">
                    <i class="fas fa-<?= $type === 'success' ? 'check-circle' : ($type === 'error' ? 'exclamation-triangle' : 'info-circle') ?> me-2"></i>
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <!-- Formulaire de contact -->
        <div class="card fade-in mb-4">
            <div class="card-body">
                <form method="POST" action="<?= url('contact') ?>" id="contactForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom *</label>
                        <input type="text"
                            class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                            id="name"
                            name="name"
                            placeholder="Votre nom complet"
                            value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                            required>
                        <?php if (isset($errors['name'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['name']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email"
                            class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            id="email"
                            name="email"
                            placeholder="votre.email@exemple.com"
                            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                            required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['email']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Sujet *</label>
                        <input type="text"
                            class="form-control <?= isset($errors['subject']) ? 'is-invalid' : '' ?>"
                            id="subject"
                            name="subject"
                            placeholder="Sujet de votre message"
                            value="<?= htmlspecialchars($old['subject'] ?? '') ?>"
                            required>
                        <?php if (isset($errors['subject'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['subject']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"
                            id="message"
                            name="message"
                            rows="6"
                            placeholder="Votre message détaillé..."
                            required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['message']) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Protection anti-spam simple -->
                    <div class="mb-3" style="display: none;">
                        <label for="honeypot">Ne pas remplir ce champ</label>
                        <input type="text" id="honeypot" name="honeypot" tabindex="-1">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-paper-plane me-2"></i>
                            Envoyer le message
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
        // Animation du bouton de soumission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
            submitBtn.disabled = true;
        });

        // Validation côté client améliorée
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const inputs = form.querySelectorAll('input[required], textarea[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });
        });
    </script>
</body>

</html>

<?php $content = ob_get_clean();
include 'layout.php'; ?>