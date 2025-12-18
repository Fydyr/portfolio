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

        // Créer des meta tags personnalisés pour ce projet
        include_once __DIR__ . '/../includes/meta-config.php';

        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $projectImage = !empty($project['img1']) ? $project['img1'] : '/assets/img/img_logo.png';

        // S'assurer que l'image est une URL absolue
        if (strpos($projectImage, 'http') !== 0) {
            $projectImage = $protocol . '://' . $host . $projectImage;
        }

        $custom_meta = [
            'title' => $project['title'] . ' - Portfolio Enzo Fournier',
            'description' => substr(strip_tags($project['description']), 0, 160) . '...',
            'image' => $projectImage,
            'type' => 'article'
        ];

        echo $this->view('projectDetail', [
            'project' => $project,
            'page_meta' => getPageMeta('project-detail', $custom_meta)
        ]);
    }
}
