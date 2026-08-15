<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/settings.php';
require_once __DIR__ . '/../includes/tags.php';

class HomeController extends BaseController
{

    public function index()
    {
        global $pdo;

        $projectCount = (int)$pdo->query("SELECT COUNT(*) FROM projects WHERE visibilite = 1")->fetchColumn();

        // Projets mis en avant depuis /admin/featured, dans l'ordre choisi.
        // Mêmes clés que ProjectsController::projects() : la carte est un partial
        // partagé, elle doit recevoir exactement la même forme des deux côtés.
        // `img1` est la première image de project_images, exposée sous ce nom
        // pour que le fragment de carte n'ait pas à connaître le nouveau modèle.
        $cols = "p.id, p.title, p.description, p.is_markdown, p.languages, p.categories,
                 (SELECT filename FROM project_images
                   WHERE project_id = p.id ORDER BY sort_order, id LIMIT 1) AS img1";

        $recentProjects = $pdo->query(
            "SELECT $cols FROM projects p
              WHERE p.visibilite = 1 AND p.home_position IS NOT NULL
              ORDER BY p.home_position"
        )->fetchAll(\PDO::FETCH_ASSOC);

        // Repli sur les 3 plus récents tant qu'aucun projet n'a été mis en avant.
        // Sans ça, la section serait vide avant la première configuration — et le
        // repli couvre aussi le cas où tous les projets à la une sont masqués.
        if (empty($recentProjects)) {
            $recentProjects = $pdo->query(
                "SELECT $cols FROM projects p
                  WHERE p.visibilite = 1 ORDER BY p.id DESC LIMIT 3"
            )->fetchAll(\PDO::FETCH_ASSOC);
        }

        foreach ($recentProjects as &$rp) {
            $rp['tags'] = extractTagList($rp['languages'] ?? '');
            $rp['cats'] = extractTagList($rp['categories'] ?? '');

            $raw = $rp['description'] ?? '';
            if (!empty($rp['is_markdown'])) {
                $raw = strip_tags(renderMarkdown($raw));
            }
            $raw = preg_replace('/\s+/u', ' ', trim($raw));
            $rp['excerpt'] = mb_strimwidth($raw, 0, 130, '...');
        }
        unset($rp);

        // Catégories visibles + leurs skills visibles
        $categories = $pdo->query(
            "SELECT * FROM skill_categories WHERE visible = 1 ORDER BY sort_order, name"
        )->fetchAll(\PDO::FETCH_ASSOC);

        $skillsStmt = $pdo->query(
            "SELECT * FROM skills WHERE visible = 1 ORDER BY category_id, sort_order, name"
        );
        $skillsByCategory = [];
        foreach ($skillsStmt->fetchAll(\PDO::FETCH_ASSOC) as $s) {
            $s['features_decoded'] = !empty($s['features']) ? (json_decode($s['features'], true) ?: []) : [];
            $skillsByCategory[(int)$s['category_id']][] = $s;
        }

        // Passions visibles
        $passions = $pdo->query(
            "SELECT * FROM passions WHERE visible = 1 ORDER BY sort_order, name"
        )->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($passions as &$p) {
            $p['likes_decoded'] = !empty($p['likes']) ? (json_decode($p['likes'], true) ?: []) : [];
        }
        unset($p);

        // Compteur de langages (pour la stat sur le hero)
        $languageCount = 0;
        foreach ($categories as $cat) {
            if (strcasecmp($cat['name'], 'Langages') === 0) {
                $languageCount = count($skillsByCategory[(int)$cat['id']] ?? []);
                break;
            }
        }

        // Liste plate des noms de skills (pour JSON-LD Person.knowsAbout)
        $skillNames = [];
        foreach ($skillsByCategory as $list) {
            foreach ($list as $s) $skillNames[] = $s['name'];
        }
        $jsonLdContext = ['skills_names' => $skillNames];

        echo $this->view('home', compact('projectCount', 'recentProjects', 'categories', 'skillsByCategory', 'passions', 'languageCount', 'jsonLdContext'));
    }
}
