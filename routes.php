<?php

// Vérifier que les helpers sont chargés
if (!function_exists('view')) {
    throw new Exception('Les fonctions helpers ne sont pas chargées');
}

// Middleware admin. requireAdmin()/requireCsrf() terminent la requête (exit) :
// sans ça le routeur enchaînait sur le handler malgré la page 403 affichée.
// Note : ce middleware ne couvre pas `/admin` lui-même (pattern `/admin/.*`),
// chaque contrôleur rappelle donc la garde de son côté.
$router->before('GET|POST', '/admin/.*', function () {
    requireAdminPost();
});

// ===== SEO (sitemap + robots) =====
$router->get('/sitemap.xml', function () {
    include_once 'controllers/SeoController.php';
    (new SeoController())->sitemap();
});
$router->get('/robots.txt', function () {
    include_once 'controllers/SeoController.php';
    (new SeoController())->robots();
});

// ===== Routes principales =====

// Page d'accueil (correspond à /index.php)
$router->get('/', function () {
    include_once 'controllers/HomeController.php';
    $controller = new HomeController();
    $controller->index();
});

$router->get('/home', function () {
    include_once 'controllers/HomeController.php';
    $controller = new HomeController();
    $controller->index();
});

// Page À propos
$router->get('/about', function () {
    include_once './controllers/AboutController.php';
    (new AboutController())->index();
});

// Page des projets (correspond à /index.php/projects)
$router->get('/projects', function () {
    include_once './controllers/ProjectsController.php';
    $controller = new ProjectsController();
    $controller->projects();
});

// Détail d'un projet (correspond à /index.php/project-detail/{id})
$router->get('/project-detail/(\d+)', function ($id) {
    include_once './controllers/ProjectsController.php';
    $controller = new ProjectsController();
    $controller->projectDetail($id);
});

// Page de contact (correspond à /index.php/contact)
$router->get('/contact', function () {
    include_once './controllers/ContactController.php';
    $controller = new ContactController();
    $controller->contact();
});

// Page des mentions légales (correspond à /index.php/legals-mentions)
$router->get('/legal-mention', function () {
    include_once './controllers/LegalMentionsController.php';
    $controller = new LegalMentionsController();
    $controller->legalMentions();
});


// Page des prix des commissions (correspond à /index.php/commissions)
$router->get('/price', function () {
    include_once './controllers/OtherController.php';
    $controller = new OtherController();
    $controller->price();
});

// Page de la blague du théière (correspond à /index.php/418)
$router->get('/418', function () {
    include_once './controllers/OtherController.php';
    $controller = new OtherController();
    $controller->teapot();
});

// ===== Routes d'authentification =====

// Authentification
$router->get('/login', function () {
    include_once 'controllers/AccountController.php';
    $controller = new AccountController();
    $controller->login();
});

$router->post('/login', function () {
    include_once 'controllers/AccountController.php';
    $controller = new AccountController();
    $controller->login();
});

// Récupération de compte par code de secours (route publique)
$router->get('/recover', function () {
    include_once 'controllers/AccountController.php';
    (new AccountController())->recover();
});

$router->post('/recover', function () {
    include_once 'controllers/AccountController.php';
    (new AccountController())->recover();
});

// page de déconnexion
$router->get('/logout', function () {
    include_once 'controllers/AccountController.php';
    $controller = new AccountController();
    $controller->logout();
});

// ===== Routes d'administration =====

// Page d'administration (correspond à /index.php/admin)
$router->get('/admin', function () {
    include_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->admin();
});

// Page d'ajout de projet (correspond à /index.php/admin/add-project)
$router->get('/admin/add-project', function () {
    include_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->addProject();
});

$router->post('/admin/add-project', function () {
    include_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->addProject();
});

// page de gestion des projets (correspond à /index.php/admin/projects)
$router->get('/admin/projects', function () {
    include_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->listProjects();
});

$router->post('/admin/projects', function () {
    include_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->listProjects();
});

// Page d'édition de projet (correspond à /index.php/admin/projects/edit-project/{id})
$router->get('/admin/projects/edit-project/(\d+)', function ($id) {
    include_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->editProject($id);
});

$router->post('/admin/projects/edit-project/(\d+)', function ($id) {
    include_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->editProject($id);
});

// ===== Admin Skills =====
$router->get('/admin/skills', function () {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->index();
});
$router->get('/admin/skills/add', function () {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->editSkill(null);
});
$router->post('/admin/skills/add', function () {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->editSkill(null);
});
$router->get('/admin/skills/edit/(\d+)', function ($id) {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->editSkill($id);
});
$router->post('/admin/skills/edit/(\d+)', function ($id) {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->editSkill($id);
});
$router->post('/admin/skills/delete', function () {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->deleteSkill();
});
$router->get('/admin/skills/category/add', function () {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->editCategory(null);
});
$router->post('/admin/skills/category/add', function () {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->editCategory(null);
});
$router->get('/admin/skills/category/edit/(\d+)', function ($id) {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->editCategory($id);
});
$router->post('/admin/skills/category/edit/(\d+)', function ($id) {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->editCategory($id);
});
$router->post('/admin/skills/category/delete', function () {
    include_once 'controllers/SkillsAdminController.php';
    (new SkillsAdminController())->deleteCategory();
});

// ===== Admin Passions =====
$router->get('/admin/passions', function () {
    include_once 'controllers/PassionsAdminController.php';
    (new PassionsAdminController())->index();
});
$router->get('/admin/passions/add', function () {
    include_once 'controllers/PassionsAdminController.php';
    (new PassionsAdminController())->edit(null);
});
$router->post('/admin/passions/add', function () {
    include_once 'controllers/PassionsAdminController.php';
    (new PassionsAdminController())->edit(null);
});
$router->get('/admin/passions/edit/(\d+)', function ($id) {
    include_once 'controllers/PassionsAdminController.php';
    (new PassionsAdminController())->edit($id);
});
$router->post('/admin/passions/edit/(\d+)', function ($id) {
    include_once 'controllers/PassionsAdminController.php';
    (new PassionsAdminController())->edit($id);
});
$router->post('/admin/passions/delete', function () {
    include_once 'controllers/PassionsAdminController.php';
    (new PassionsAdminController())->delete();
});

// ===== Admin About =====
$router->get('/admin/about', function () {
    include_once 'controllers/AboutAdminController.php';
    (new AboutAdminController())->index();
});
$router->post('/admin/about/save', function () {
    include_once 'controllers/AboutAdminController.php';
    (new AboutAdminController())->saveSettings();
});
$router->get('/admin/about/section/add', function () {
    include_once 'controllers/AboutAdminController.php';
    (new AboutAdminController())->editSection(null);
});
$router->post('/admin/about/section/add', function () {
    include_once 'controllers/AboutAdminController.php';
    (new AboutAdminController())->editSection(null);
});
$router->get('/admin/about/section/edit/(\d+)', function ($id) {
    include_once 'controllers/AboutAdminController.php';
    (new AboutAdminController())->editSection($id);
});
$router->post('/admin/about/section/edit/(\d+)', function ($id) {
    include_once 'controllers/AboutAdminController.php';
    (new AboutAdminController())->editSection($id);
});
$router->post('/admin/about/section/delete', function () {
    include_once 'controllers/AboutAdminController.php';
    (new AboutAdminController())->deleteSection();
});

// ===== Admin CV =====
$router->get('/admin/cv', function () {
    include_once 'controllers/CvAdminController.php';
    (new CvAdminController())->index();
});
$router->post('/admin/cv/upload', function () {
    include_once 'controllers/CvAdminController.php';
    (new CvAdminController())->upload();
});
$router->post('/admin/cv/delete', function () {
    include_once 'controllers/CvAdminController.php';
    (new CvAdminController())->delete();
});

// ===== Admin Projets à la une =====
$router->get('/admin/featured', function () {
    include_once 'controllers/FeaturedAdminController.php';
    (new FeaturedAdminController())->index();
});
$router->post('/admin/featured/save', function () {
    include_once 'controllers/FeaturedAdminController.php';
    (new FeaturedAdminController())->save();
});

// ===== Admin Compte =====
$router->get('/admin/account', function () {
    include_once 'controllers/AccountAdminController.php';
    (new AccountAdminController())->index();
});
$router->post('/admin/account/password', function () {
    include_once 'controllers/AccountAdminController.php';
    (new AccountAdminController())->changePassword();
});
$router->post('/admin/account/recovery-codes', function () {
    include_once 'controllers/AccountAdminController.php';
    (new AccountAdminController())->generateCodes();
});

// ===== Admin Prices =====
$router->get('/admin/prices', function () {
    include_once 'controllers/PricesAdminController.php';
    (new PricesAdminController())->index();
});
$router->get('/admin/prices/add', function () {
    include_once 'controllers/PricesAdminController.php';
    (new PricesAdminController())->edit(null);
});
$router->post('/admin/prices/add', function () {
    include_once 'controllers/PricesAdminController.php';
    (new PricesAdminController())->edit(null);
});
$router->get('/admin/prices/edit/(\d+)', function ($id) {
    include_once 'controllers/PricesAdminController.php';
    (new PricesAdminController())->edit($id);
});
$router->post('/admin/prices/edit/(\d+)', function ($id) {
    include_once 'controllers/PricesAdminController.php';
    (new PricesAdminController())->edit($id);
});
$router->post('/admin/prices/delete', function () {
    include_once 'controllers/PricesAdminController.php';
    (new PricesAdminController())->delete();
});

// ==== Routes de debug ====
// /test et /debug ont été supprimées : publiques, elles exposaient REQUEST_URI,
// SCRIPT_NAME et REQUEST_METHOD sans échappement (fuite d'infos + puits XSS).

// ==== 404 ====
$router->set404(function () {
    header('HTTP/1.1 404 Not Found');
    echo view('404', ['title' => '404 - Page non trouvée']);
});