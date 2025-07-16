<?php

// Vérifier que les helpers sont chargés
if (!function_exists('view')) {
    throw new Exception('Les fonctions helpers ne sont pas chargées');
}

// Middleware admin
$router->before('GET|POST', '/admin/.*', function () {
    if (!isset($_SESSION['user_id'])) {
        flash('error', 'Accès non autorisé');
        redirect('login');
    }
});

// Page d'accueil (correspond à /index.php)
$router->get('/', function () {
    include_once 'controllers/HomeController.php';
    $controller = new HomeController();
    $controller->index();
});

// Page des projets (correspond à /index.php/projects)
$router->get('/projects', function () {
    include_once './controllers/ProjectsController.php';
    $controller = new ProjectsController();
    $controller->projects();
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

// page de déconnexion
$router->get('/logout', function () {
    include_once 'controllers/AccountController.php';
    $controller = new AccountController();
    $controller->logout();
});

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

// ==== Routes de test =====
$router->get('/test', function () {
    echo "<h1>✅ Test route fonctionne !</h1>";
    echo "<p><strong>URL:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";
    echo "<p><strong>Base path configuré:</strong> /index.php</p>";
    echo "<p><a href='" . url('') . "'>Retour accueil</a></p>";
});

$router->get('/debug', function () {
    echo "<h1>🐛 Debug Router</h1>";
    echo "<div style='background: #f0f0f0; padding: 1rem; font-family: monospace;'>";
    echo "<strong>REQUEST_URI:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
    echo "<strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "<br>";
    echo "<strong>REQUEST_METHOD:</strong> " . $_SERVER['REQUEST_METHOD'] . "<br>";
    echo "<strong>Base path Bramus:</strong> /index.php<br>";
    echo "</div>";
    echo "<h3>🧪 Tests :</h3>";
    echo "<ul>";
    echo "<li><a href='" . url('') . "'>Accueil</a></li>";
    echo "<li><a href='" . url('test') . "'>Test</a></li>";
    echo "<li><a href='" . url('contact') . "'>Contact</a></li>";
    echo "</ul>";
});

// ==== 404 ====
$router->set404(function () {
    header('HTTP/1.1 404 Not Found');
    echo view('404', ['title' => '404 - Page non trouvée']);
});