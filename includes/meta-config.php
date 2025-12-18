<?php

/**
 * Configuration des meta tags SEO pour chaque page
 * Améliore le référencement et l'affichage des embeds (Discord, Twitter, etc.)
 */

// Meta tags par défaut
$default_meta = [
    'title' => 'Portfolio de Enzo Fournier',
    'description' => 'Portfolio de Enzo Fournier - Développeur web passionné. Découvrez mes projets, compétences et réalisations.',
    'image' => '/assets/img/img_logo.png',
    'type' => 'website',
    'twitter_card' => 'summary_large_image'
];

// Configuration des meta tags pour chaque page
$pages_meta = [
    'index' => [
        'title' => 'Portfolio de Enzo Fournier - Développeur Web',
        'description' => 'Bienvenue sur le portfolio de Enzo Fournier. Développeur web créatif et passionné, découvrez mon univers, mes compétences et mes réalisations.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'website'
    ],

    'projects' => [
        'title' => 'Mes Projets - Portfolio Enzo Fournier',
        'description' => 'Découvrez l\'ensemble de mes projets de développement web. Applications, sites web et créations réalisées avec passion et expertise.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'website'
    ],

    'contact' => [
        'title' => 'Me Contacter - Enzo Fournier',
        'description' => 'Vous avez un projet ou une question ? Contactez-moi pour discuter de vos besoins en développement web. Je suis disponible pour collaborer.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'website'
    ],

    'legal-mention' => [
        'title' => 'Mentions Légales - Portfolio Enzo Fournier',
        'description' => 'Informations légales concernant le site portfolio de Enzo Fournier. Mentions légales, politique de confidentialité et CGU.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'website'
    ],

    'networks' => [
        'title' => 'Mes Réseaux Sociaux - Enzo Fournier',
        'description' => 'Retrouvez-moi sur les réseaux sociaux ! Suivez mes actualités, projets et découvrez mon parcours sur différentes plateformes.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'profile'
    ],

    'price' => [
        'title' => 'Tarifs & Prestations - Enzo Fournier',
        'description' => 'Découvrez mes tarifs et prestations de développement web. Services sur mesure adaptés à vos besoins et votre budget.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'website'
    ],

    'admin' => [
        'title' => 'Administration - Portfolio Enzo',
        'description' => 'Panneau d\'administration du portfolio. Gestion des projets et du contenu.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'website'
    ],

    'login' => [
        'title' => 'Connexion - Portfolio Enzo',
        'description' => 'Connexion à l\'espace d\'administration du portfolio.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'website'
    ]
];

/**
 * Récupère les meta tags pour une page donnée
 * @param string $page_name Nom de la page
 * @param array $custom_meta Meta tags personnalisés (optionnel)
 * @return array Meta tags finaux
 */
function getPageMeta($page_name = 'index', $custom_meta = []) {
    // Définir les meta tags par défaut localement pour éviter les problèmes de scope
    $default_meta = [
        'title' => 'Portfolio de Enzo Fournier',
        'description' => 'Portfolio de Enzo Fournier - Développeur web passionné. Découvrez mes projets, compétences et réalisations.',
        'image' => '/assets/img/img_logo.png',
        'type' => 'website',
        'twitter_card' => 'summary_large_image'
    ];

    $pages_meta = [
        'index' => [
            'title' => 'Portfolio de Enzo Fournier - Développeur Web',
            'description' => 'Bienvenue sur le portfolio de Enzo Fournier. Développeur web créatif et passionné, découvrez mon univers, mes compétences et mes réalisations.',
            'image' => '/assets/img/img_logo.png',
            'type' => 'website'
        ],
        'projects' => [
            'title' => 'Mes Projets - Portfolio Enzo Fournier',
            'description' => 'Découvrez l\'ensemble de mes projets de développement web. Applications, sites web et créations réalisées avec passion et expertise.',
            'image' => '/assets/img/img_logo.png',
            'type' => 'website'
        ],
        'contact' => [
            'title' => 'Me Contacter - Enzo Fournier',
            'description' => 'Vous avez un projet ou une question ? Contactez-moi pour discuter de vos besoins en développement web. Je suis disponible pour collaborer.',
            'image' => '/assets/img/img_logo.png',
            'type' => 'website'
        ],
        'legal-mention' => [
            'title' => 'Mentions Légales - Portfolio Enzo Fournier',
            'description' => 'Informations légales concernant le site portfolio de Enzo Fournier. Mentions légales, politique de confidentialité et CGU.',
            'image' => '/assets/img/img_logo.png',
            'type' => 'website'
        ],
        'networks' => [
            'title' => 'Mes Réseaux Sociaux - Enzo Fournier',
            'description' => 'Retrouvez-moi sur les réseaux sociaux ! Suivez mes actualités, projets et découvrez mon parcours sur différentes plateformes.',
            'image' => '/assets/img/img_logo.png',
            'type' => 'profile'
        ],
        'price' => [
            'title' => 'Tarifs & Prestations - Enzo Fournier',
            'description' => 'Découvrez mes tarifs et prestations de développement web. Services sur mesure adaptés à vos besoins et votre budget.',
            'image' => '/assets/img/img_logo.png',
            'type' => 'website'
        ],
        'admin' => [
            'title' => 'Administration - Portfolio Enzo',
            'description' => 'Panneau d\'administration du portfolio. Gestion des projets et du contenu.',
            'image' => '/assets/img/img_logo.png',
            'type' => 'website'
        ],
        'login' => [
            'title' => 'Connexion - Portfolio Enzo',
            'description' => 'Connexion à l\'espace d\'administration du portfolio.',
            'image' => '/assets/img/img_logo.png',
            'type' => 'website'
        ]
    ];

    // Récupérer les meta tags de la page ou utiliser les valeurs par défaut
    $page_meta = isset($pages_meta[$page_name]) ? $pages_meta[$page_name] : $default_meta;

    // S'assurer que $page_meta est un tableau
    if (!is_array($page_meta)) {
        $page_meta = $default_meta;
    }

    // Fusionner avec les meta tags personnalisés
    $final_meta = array_merge($page_meta, $custom_meta);

    // S'assurer que l'URL est complète
    if (!isset($final_meta['url'])) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        $final_meta['url'] = $protocol . '://' . $host . $uri;
    }

    // S'assurer que l'image est une URL absolue
    if (isset($final_meta['image']) && strpos($final_meta['image'], 'http') !== 0) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $final_meta['image'] = $protocol . '://' . $host . $final_meta['image'];
    }

    // Ajouter le twitter_card par défaut si non défini
    if (!isset($final_meta['twitter_card'])) {
        $final_meta['twitter_card'] = $default_meta['twitter_card'];
    }

    return $final_meta;
}

/**
 * Fonction helper pour créer rapidement des meta tags personnalisés
 * @param string $title Titre de la page
 * @param string $description Description de la page
 * @param string $image Chemin ou URL de l'image
 * @param string $type Type de contenu (website, article, profile)
 * @return array Meta tags formatés
 */
function createCustomMeta($title, $description, $image = null, $type = 'website') {
    $meta = [
        'title' => $title,
        'description' => $description,
        'type' => $type
    ];

    if ($image !== null) {
        $meta['image'] = $image;
    }

    return $meta;
}

/**
 * Affiche les balises meta SEO
 * @param array $meta Meta tags à afficher
 */
function renderMetaTags($meta) {
    // Meta tags SEO de base
    echo '<meta name="description" content="' . htmlspecialchars($meta['description']) . '" />' . "\n    ";

    // Open Graph (Facebook, Discord, LinkedIn, etc.)
    echo '<meta property="og:title" content="' . htmlspecialchars($meta['title']) . '" />' . "\n    ";
    echo '<meta property="og:description" content="' . htmlspecialchars($meta['description']) . '" />' . "\n    ";
    echo '<meta property="og:image" content="' . htmlspecialchars($meta['image']) . '" />' . "\n    ";

    // Ajouter les dimensions de l'image si disponibles
    if (isset($meta['image_width']) && isset($meta['image_height'])) {
        echo '<meta property="og:image:width" content="' . htmlspecialchars($meta['image_width']) . '" />' . "\n    ";
        echo '<meta property="og:image:height" content="' . htmlspecialchars($meta['image_height']) . '" />' . "\n    ";
    }

    echo '<meta property="og:image:alt" content="' . htmlspecialchars($meta['title']) . '" />' . "\n    ";
    echo '<meta property="og:url" content="' . htmlspecialchars($meta['url']) . '" />' . "\n    ";
    echo '<meta property="og:type" content="' . htmlspecialchars($meta['type']) . '" />' . "\n    ";
    echo '<meta property="og:locale" content="fr_FR" />' . "\n    ";
    echo '<meta property="og:site_name" content="Portfolio Enzo Fournier" />' . "\n\n    ";

    // Twitter Card
    echo '<meta name="twitter:card" content="' . htmlspecialchars($meta['twitter_card']) . '" />' . "\n    ";
    echo '<meta name="twitter:title" content="' . htmlspecialchars($meta['title']) . '" />' . "\n    ";
    echo '<meta name="twitter:description" content="' . htmlspecialchars($meta['description']) . '" />' . "\n    ";
    echo '<meta name="twitter:image" content="' . htmlspecialchars($meta['image']) . '" />' . "\n    ";
    echo '<meta name="twitter:image:alt" content="' . htmlspecialchars($meta['title']) . '" />' . "\n    ";
    echo '<meta name="twitter:site" content="@fydyr9" />' . "\n    ";
    echo '<meta name="twitter:creator" content="@fydyr9" />' . "\n";
}
