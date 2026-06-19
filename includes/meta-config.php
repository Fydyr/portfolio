<?php
/**
 * Meta tags SEO / Open Graph / Twitter / JSON-LD.
 *
 * - getPageMeta($pageName, $customMeta) : retourne le tableau de meta pour une page
 * - renderMetaTags($meta) : émet les <meta> dans <head>
 * - renderJsonLd($pageName, $context) : émet le bloc Schema.org JSON-LD
 *
 * Les pages dynamiques (projet, etc.) peuvent passer un $customMeta avec
 * une image, un type article, etc., qui surchargent les valeurs par défaut.
 */

const SITE_NAME       = 'Portfolio Enzo Fournier';
const SITE_AUTHOR     = 'Enzo Fournier';
const SITE_TWITTER    = '@fydyr9';
const SITE_LOCALE     = 'fr_FR';
const SITE_DEFAULT_OG = '/assets/img/img_logo.png';

/**
 * Calcule l'URL absolue du site (sans path).
 */
function siteBaseUrl(): string
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $protocol . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
}

/**
 * Convertit une URL relative ou un chemin en URL absolue.
 */
function absoluteUrl(string $path): string
{
    if (strpos($path, 'http') === 0) return $path;
    if ($path === '' || $path[0] !== '/') $path = '/' . $path;
    return siteBaseUrl() . $path;
}

/**
 * Catalogue des meta par page. Edite ici pour ajuster les descriptions/titres.
 */
function pagesMetaCatalog(): array
{
    return [
        'index' => [
            'title'       => 'Enzo Fournier - Développeur Web & Étudiant BUT Informatique',
            'description' => "Portfolio d'Enzo Fournier, étudiant en 3e année de BUT Informatique passionné par le développement web backend et la création d'applications. Découvrez mon parcours, mes compétences et mes projets.",
            'type'        => 'profile',
        ],
        'home' => [
            'title'       => 'Enzo Fournier - Développeur Web & Étudiant BUT Informatique',
            'description' => "Portfolio d'Enzo Fournier, étudiant en 3e année de BUT Informatique passionné par le développement web backend et la création d'applications.",
            'type'        => 'profile',
        ],
        'projects' => [
            'title'       => 'Mes projets - Portfolio Enzo Fournier',
            'description' => "Tous les projets web, applications et créations que j'ai réalisés en personnel ou pendant mon BUT Informatique. Technologies, captures et code source.",
            'type'        => 'website',
        ],
        'about' => [
            'title'       => 'À propos - Enzo Fournier',
            'description' => "Étudiant en BUT Informatique, développeur web backend. Mon parcours, mes compétences, mes derniers projets GitHub et ce qui me motive.",
            'type'        => 'profile',
        ],
        'contact' => [
            'title'       => 'Me contacter - Enzo Fournier',
            'description' => "Une question, un projet, une opportunité de stage ou d'alternance ? Contactez-moi directement via le formulaire ou sur mes réseaux.",
            'type'        => 'website',
        ],
        'legal-mention' => [
            'title'       => 'Mentions légales - Portfolio Enzo Fournier',
            'description' => "Mentions légales du portfolio d'Enzo Fournier : éditeur, hébergement, propriété intellectuelle et protection des données.",
            'type'        => 'website',
        ],
        'price' => [
            'title'       => 'Tarifs & prestations - Enzo Fournier',
            'description' => "Tarifs de mes prestations de développement web : sites vitrine, portfolios, applications mobiles, refonte et maintenance. Devis personnalisés sur demande.",
            'type'        => 'website',
        ],
        'login' => [
            'title'       => 'Connexion - ' . SITE_NAME,
            'description' => "Espace d'administration du portfolio.",
            'type'        => 'website',
            'noindex'     => true,
        ],
        'admin' => [
            'title'       => 'Administration - ' . SITE_NAME,
            'description' => "Panneau d'administration.",
            'type'        => 'website',
            'noindex'     => true,
        ],
    ];
}

/**
 * Retourne les meta finaux pour une page, fusionnés avec d'éventuels customs (projet, etc.).
 */
function getPageMeta(string $page = 'index', array $custom = []): array
{
    $defaults = [
        'title'        => SITE_NAME,
        'description'  => SITE_NAME . " - développeur web passionné.",
        'image'        => SITE_DEFAULT_OG,
        'type'         => 'website',
        'twitter_card' => 'summary_large_image',
        'noindex'      => false,
    ];

    $catalog = pagesMetaCatalog();
    $base = $catalog[$page] ?? [];
    $meta = array_merge($defaults, $base, $custom);

    // URL canonique = URL courante (sans query string)
    if (empty($meta['url'])) {
        $path = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
        $meta['url'] = siteBaseUrl() . $path;
    }

    // image -> URL absolue
    $meta['image'] = absoluteUrl($meta['image']);

    return $meta;
}

/**
 * Conserve la signature historique createCustomMeta().
 */
function createCustomMeta(string $title, string $description, ?string $image = null, string $type = 'website'): array
{
    $m = ['title' => $title, 'description' => $description, 'type' => $type];
    if ($image !== null) $m['image'] = $image;
    return $m;
}

/**
 * Émet les balises <meta>.
 */
function renderMetaTags(array $meta): void
{
    $esc = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');

    echo '<meta name="description" content="' . $esc($meta['description']) . '">' . "\n";
    echo '<meta name="author" content="' . $esc(SITE_AUTHOR) . '">' . "\n";
    echo '<link rel="canonical" href="' . $esc($meta['url']) . '">' . "\n";

    if (!empty($meta['noindex'])) {
        echo '<meta name="robots" content="noindex,nofollow">' . "\n";
    } else {
        echo '<meta name="robots" content="index,follow">' . "\n";
    }

    // Open Graph
    echo '<meta property="og:site_name" content="' . $esc(SITE_NAME) . '">' . "\n";
    echo '<meta property="og:locale" content="' . $esc(SITE_LOCALE) . '">' . "\n";
    echo '<meta property="og:type" content="' . $esc($meta['type']) . '">' . "\n";
    echo '<meta property="og:title" content="' . $esc($meta['title']) . '">' . "\n";
    echo '<meta property="og:description" content="' . $esc($meta['description']) . '">' . "\n";
    echo '<meta property="og:url" content="' . $esc($meta['url']) . '">' . "\n";
    echo '<meta property="og:image" content="' . $esc($meta['image']) . '">' . "\n";
    echo '<meta property="og:image:alt" content="' . $esc($meta['title']) . '">' . "\n";

    if (!empty($meta['image_width']) && !empty($meta['image_height'])) {
        echo '<meta property="og:image:width" content="' . $esc($meta['image_width']) . '">' . "\n";
        echo '<meta property="og:image:height" content="' . $esc($meta['image_height']) . '">' . "\n";
    }

    if (!empty($meta['article_published_time'])) {
        echo '<meta property="article:published_time" content="' . $esc($meta['article_published_time']) . '">' . "\n";
    }
    if (!empty($meta['article_author'])) {
        echo '<meta property="article:author" content="' . $esc($meta['article_author']) . '">' . "\n";
    }

    // Twitter
    echo '<meta name="twitter:card" content="' . $esc($meta['twitter_card']) . '">' . "\n";
    echo '<meta name="twitter:site" content="' . $esc(SITE_TWITTER) . '">' . "\n";
    echo '<meta name="twitter:creator" content="' . $esc(SITE_TWITTER) . '">' . "\n";
    echo '<meta name="twitter:title" content="' . $esc($meta['title']) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . $esc($meta['description']) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . $esc($meta['image']) . '">' . "\n";
    echo '<meta name="twitter:image:alt" content="' . $esc($meta['title']) . '">' . "\n";
}

/**
 * Émet le bloc JSON-LD Schema.org en fonction de la page.
 *  - Person sur l'accueil
 *  - CreativeWork sur un détail de projet (via $context['project'])
 *  - BreadcrumbList sur projects/contact/legal/price
 */
function renderJsonLd(string $page, array $context = []): void
{
    $base = siteBaseUrl();
    $blocks = [];

    if (in_array($page, ['index', 'home'], true)) {
        $blocks[] = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Person',
            'name'        => SITE_AUTHOR,
            'url'         => $base . '/',
            'image'       => absoluteUrl(SITE_DEFAULT_OG),
            'jobTitle'    => 'Étudiant en BUT Informatique',
            'description' => "Étudiant en 3e année de BUT Informatique, développeur web backend et créateur d'applications.",
            'sameAs'      => [
                'https://github.com/Fydyr',
                'https://www.linkedin.com/in/enzo-fournier-2746ba2b3/',
            ],
            'knowsAbout' => $context['skills_names'] ?? [],
            'alumniOf'   => [
                '@type' => 'CollegeOrUniversity',
                'name'  => 'IUT de Calais - BUT Informatique',
            ],
        ];
        $blocks[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => SITE_NAME,
            'url'      => $base . '/',
            'inLanguage' => 'fr-FR',
        ];
    }

    if ($page === 'project-detail' && !empty($context['project'])) {
        $p = $context['project'];
        $img = !empty($p['img1']) ? absoluteUrl('/assets/img/projects/' . $p['img1']) : absoluteUrl(SITE_DEFAULT_OG);
        $blocks[] = [
            '@context'    => 'https://schema.org',
            '@type'       => 'CreativeWork',
            'name'        => $p['title'] ?? '',
            'description' => strip_tags($p['description'] ?? ''),
            'image'       => $img,
            'url'         => $base . '/project-detail/' . ($p['id'] ?? ''),
            'author'      => ['@type' => 'Person', 'name' => SITE_AUTHOR],
            'keywords'    => $p['languages'] ?? null,
        ];
    }

    // Fil d'Ariane pour les pages secondaires
    $breadcrumbs = [
        'projects'      => [['Accueil', '/'], ['Projets', '/projects']],
        'contact'       => [['Accueil', '/'], ['Contact', '/contact']],
        'legal-mention' => [['Accueil', '/'], ['Mentions légales', '/legal-mention']],
        'price'         => [['Accueil', '/'], ['Tarifs', '/price']],
    ];
    if (isset($breadcrumbs[$page])) {
        $items = [];
        foreach ($breadcrumbs[$page] as $i => [$name, $path]) {
            $items[] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $name,
                'item'     => $base . $path,
            ];
        }
        $blocks[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }

    if ($page === 'project-detail' && !empty($context['project'])) {
        $blocks[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => $base . '/'],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Projets', 'item' => $base . '/projects'],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $context['project']['title'] ?? '', 'item' => $base . '/project-detail/' . ($context['project']['id'] ?? '')],
            ],
        ];
    }

    foreach ($blocks as $b) {
        echo '<script type="application/ld+json">' . "\n";
        echo json_encode($b, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n" . '</script>' . "\n";
    }
}
