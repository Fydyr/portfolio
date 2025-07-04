<?php ob_start(); ?>
<div style="text-align: center; margin: 3rem 0;">
    <h1 style="font-size: 4rem; color: #e74c3c; margin-bottom: 1rem;">404</h1>
    <h2><?= $title ?></h2>

    <?php if (isset($message)): ?>
        <p style="font-size: 1.2rem; color: #666; margin: 1rem 0;"><?= $message ?></p>
    <?php endif; ?>

    <div style="margin-top: 2rem;">
        <a href="<?= homeUrl() ?>" class="btn">🏠 Retour à l'accueil</a>
    </div>

    <div style="margin-top: 2rem; padding: 1rem; background: #f8f9fa; border-radius: 4px;">
        <h3>💡 Suggestions :</h3>
        <ul style="text-align: left; display: inline-block;">
            <li>Vérifiez l'URL dans votre navigateur</li>
            <li>Utilisez le menu de navigation</li>
            <li>Contactez-nous si le problème persiste</li>
        </ul>
    </div>
</div>
<?php $content = ob_get_clean();
include 'layout.php'; ?>