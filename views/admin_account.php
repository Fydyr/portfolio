<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mon compte</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Mon compte</h1>
        <a href="<?= url('admin') ?>" class="btn btn-outline-light">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <?php $success = getFlash('success'); ?>
    <?php if ($success): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="mb-0"><i class="bi bi-key-fill"></i> Changer le mot de passe</h2>
        </div>
        <div class="card-body">
            <p class="text-muted">
                Compte : <strong><?= htmlspecialchars($userMail) ?></strong>
            </p>
            <form method="post" action="<?= url('admin/account/password') ?>">
                <?= csrfField() ?>
                <div class="mb-3">
                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password"
                           class="form-control" required autocomplete="current-password">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="new_password" id="new_password"
                           class="form-control" required autocomplete="new-password"
                           minlength="<?= PASSWORD_MIN_LENGTH ?>">
                    <div class="form-text">
                        <?= PASSWORD_MIN_LENGTH ?> caractères minimum. Une phrase longue vaut
                        mieux qu'un mot court parsemé de symboles.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirm_password" id="confirm_password"
                           class="form-control" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Mettre à jour
                </button>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h2 class="mb-0"><i class="bi bi-life-preserver"></i> Codes de secours</h2>
        </div>
        <div class="card-body">

            <?php if (!empty($plainCodes)): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Notez ces codes maintenant.</strong> Ils ne sont stockés que sous
                    forme chiffrée : cette page est la seule occasion de les lire. Fermer
                    l'onglet les perd définitivement.
                </div>
                <pre class="p-3 mb-3" style="background: rgba(0,0,0,0.35); border-radius: 8px; font-size: 1.1rem; letter-spacing: 1px;"><?php
                    foreach ($plainCodes as $c) {
                        echo htmlspecialchars($c), "\n";
                    }
                ?></pre>
                <p class="text-muted">
                    Chaque code ne fonctionne qu'une seule fois, sur la page
                    <code><?= htmlspecialchars(url('recover')) ?></code>.
                </p>
            <?php endif; ?>

            <?php if ($remainingCodes === 0): ?>
                <div class="alert alert-secondary">
                    <i class="bi bi-info-circle-fill"></i>
                    Aucun code de secours actif. Sans code, la seule reprise en main possible
                    passe par un accès au serveur.
                </div>
            <?php elseif ($remainingCodes <= 2): ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Il ne reste que <strong><?= (int)$remainingCodes ?></strong> code(s) de
                    secours. Pensez à en régénérer un lot.
                </div>
            <?php else: ?>
                <p>
                    <strong><?= (int)$remainingCodes ?></strong> code(s) de secours encore
                    utilisable(s) sur <?= RECOVERY_CODE_COUNT ?>.
                </p>
            <?php endif; ?>

            <form method="post" action="<?= url('admin/account/recovery-codes') ?>"
                  onsubmit="return confirm('Générer un nouveau lot invalide immédiatement tous les codes précédents. Continuer ?');">
                <?= csrfField() ?>
                <button type="submit" class="btn btn-outline-light">
                    <i class="bi bi-arrow-repeat"></i>
                    Générer <?= RECOVERY_CODE_COUNT ?> nouveaux codes
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php $content = ob_get_clean(); include 'layout.php'; ?>
