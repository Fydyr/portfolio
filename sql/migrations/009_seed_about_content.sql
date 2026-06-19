-- Settings (champs simples, pas de markdown sauf about_bio)
INSERT IGNORE INTO site_settings (`key`, `value`, `is_markdown`) VALUES
('about_hero_subtitle',
 "%age% ans, étudiant en 3e année de BUT Informatique à l'IUT de Calais.\nPassionné par le développement web backend, la création d'applications\net tout ce qui se passe derrière l'écran.",
 0),
('about_bio',
 "J'ai découvert la programmation au lycée avec la spécialité **NSI** (Mariette, Boulogne-sur-Mer) et je suis aujourd'hui en dernière année de **BUT Informatique**, parcours *Réalisation d'applications*. Mon terrain de jeu favori : le **back**, les **APIs**, l'**architecture** et le **DevOps** (j'ai d'ailleurs dockerisé et déployé moi-même ce site, derrière Traefik).\n\nÀ côté du code, je suis aussi attiré par tout ce qui demande de la stratégie ou de la créativité : *Magic: The Gathering*, les jeux de réflexion, les soundtracks d'animés ou de jeux vidéo, et la science-fiction. Pour moi, ces hobbies nourrissent ma façon de coder : penser plusieurs coups à l'avance, optimiser, debugger calmement.",
 1),
('github_user', 'Fydyr', 0);

-- Sections "Ce que je cherche"
INSERT IGNORE INTO about_sections (slug, title, icon, content, sort_order) VALUES
('opportunite-pro',
 'CDI',
 'bi bi-rocket-takeoff-fill',
 "Diplômé du BUT Informatique, je cherche un premier poste en CDI : back ou full-stack, avec une équipe qui revue le code et une stack moderne.",
 1),
('projets-concrets',
 'Projets concrets',
 'bi bi-code-square',
 "Je préfère livrer un truc qui marche en prod que sur-architecturer : du pragmatique, des tests, du déploiement.",
 2),
('travail-equipe',
 "Travail d'équipe",
 'bi bi-people-fill',
 "Code review, pair programming, scrum / kanban. J'aime apprendre des plus expérimentés.",
 3);
