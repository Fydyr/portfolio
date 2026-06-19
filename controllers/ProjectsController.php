<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/settings.php';

class ProjectsController extends BaseController
{

    public function projects()
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id, title, description, is_markdown, link, img1, languages FROM projects WHERE visibilite = 1 ORDER BY id DESC");
        $stmt->execute();
        $projects = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Collecte la liste unique des langages pour le filtre
        $allTags = [];
        foreach ($projects as $p) {
            $tags = self::extractTags($p['languages'] ?? '');
            foreach ($tags as $t) {
                $key = mb_strtolower($t);
                if (!isset($allTags[$key])) $allTags[$key] = $t;
            }
        }
        ksort($allTags);

        // Pré-décoder les tags + générer un extrait plain text pour la liste
        foreach ($projects as &$p) {
            $p['tags']     = self::extractTags($p['languages'] ?? '');
            $p['tags_key'] = array_map(fn($t) => mb_strtolower($t), $p['tags']);

            // Extrait : si markdown -> on rend puis strip tags pour l'aperçu de la carte
            $raw = $p['description'] ?? '';
            if (!empty($p['is_markdown'])) {
                $raw = strip_tags(renderMarkdown($raw));
            }
            $raw = preg_replace('/\s+/u', ' ', trim($raw));
            $p['excerpt'] = mb_strimwidth($raw, 0, 130, '...');
        }
        unset($p);

        echo $this->view('projects', [
            'projects' => $projects,
            'allTags'  => array_values($allTags),
        ]);
    }

    /**
     * Sépare la chaîne `languages` (formats possibles : "PHP, MySQL", "PHP/MySQL", etc.)
     * en un tableau propre de tags trimés et dédupliqués.
     */
    private static function extractTags(string $raw): array
    {
        $parts = preg_split('/[,;\/|]/', $raw);
        $tags = [];
        foreach ($parts as $p) {
            $p = trim($p);
            if ($p !== '') $tags[] = $p;
        }
        return array_values(array_unique($tags));
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
            $projectImage = '/assets/img/projects/' . $project['img1'];
        } elseif (!empty($project['img2'])) {
            $projectImage = '/assets/img/projects/' . $project['img2'];
        } elseif (!empty($project['img3'])) {
            $projectImage = '/assets/img/projects/' . $project['img3'];
        }

        // S'assurer que l'image est une URL absolue
        if (strpos($projectImage, 'http') !== 0) {
            $projectImage = $protocol . '://' . $host . $projectImage;
        }

        // Nettoyer la description pour le meta (toujours en texte simple, même si markdown)
        $rawDesc = $project['description'] ?? '';
        if (!empty($project['is_markdown'])) {
            $rawDesc = strip_tags(renderMarkdown($rawDesc));
        } else {
            $rawDesc = strip_tags($rawDesc);
        }
        $cleanDescription = preg_replace('/\s+/u', ' ', trim($rawDesc));
        if (mb_strlen($cleanDescription) > 157) {
            $cleanDescription = mb_substr($cleanDescription, 0, 157) . '...';
        }

        $custom_meta = [
            'title'        => $project['title'] . ' - Portfolio Enzo Fournier',
            'description'  => $cleanDescription,
            'image'        => $projectImage,
            'type'         => 'article',
            'image_width'  => '1200',
            'image_height' => '630',
        ];

        echo $this->view('projectDetail', [
            'project'       => $project,
            'page_meta'     => getPageMeta('project-detail', $custom_meta),
            'jsonLdContext' => ['project' => $project],
        ]);
    }
}
