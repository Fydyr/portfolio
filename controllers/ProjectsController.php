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

        // Déterminer la meilleure image à utiliser (essayer img1, img2, img3, puis fallback)
        $projectImage = '/assets/img/img_logo.png';
        if (!empty($project['img1'])) {
            $projectImage = $project['img1'];
        } elseif (!empty($project['img2'])) {
            $projectImage = $project['img2'];
        } elseif (!empty($project['img3'])) {
            $projectImage = $project['img3'];
        }

        // S'assurer que l'image est une URL absolue
        if (strpos($projectImage, 'http') !== 0) {
            $projectImage = $protocol . '://' . $host . $projectImage;
        }

        // Nettoyer et optimiser la description
        $cleanDescription = strip_tags($project['description']);
        $cleanDescription = preg_replace('/\s+/', ' ', $cleanDescription); // Supprimer les espaces multiples
        $cleanDescription = trim($cleanDescription);

        // Limiter à 160 caractères pour le SEO (recommandation Google)
        if (strlen($cleanDescription) > 157) {
            $cleanDescription = substr($cleanDescription, 0, 157) . '...';
        }

        // Créer les meta tags personnalisés
        $custom_meta = [
            'title' => $project['title'] . ' - Portfolio Enzo Fournier',
            'description' => $cleanDescription,
            'image' => $projectImage,
            'type' => 'article',
            'image_width' => '1200',  // Dimensions recommandées pour Open Graph
            'image_height' => '630'
        ];

        echo $this->view('projectDetail', [
            'project' => $project,
            'page_meta' => getPageMeta('project-detail', $custom_meta)
        ]);
    }
}
