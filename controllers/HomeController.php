<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class HomeController extends BaseController
{

    public function index()
    {
        global $pdo;

        $projectCount = (int)$pdo->query("SELECT COUNT(*) FROM projects WHERE visibilite = 1")->fetchColumn();

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

        echo $this->view('home', compact('projectCount', 'categories', 'skillsByCategory', 'passions', 'languageCount', 'jsonLdContext'));
    }
}
