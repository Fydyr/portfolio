-- Catégories de compétences
INSERT IGNORE INTO skill_categories (id, name, description, icon, icon_bg, sort_order) VALUES
(1, 'Langages',           'Langages de programmation maîtrisés',  'fas fa-code',     NULL,                                                             1),
(2, 'Développement Web',  'Frontend & Backend',                   'fas fa-globe',    'var(--gradient-secondary)',                                       2),
(3, 'Bases de données',   'Systèmes de gestion de données',       'fas fa-database', 'var(--gradient-warning)',                                          3),
(4, 'Outils',             'DevOps et environnements',             'fas fa-tools',    'linear-gradient(135deg, #EF4444 0%, #DC2626 100%)',                4);

-- Skills : Langages
INSERT IGNORE INTO skills (category_id, name, slug, description, type, level, icon, doc_url, features, sort_order) VALUES
(1, 'Python',     'python',       'Langage de programmation polyvalent, idéal pour le scripting, l''analyse de données et l''automatisation.',
    'Langage de programmation', 'Avancé',        'fab fa-python', 'https://docs.python.org/fr/3/',
    '["Scripts d''automatisation","Analyse de données","Développement backend","APIs REST"]', 1),
(1, 'HTML/CSS',   'html-css',     'Technologies fondamentales pour la structure et le style des pages web.',
    'Langages web', 'Avancé', 'fab fa-html5', 'https://developer.mozilla.org/fr/docs/Web/HTML',
    '["Structure sémantique","Design responsive","Animations CSS","Flexbox & Grid"]', 2),
(1, 'PHP',        'php',          'Langage de script côté serveur, largement utilisé pour le développement web dynamique.',
    'Langage backend', 'Intermédiaire', 'fab fa-php', 'https://www.php.net/manual/fr/',
    '["Développement web backend","APIs REST","Gestion de bases de données","Applications MVC"]', 3),
(1, 'JavaScript', 'javascript',   'Langage de programmation polyvalent pour le développement web moderne, tant côté client que serveur.',
    'Langage de programmation', 'Intermédiaire', 'fab fa-js', 'https://developer.mozilla.org/fr/docs/Web/JavaScript',
    '["Manipulation du DOM","Applications web interactives","Développement backend avec Node.js","Programmation asynchrone"]', 4),
(1, 'TypeScript', 'typescript',   'Superset de JavaScript qui ajoute le typage statique, améliorant la maintenabilité du code.',
    'Langage de programmation', 'Intermédiaire', 'fab fa-js', 'https://www.typescriptlang.org/docs/',
    '["Typage statique fort","Meilleure autocomplétion","Détection d''erreurs à la compilation","Intégration avec frameworks modernes"]', 5),
(1, 'SQL',        'sql',          'Langage de requête pour la gestion et manipulation de bases de données relationnelles.',
    'Langage de requête', 'Avancé', 'fas fa-database', 'https://sql.sh/',
    '["Requêtes complexes","Gestion de bases de données","Optimisation de performances","Modélisation de données"]', 6),
(1, 'Java',       'java',         'Langage orienté objet robuste, utilisé pour des applications d''entreprise et Android.',
    'Langage de programmation', 'Intermédiaire', 'fab fa-java', 'https://docs.oracle.com/en/java/',
    '["Programmation orientée objet","Applications d''entreprise","Développement Android","Portabilité multiplateforme"]', 7),
(1, 'C',          'c',            'Langage de programmation de bas niveau, offrant un contrôle précis sur le matériel.',
    'Langage de programmation', 'Intermédiaire', 'fas fa-code', 'https://devdocs.io/c/',
    '["Programmation système","Gestion de la mémoire","Performance optimale","Algorithmique"]', 8),
(1, 'Bash',       'bash',         'Shell Unix pour l''automatisation de tâches et la gestion de systèmes.',
    'Script shell', 'Intermédiaire', 'fas fa-terminal', 'https://www.gnu.org/software/bash/manual/',
    '["Automatisation de tâches","Scripts système","Gestion de fichiers","Déploiement"]', 9),
(1, 'Dart',       'dart',         'Langage optimisé pour le développement d''applications multiplateformes avec Flutter.',
    'Langage de programmation', 'Débutant', 'fas fa-code', 'https://dart.dev/guides',
    '["Applications mobiles","Flutter framework","Hot reload","Performance native"]', 10);

-- Skills : Développement Web
INSERT IGNORE INTO skills (category_id, name, slug, description, type, level, icon, doc_url, features, sort_order) VALUES
(2, 'Nuxt',      'nuxt',      'Framework Vue.js pour des applications full-stack performantes.',
    'Framework frontend', 'Intermédiaire', 'fas fa-mountain', 'https://nuxt.com/docs',
    '["Rendu SSR / SSG","Auto-import","File-based routing","Modules"]', 1),
(2, 'Vue.js',    'vuejs',     'Framework JavaScript progressif pour construire des interfaces utilisateur interactives.',
    'Framework frontend', 'Intermédiaire', 'fab fa-vuejs', 'https://vuejs.org/guide/introduction.html',
    '["Composants réactifs","Virtual DOM","Single Page Applications","Routing et state management"]', 2),
(2, 'Bootstrap', 'bootstrap', 'Framework CSS pour créer rapidement des interfaces web responsives et modernes.',
    'Framework CSS', 'Avancé', 'fab fa-bootstrap', 'https://getbootstrap.com/docs/',
    '["Design responsive","Composants prêts à l''emploi","Grille flexible","Customisation facile"]', 3),
(2, 'Node.js',   'nodejs',    'Environnement d''exécution JavaScript côté serveur, basé sur le moteur V8 de Chrome.',
    'Runtime JavaScript', 'Avancé', 'fab fa-node-js', 'https://nodejs.org/docs/latest/api/',
    '["APIs REST","Applications temps réel","Microservices","Event-driven architecture"]', 4),
(2, 'Express',   'express',   'Framework web minimaliste et flexible pour Node.js, facilitant la création d''APIs.',
    'Framework backend', 'Intermédiaire', 'fas fa-server', 'https://expressjs.com/',
    '["APIs RESTful","Middleware","Routing avancé","Gestion des requêtes HTTP"]', 5);

-- Skills : Bases de données
INSERT IGNORE INTO skills (category_id, name, slug, description, type, level, icon, doc_url, features, sort_order) VALUES
(3, 'MySQL',      'mysql',      'Système de gestion de base de données relationnelle open-source, très populaire.',
    'Base de données SQL', 'Avancé', 'fas fa-database', 'https://dev.mysql.com/doc/',
    '["Bases de données relationnelles","Transactions ACID","Réplication","Haute performance"]', 1),
(3, 'MongoDB',    'mongodb',    'Base de données NoSQL orientée documents, flexible et scalable.',
    'Base de données NoSQL', 'Intermédiaire', 'fas fa-leaf', 'https://www.mongodb.com/docs/',
    '["Documents JSON","Scalabilité horizontale","Schéma flexible","Requêtes puissantes"]', 2),
(3, 'PostgreSQL', 'postgresql', 'Système de gestion de base de données relationnelle avancé, open-source et robuste.',
    'Base de données SQL', 'Intermédiaire', 'fas fa-database', 'https://www.postgresql.org/docs/',
    '["Conformité SQL","Extensions avancées","JSON natif","Haute fiabilité"]', 3),
(3, 'ArangoDB',   'arangodb',   'Base de données multi-modèle (documents, graphes, clés/valeurs).',
    'Base de données multi-modèle', 'Débutant', 'fas fa-project-diagram', 'https://docs.arangodb.com/',
    '["Documents JSON","Requêtes AQL","Graphes natifs","Multi-modèle"]', 4);

-- Skills : Outils
INSERT IGNORE INTO skills (category_id, name, slug, description, type, level, icon, doc_url, features, sort_order) VALUES
(4, 'Git',     'git',     'Système de contrôle de version distribué pour suivre les modifications du code.',
    'Contrôle de version', 'Avancé', 'fab fa-git-alt', 'https://git-scm.com/doc',
    '["Gestion de versions","Branches et merge","Collaboration d''équipe","Historique complet"]', 1),
(4, 'Docker',  'docker',  'Plateforme de conteneurisation pour déployer des applications de manière isolée.',
    'Conteneurisation', 'Intermédiaire', 'fab fa-docker', 'https://docs.docker.com/',
    '["Conteneurs légers","Isolation d''applications","Déploiement simplifié","Orchestration"]', 2),
(4, 'VS Code', 'vscode',  'Éditeur de code source léger mais puissant, développé par Microsoft.',
    'IDE', 'Avancé', 'fas fa-code', 'https://code.visualstudio.com/docs',
    '["IntelliSense","Débogage intégré","Extensions riches","Git intégré"]', 3),
(4, 'Postman', 'postman', 'Plateforme collaborative pour tester, développer et documenter des APIs.',
    'Outil API', 'Intermédiaire', 'fas fa-paper-plane', 'https://learning.postman.com/docs/',
    '["Test d''APIs","Automatisation de tests","Documentation","Collections de requêtes"]', 4),
(4, 'Figma',   'figma',   'Outil de design collaboratif pour créer des interfaces et prototypes.',
    'Design UI/UX', 'Intermédiaire', 'fab fa-figma', 'https://help.figma.com/',
    '["Design d''interfaces","Prototypage","Collaboration temps réel","Composants réutilisables"]', 5);
