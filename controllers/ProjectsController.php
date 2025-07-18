<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class ProjectsController extends BaseController
{

    public function projects()
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, title, description, link, img1 FROM projects WHERE visibilite = 1 ORDER BY id DESC");
        $stmt->execute();
        $projects = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->view('projects', ['projects' => $projects]);
    }

    public function projectDetail($id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id AND visibilite = 1");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $project = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$project) {
            http_response_code(404);
            echo $this->view('404');
            return;
        }

        echo $this->view('projectDetail', ['project' => $project]);
    }
}
