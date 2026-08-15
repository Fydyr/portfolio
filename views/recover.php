<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération de compte - Enzo Fournier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="profile-header fade-in">
        <div class="profile-avatar">
            <i class="bi bi-life-preserver"></i>
        </div>
        <h1>Récupération de compte</h1>
        <h2>Reprise en main avec un code de secours</h2>
    </div>

    <div class="container">
        <div class="card fade-in mb-4">
            <div class="card-body">
                <div class="form-container">

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $e): ?>
                                <div><?= htmlspecialchars($e) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <p class="text-muted">
                        Saisissez l'un des codes de secours générés depuis votre espace
                        d'administration. Chaque code ne fonctionne qu'une seule fois.
                    </p>

                    <form action="<?= url('recover') ?>" method="post" class="mt-4">
                        <?= csrfField() ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail du compte</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   required autocomplete="username">
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Code de secours</label>
                            <input type="text" class="form-control" id="code" name="code"
                                   required autocomplete="off" spellcheck="false"
                                   placeholder="XXXX-XXXX-XXXX"
                                   style="letter-spacing: 2px; text-transform: uppercase;">
                            <div class="form-text">
                                Les tirets, espaces et minuscules sont acceptés indifféremment.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="new_password"
                                   name="new_password" required autocomplete="new-password"
                                   minlength="<?= PASSWORD_MIN_LENGTH ?>">
                            <div class="form-text"><?= PASSWORD_MIN_LENGTH ?> caractères minimum.</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" class="form-control" id="confirm_password"
                                   name="confirm_password" required autocomplete="new-password">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-shield-check"></i> Réinitialiser
                        </button>
                        <a href="<?= url('login') ?>" class="btn btn-outline-light">Retour à la connexion</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
