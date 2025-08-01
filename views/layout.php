<?php

// Inclusion du header avec chemin absolu
$header_path = __DIR__ . '../includes/header.php';
if (file_exists($header_path)) {
    include $header_path;
} else {
    // Essayez avec un chemin relatif
    include 'includes/header.php';
}
?>

<!-- Contenu de la page -->
<?= $content ?? 'Contenu par défaut pour test' ?>

<?php
// Inclusion du footer avec chemin absolu
$footer_path = __DIR__ . '/../includes/footer.php';
if (file_exists($footer_path)) {
    include $footer_path;
} else {
    // Essayez avec un chemin relatif
    include 'includes/footer.php';
}
?>