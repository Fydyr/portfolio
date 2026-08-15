<?php
/**
 * Gestion des images d'un projet — partagée par l'ajout et l'édition.
 *
 * Deux listes séparées, parce que le serveur les traite différemment :
 *
 *   - les images DÉJÀ EN BASE ne voyagent que par `image_order`, la liste
 *     ordonnée des identifiants à CONSERVER ;
 *   - les fichiers EN ATTENTE partent par `images[]`, et syncProjectImages()
 *     les ajoute à la suite des précédents.
 *
 * Les fondre en une seule grille laisserait croire qu'on peut glisser un
 * nouveau fichier avant une image enregistrée : le serveur ne sait pas le
 * faire. Sur la page d'ajout, la première liste est simplement vide, et il ne
 * reste à l'écran qu'une zone de dépôt et ses vignettes.
 *
 * @var array $projectImages Lignes de project_images, dans l'ordre d'affichage.
 */
$projectImages = $projectImages ?? [];
?>
<div class="img-manager" id="img-manager">
    <!-- Tenu à jour par le script : ce qui n'y figure plus est supprimé à
         l'enregistrement. -->
    <input type="hidden" name="image_order" id="image-order" value="">

    <!-- Chaque consigne est posée contre la grille qu'elle décrit : à l'ajout,
         la première grille est vide et seule celle des fichiers en attente
         porte la sienne. -->
    <p class="img-manager-hint" id="image-hint" <?= $projectImages ? '' : 'hidden' ?>>
        Glissez les vignettes pour changer l'ordre, ou utilisez les flèches.
        La première image sert de couverture : c'est elle qui s'affiche sur les
        cartes et lors des partages.
    </p>

    <div class="img-grid" id="image-list" <?= $projectImages ? '' : 'hidden' ?>>
        <?php foreach ($projectImages as $img): ?>
            <figure class="img-tile" data-id="<?= (int)$img['id'] ?>" draggable="true">
                <img src="/assets/img/projects/<?= htmlspecialchars($img['filename']) ?>" alt="">
                <figcaption class="img-tile-rank"></figcaption>
                <div class="img-tile-tools">
                    <button type="button" class="img-tool js-img-left" aria-label="Déplacer vers la gauche">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button type="button" class="img-tool js-img-right" aria-label="Déplacer vers la droite">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                    <button type="button" class="img-tool is-danger js-img-del" aria-label="Supprimer l'image">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </figure>
        <?php endforeach; ?>
    </div>

    <p class="img-manager-empty" id="image-empty" <?= $projectImages ? 'hidden' : '' ?>>
        Aucune image pour l'instant.
    </p>

    <!-- L'input recouvre toute la zone (voir .img-drop-input) : le clic comme
         le dépôt de fichiers sont pris en charge nativement, le script ne pose
         que le surlignage. Il est donc en dernier, pour rester au-dessus. -->
    <label class="img-drop" id="img-drop">
        <span class="img-drop-icon"><i class="bi bi-images"></i></span>
        <span class="img-drop-title">Déposez vos images ici, ou <span class="img-drop-link">parcourez</span></span>
        <span class="img-drop-note">JPG, PNG, GIF ou WebP — 5 Mo maximum par image, autant que vous voulez.</span>
        <input type="file" class="img-drop-input" name="images[]" id="images" accept="image/*" multiple>
    </label>

    <div class="img-pending" id="pending-box" hidden>
        <p class="img-manager-hint">
            À téléverser à l'enregistrement — glissez pour changer l'ordre,
            la croix retire un fichier de la liste.
        </p>
        <div class="img-grid is-pending" id="pending-list"></div>
        <p class="img-manager-warning" id="pending-warning" hidden></p>
    </div>
</div>
