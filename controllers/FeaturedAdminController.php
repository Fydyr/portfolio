<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

/**
 * Choix et ordre des projets mis en avant sur la page d'accueil.
 *
 * L'ordre est porté par `projects.home_position` : NULL pour un projet absent
 * de la une, un entier pour son rang. Cette page réécrit la colonne entière à
 * chaque enregistrement, ce qui garantit une numérotation dense (1, 2, 3…) sans
 * trou ni doublon, quoi qu'il arrive côté navigateur.
 */
class FeaturedAdminController extends BaseController
{
    public function index()
    {
        requireAdmin();
        global $pdo;

        $featured = $pdo->query(
            "SELECT id, title, visibilite, home_position
               FROM projects WHERE home_position IS NOT NULL
              ORDER BY home_position"
        )->fetchAll(\PDO::FETCH_ASSOC);

        $others = $pdo->query(
            "SELECT id, title, visibilite
               FROM projects WHERE home_position IS NULL
              ORDER BY id DESC"
        )->fetchAll(\PDO::FETCH_ASSOC);

        echo $this->view('admin_featured', compact('featured', 'others'));
    }

    public function save()
    {
        requireAdmin();
        global $pdo;

        // Le formulaire poste une liste d'identifiants séparés par des virgules,
        // dans l'ordre d'affichage voulu.
        $raw = (string)($_POST['order'] ?? '');
        $ids = array_values(array_unique(array_filter(
            array_map('intval', explode(',', $raw)),
            fn($id) => $id > 0
        )));

        // On n'écrit que sur des projets réellement existants. Sans ce filtre, un
        // identifiant forgé ferait tourner des UPDATE dans le vide et décalerait
        // silencieusement la numérotation des suivants.
        if ($ids) {
            $in    = implode(',', array_fill(0, count($ids), '?'));
            $stmt  = $pdo->prepare("SELECT id FROM projects WHERE id IN ($in)");
            $stmt->execute($ids);
            $valid = array_map('intval', $stmt->fetchAll(\PDO::FETCH_COLUMN));
            $ids   = array_values(array_filter($ids, fn($id) => in_array($id, $valid, true)));
        }

        $pdo->beginTransaction();
        try {
            // Table rase puis renumérotation : plus simple et plus sûr qu'un
            // calcul de différences, et la position reste dense.
            $pdo->exec("UPDATE projects SET home_position = NULL");

            if ($ids) {
                $upd = $pdo->prepare("UPDATE projects SET home_position = ? WHERE id = ?");
                foreach ($ids as $rank => $id) {
                    $upd->execute([$rank + 1, $id]);
                }
            }
            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }

        $n = count($ids);
        flash('success', $n === 0
            ? "Aucun projet à la une : l'accueil affichera les 3 plus récents."
            : "$n projet(s) à la une enregistré(s).");
        redirect('admin/featured');
    }
}
