<?php ob_start();

// Calcul dynamique de l'âge
$birthDate = new DateTime('2005-03-15');
$today = new DateTime();
$age = $today->diff($birthDate)->y;

// Variables passées par HomeController : $categories, $skillsByCategory, $passions, $languageCount, $projectCount
$categories       = $categories       ?? [];
$skillsByCategory = $skillsByCategory ?? [];
$passions         = $passions         ?? [];
$languageCount    = $languageCount    ?? 0;

// Aplatit toutes les skills (utile pour le bloc JS techData)
$allSkills = [];
foreach ($skillsByCategory as $list) {
    foreach ($list as $s) $allSkills[] = $s;
}
// Pas de <!DOCTYPE>, <html>, <head> ni <body> ici : includes/header.php les
// produit déjà, et cette vue est injectée à l'intérieur. En émettre une seconde
// série donnait deux documents imbriqués, et rechargeait Bootstrap, Font Awesome
// et Google Fonts une fois de trop.
?>
<?php
// Les appels sont volontairement collés à la marge : chaque fragment porte déjà
// sa propre indentation, et l'indenter ici la doublerait dans le HTML servi.
partial('home/_hero', compact('age', 'languageCount', 'projectCount'));
echo "\n";
partial('home/_stack', compact('categories', 'skillsByCategory'));
echo "\n";
partial('home/_passions', compact('passions'));
echo "\n";
// Les projets passent avant le parcours scolaire : c'est ce qu'un visiteur de
// portfolio vient voir en premier.
partial('home/_projets', compact('recentProjects'));
echo "\n";
partial('home/_formation');
echo "\n";
partial('home/_cta');
echo "\n";
partial('home/_modales');
// PHP absorbe le saut de ligne qui suit immédiatement une balise fermante.
// Sans ce echo, la ligne vide séparant les modales du script disparaîtrait.
// (Ne jamais écrire la balise fermante dans un commentaire // : elle ferme
//  réellement le bloc PHP, même commentée.)
echo "\n";
?>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script id="tech-data" type="application/json">
        <?php
            $techJs = [];
            foreach ($allSkills as $s) {
                $techJs[$s['slug']] = [
                    'name'        => $s['name'],
                    'description' => $s['description'] ?? '',
                    'type'        => $s['type'] ?? '',
                    'level'       => $s['level'] ?? '',
                    'features'    => $s['features_decoded'] ?? [],
                    'icon'        => $s['icon'] ?: 'fas fa-code',
                    'docUrl'      => $s['doc_url'] ?? '#',
                ];
            }
            // JSON_HEX_TAG neutralise les < et > : sans lui, une donnée contenant
            // une balise fermante de script terminerait la balise prématurément.
            echo json_encode($techJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
        ?>
    </script>

    <script id="passions-data" type="application/json">
        <?php
            $passionJs = [];
            foreach ($passions as $p) {
                $passionJs[$p['slug']] = [
                    'name'        => $p['name'],
                    'description' => $p['long_description'] ?? '',
                    'icon'        => $p['icon'] ?: 'fas fa-heart',
                    'likes'       => $p['likes_decoded'] ?? [],
                    'why'         => $p['why'] ?? '',
                ];
            }
            echo json_encode($passionJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
        ?>
    </script>

    <script src="/assets/js/home.js" defer></script>

<?php $content = ob_get_clean();
include 'layout.php'; ?>
