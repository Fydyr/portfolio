<?php
/**
 * Saisie d'un champ multivalué, en puces.
 *
 * Remplace le couple <input type="text"> + <datalist> qui équipait « Catégories ».
 * Ce couple ne pouvait pas fonctionner : une datalist compare ses options à la
 * VALEUR ENTIÈRE du champ. Dès qu'on avait tapé « Web, », plus aucune option ne
 * correspondait, et l'autocomplétion s'arrêtait après la première valeur. C'est
 * comme ça que « Base de donnée » et « Base de données » ont fini en base toutes
 * les deux, et que le filtre de /projects propose deux puces pour une seule idée.
 *
 * Ici les suggestions sont comparées à la valeur EN COURS DE FRAPPE, et jamais à
 * ce qui a déjà été validé. Ce qui part au serveur reste la même chaîne séparée
 * par des virgules : ni validateProjectData() ni les requêtes n'ont à changer.
 *
 * La clé s'appelle `field` et non `name` : partial() extrait $data dans sa
 * propre portée, où `$name` est déjà pris — c'est son premier paramètre, le nom
 * du fragment. Avec EXTR_SKIP, une clé `name` serait silencieusement ignorée et
 * le champ posté s'appellerait « _tag_input ».
 *
 * @var string $field       Nom du champ posté (la chaîne à virgules).
 * @var string $label       Intitulé affiché.
 * @var string $value       Valeur actuelle, chaîne à virgules.
 * @var array  $known       Valeurs déjà employées ailleurs, pour les suggestions.
 * @var bool   $required    Au moins une valeur exigée.
 * @var string $placeholder Exemple montré tant que le champ est vide.
 * @var string $hint        Précision sous le champ.
 */
$field       = $field ?? 'tags';
$label       = $label ?? 'Valeurs';
$value       = $value ?? '';
$known       = $known ?? [];
$required    = !empty($required);
$placeholder = $placeholder ?? 'Ajouter…';
$hint        = $hint ?? '';
$id          = 'taginput-' . preg_replace('/[^a-z0-9]+/i', '-', $field);
?>
<label class="form-label" for="<?= $id ?>-entry">
    <?= htmlspecialchars($label) ?><?= $required ? ' *' : '' ?>
</label>

<div class="tag-input" id="<?= $id ?>"
     data-known="<?= htmlspecialchars(json_encode(array_values($known), JSON_UNESCAPED_UNICODE)) ?>"
     <?= $required ? 'data-required="1"' : '' ?>>

    <!-- Ce que le serveur reçoit. Le script le tient à jour ; c'est la seule
         chose qui voyage. -->
    <input type="hidden" name="<?= htmlspecialchars($field) ?>"
           id="<?= $id ?>-value" value="<?= htmlspecialchars($value) ?>">

    <div class="tag-input-box">
        <span class="tag-input-chips js-tag-chips"></span>
        <input type="text" class="tag-input-entry js-tag-entry" id="<?= $id ?>-entry"
               placeholder="<?= htmlspecialchars($placeholder) ?>"
               autocomplete="off" role="combobox" aria-expanded="false"
               aria-controls="<?= $id ?>-list" aria-autocomplete="list">
    </div>

    <ul class="tag-input-list js-tag-list" id="<?= $id ?>-list" role="listbox" hidden></ul>
</div>

<?php if ($hint !== ''): ?>
    <div class="form-text"><?= $hint ?></div>
<?php endif; ?>
