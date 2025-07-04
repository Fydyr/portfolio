<?php ob_start(); ?>
<h1><?= $title ?></h1>
<p><?= $message ?></p>

<div class="card">
</div>

<div class="card">
    <h3>ℹ️ Informations techniques</h3>
    <p><strong>URL actuelle :</strong> <?= $_SERVER['REQUEST_URI'] ?></p>
    <p><strong>Script :</strong> <?= $_SERVER['SCRIPT_NAME'] ?></p>
</div>
<?php $content = ob_get_clean();
include 'layout.php'; ?>