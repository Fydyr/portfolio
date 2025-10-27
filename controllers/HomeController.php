<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class HomeController extends BaseController
{

    public function index()
    {
        global $pdo;

        // Compter le nombre de projets visibles
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM projects WHERE visibilite = 1");
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $projectCount = $result['total'];

        echo $this->view('home', ['projectCount' => $projectCount]);
    }
}
