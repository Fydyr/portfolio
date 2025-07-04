<?php ob_start(); ?>
<div style="text-align: center; margin: 3rem 0;">
    <h1 style="font-size: 4rem; color: #dc3545; margin-bottom: 1rem;">500</h1>
    <h2><?= $title ?></h2>

    <p style="font-size: 1.2rem; color: #666; margin: 1rem 0;"><?= $message ?></p>

    <div style="margin-top: 2rem;">
        <a href="<?= homeUrl() ?>" class="btn">🏠 Retour à l'accueil</a>
        <a href="javascript:history.back()" class="btn" style="background: #6c757d;">← Page précédente</a>
    </div>
</div>
<?php $content = ob_get_clean();
include 'layout.php'; ?>