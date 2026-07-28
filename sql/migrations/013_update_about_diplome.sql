-- BUT Informatique terminé : passage de "étudiant en 3e année" à "diplômé".
-- Le WHERE reprend le texte du seed 009 : si la valeur a déjà été éditée
-- depuis le panel admin, elle n'est pas écrasée.
UPDATE site_settings
SET `value` = "%age% ans, diplômé du BUT Informatique à l'IUT de Calais.\nPassionné par le développement web backend, la création d'applications\net tout ce qui se passe derrière l'écran."
WHERE `key` = 'about_hero_subtitle'
  AND `value` = "%age% ans, étudiant en 3e année de BUT Informatique à l'IUT de Calais.\nPassionné par le développement web backend, la création d'applications\net tout ce qui se passe derrière l'écran.";

UPDATE site_settings
SET `value` = REPLACE(`value`, "je suis aujourd'hui en dernière année de **BUT Informatique**", "je suis aujourd'hui diplômé du **BUT Informatique**")
WHERE `key` = 'about_bio';
