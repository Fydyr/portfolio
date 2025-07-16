<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class ProjectsController extends BaseController
{

    public function projects()
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, title, description, link, img1 FROM projects WHERE visibilite = 1 ORDER BY time DESC");
        $stmt->execute();
        $projects = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->view('projects', ['projects' => $projects]);
    }
}
