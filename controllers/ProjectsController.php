<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/settings.php';
require_once __DIR__ . '/../includes/tags.php';

class ProjectsController extends BaseController
{

    public function projects()
    {
        global $pdo;
        // `img1` est la première image de project_images, exposée sous ce nom
        // pour que le fragment de carte n'ait pas à connaître le nouveau modèle.
        $stmt = $pdo->prepare(
            "SELECT p.id, p.title, p.description, p.is_markdown, p.link, p.languages, p.categories,
                    (SELECT filename FROM project_images
                      WHERE project_id = p.id ORDER BY sort_order, id LIMIT 1) AS img1
               FROM projects p WHERE p.visibilite = 1 ORDER BY p.id DESC"
        );
        $stmt->execute();
        $projects = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Collecte la liste unique des langages pour le filtre
        $allTags = [];
        foreach ($projects as $p) {
            $tags = extractTagList($p['languages'] ?? '');
            foreach ($tags as $t) {
                $key = mb_strtolower($t);
                if (!isset($allTags[$key])) $allTags[$key] = $t;
            }
        }
        ksort($allTags);

        // Même collecte pour les catégories. On ne réutilise pas collectDistinctTags()
        // ici : elle interroge tous les projets, or cette page ne doit proposer que
        // des filtres correspondant aux projets visibles — sinon un projet masqué
        // ajouterait une puce ne ramenant jamais aucun résultat.
        $allCategories = [];
        foreach ($projects as $p) {
            foreach (extractTagList($p['categories'] ?? '') as $c) {
                $key = mb_strtolower($c);
                if (!isset($allCategories[$key])) $allCategories[$key] = $c;
            }
        }
        ksort($allCategories);

        // Pré-décoder les tags + générer un extrait plain text pour la liste
        foreach ($projects as &$p) {
            $p['tags']     = extractTagList($p['languages'] ?? '');
            $p['tags_key'] = array_map(fn($t) => mb_strtolower($t), $p['tags']);
            $p['cats']     = extractTagList($p['categories'] ?? '');
            $p['cats_key'] = array_map(fn($c) => mb_strtolower($c), $p['cats']);

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
            'projects'      => $projects,
            'allTags'       => array_values($allTags),
            'allCategories' => array_values($allCategories),
        ]);
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

        // Toutes les images du projet, dans l'ordre choisi en administration.
        // `img1` reste exposé pour les métadonnées Open Graph, qui n'ont besoin
        // que de la couverture.
        $imgStmt = $pdo->prepare(
            "SELECT filename FROM project_images WHERE project_id = :id ORDER BY sort_order, id"
        );
        $imgStmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $imgStmt->execute();
        $project['images'] = $imgStmt->fetchAll(\PDO::FETCH_COLUMN);
        $project['img1']   = $project['images'][0] ?? null;

        // Créer des meta tags personnalisés pour ce projet
        include_once __DIR__ . '/../includes/meta-config.php';

        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];

        // Image de partage : la couverture du projet, à défaut le logo du site.
        // Le repli en cascade sur img2 puis img3 n'a plus lieu d'être — la
        // couverture est simplement la première image de la liste.
        $projectImage = '/assets/img/img_logo.png';
        if (!empty($project['img1'])) {
            $projectImage = '/assets/img/projects/' . $project['img1'];
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
