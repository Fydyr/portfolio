<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/tags.php';

class AdminController extends BaseController
{
    // ===== Page administration =====
    public function admin()
    {
        $this->checkAuth();

        include_once 'includes/db.php';
        global $pdo;

        // === Stats du dashboard ===
        $stats = [
            'projects_total'   => 0,
            'projects_visible' => 0,
            'projects_hidden'  => 0,
            'skills_total'     => 0,
            'skill_cats_total' => 0,
            'passions_total'   => 0,
            'prices_total'     => 0,
            'users_total'      => 0,
            'visitors'         => 0,
            'last_migration'   => null,
            'cv_size'          => null,
            'cv_modified'      => null,
        ];

        try { $stats['projects_total']   = (int)$pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn(); } catch (Exception $e) {}
        try { $stats['projects_visible'] = (int)$pdo->query("SELECT COUNT(*) FROM projects WHERE visibilite = 1")->fetchColumn(); } catch (Exception $e) {}
        $stats['projects_hidden'] = $stats['projects_total'] - $stats['projects_visible'];

        try { $stats['skills_total']     = (int)$pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn(); } catch (Exception $e) {}
        try { $stats['skill_cats_total'] = (int)$pdo->query("SELECT COUNT(*) FROM skill_categories")->fetchColumn(); } catch (Exception $e) {}
        try { $stats['passions_total']   = (int)$pdo->query("SELECT COUNT(*) FROM passions")->fetchColumn(); } catch (Exception $e) {}
        try { $stats['prices_total']     = (int)$pdo->query("SELECT COUNT(*) FROM price_items")->fetchColumn(); } catch (Exception $e) {}
        try { $stats['users_total']      = (int)$pdo->query("SELECT COUNT(*) FROM user")->fetchColumn(); } catch (Exception $e) {}

        try {
            $row = $pdo->query("SELECT filename, applied_at FROM schema_migrations ORDER BY applied_at DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if ($row) $stats['last_migration'] = $row;
        } catch (Exception $e) {}

        // Compteur de visites (fichier texte existant)
        $counter = __DIR__ . '/../assets/docs/compteur.txt';
        if (is_file($counter)) {
            $stats['visitors'] = (int)file_get_contents($counter);
        }

        // CV
        $cvPath = __DIR__ . '/../assets/docs/mon_cv.pdf';
        if (is_file($cvPath)) {
            $stats['cv_size']     = filesize($cvPath);
            $stats['cv_modified'] = filemtime($cvPath);
        }

        // Derniers projets ajoutés
        $latestProjects = [];
        try {
            $stmt = $pdo->query("SELECT id, title, visibilite FROM projects ORDER BY id DESC LIMIT 5");
            $latestProjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {}

        // Historique des visites sur 30 jours (jours sans visite = 0)
        $visitsByDay = [];
        $visits7d    = 0;
        $visits30d   = 0;
        try {
            $rows = $pdo->query(
                "SELECT day, count FROM daily_visits
                 WHERE day >= (CURDATE() - INTERVAL 29 DAY)
                 ORDER BY day ASC"
            )->fetchAll(PDO::FETCH_ASSOC);
            $byDay = [];
            foreach ($rows as $r) {
                $byDay[$r['day']] = (int)$r['count'];
            }
            // Complète les jours manquants avec 0
            for ($i = 29; $i >= 0; $i--) {
                $day = date('Y-m-d', strtotime("-$i days"));
                $c   = $byDay[$day] ?? 0;
                $visitsByDay[$day] = $c;
                $visits30d += $c;
                if ($i < 7) $visits7d += $c;
            }
        } catch (Exception $e) {}

        echo $this->view('admin', compact('stats', 'latestProjects', 'visitsByDay', 'visits7d', 'visits30d'));
    }

    // ===== Page d'ajout de projet =====
    public function addProject()
    {
        $this->checkAuth();

        // Si c'est une requête POST, traiter le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processAddProject();
        } else {
            // Sinon, afficher le formulaire
            include_once 'includes/db.php';
            global $pdo;
            echo $this->view('add_project', [
                'knownCategories' => collectDistinctTags($pdo, 'categories'),
            ]);
        }
    }

    private function processAddProject()
    {
        try {
            // Validation des données
            $errors = $this->validateProjectData();

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
                header('Location: ' . url('admin/add-project'));
                exit;
            }

            // Préparation des données pour la base
            $projectData = [
                'title' => trim($_POST['projectName']),
                'description' => trim($_POST['projectDescription']),
                'is_markdown' => isset($_POST['is_markdown']) ? 1 : 0,
                'link' => trim($_POST['projectLink']) ?: null,
                'visibilite' => (($_POST['projectStatus'] ?? '') === 'visible') ? 1 : 0,
                'languages' => trim($_POST['projectLanguage']),
                'categories' => trim($_POST['categories'] ?? '') ?: null,
            ];

            // Insertion en base de données, puis les images : elles vivent dans
            // project_images et ont besoin de l'identifiant du projet.
            $projectId = (int)$this->insertProject($projectData);
            $this->syncProjectImages($projectId);

            // Message de succès
            $_SESSION['success'] = 'Le projet a été ajouté avec succès !';
            header('Location: ' . url('admin'));
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de l\'ajout du projet : ' . $e->getMessage();
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . url('admin/add-project'));
            exit;
        }
    }

    private function validateProjectData()
    {
        $errors = [];

        // Validation du nom du projet
        if (empty($_POST['projectName']) || strlen(trim($_POST['projectName'])) < 2) {
            $errors[] = 'Le nom du projet doit contenir au moins 2 caractères.';
        }

        // Validation de la description
        if (empty($_POST['projectDescription']) || strlen(trim($_POST['projectDescription'])) < 10) {
            $errors[] = 'La description doit contenir au moins 10 caractères.';
        }

        // Validation du lien
        if (!empty($_POST['projectLink']) && !filter_var($_POST['projectLink'], FILTER_VALIDATE_URL)) {
            $errors[] = 'Veuillez saisir un lien valide.';
        }

        // Validation des langages
        if (empty($_POST['projectLanguage'])) {
            $errors[] = 'Veuillez saisir les langages utilisés.';
        }

        return $errors;
    }

    /**
     * Aligne les images d'un projet sur ce que le formulaire a envoyé.
     *
     * Le formulaire poste `image_order` : la liste des identifiants d'images à
     * CONSERVER, dans l'ordre voulu. Une seule donnée porte donc à la fois la
     * suppression (tout ce qui n'y figure pas) et le réordonnancement — pas de
     * risque de désaccord entre deux champs.
     *
     * Les nouveaux fichiers arrivent dans `images[]` et sont ajoutés à la suite.
     * Aucun plafond : c'est tout l'objet de la table project_images.
     */
    private function syncProjectImages(int $projectId): void
    {
        include_once 'includes/db.php';
        global $pdo;

        $uploadDir = $this->projectImageDir();

        // Les nouveaux fichiers PASSENT EN PREMIER, avant la moindre écriture.
        // uploadImage() lève une exception sur un fichier trop lourd ou d'un
        // format refusé : si on téléversait en dernier, cette exception laissait
        // derrière elle des suppressions déjà validées en base et un ordre déjà
        // réécrit. Une image de 6 Mo suffisait à faire perdre les images qu'on
        // venait de retirer, pour un message d'erreur générique.
        $uploaded = $this->uploadedImageFiles($uploadDir);

        // État actuel en base : id => nom de fichier
        $stmt = $pdo->prepare("SELECT id, filename FROM project_images WHERE project_id = ?");
        $stmt->execute([$projectId]);
        $current = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $keep = array_values(array_filter(
            array_map('intval', explode(',', (string)($_POST['image_order'] ?? ''))),
            fn($id) => $id > 0
        ));
        // On n'accepte que des identifiants appartenant réellement à ce projet :
        // sans ce filtre, un identifiant forgé viserait l'image d'un autre projet.
        $owned = array_map('intval', array_keys($current));
        $keep  = array_values(array_unique(array_intersect($keep, $owned)));

        // Suppression : la ligne, puis le fichier sur le disque. basename() évite
        // qu'un nom de fichier trafiqué en base fasse sortir du dossier d'upload.
        $del = $pdo->prepare("DELETE FROM project_images WHERE id = ? AND project_id = ?");
        foreach ($current as $id => $filename) {
            if (in_array((int)$id, $keep, true)) {
                continue;
            }
            $del->execute([(int)$id, $projectId]);
            $path = $uploadDir . basename((string)$filename);
            if ($filename !== '' && is_file($path)) {
                @unlink($path);
            }
        }

        // Renumérotation dense des images conservées : 1, 2, 3…
        $upd = $pdo->prepare("UPDATE project_images SET sort_order = ? WHERE id = ? AND project_id = ?");
        foreach ($keep as $rank => $id) {
            $upd->execute([$rank + 1, $id, $projectId]);
        }

        // Ajout des nouveaux fichiers, à la suite. Ils sont déjà sur le disque :
        // il ne reste que les lignes à écrire.
        $next = count($keep) + 1;
        $ins  = $pdo->prepare("INSERT INTO project_images (project_id, filename, sort_order) VALUES (?, ?, ?)");
        foreach ($uploaded as $filename) {
            $ins->execute([$projectId, $filename, $next++]);
        }
    }

    /**
     * Dossier de destination des images, créé et rendu inscriptible au besoin.
     */
    private function projectImageDir(): string
    {
        $dir = __DIR__ . '/../assets/img/projects/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if (!is_writable($dir)) {
            @chmod($dir, 0755);
            if (!is_writable($dir)) {
                @chmod($dir, 0777);
            }
        }
        return $dir;
    }

    /**
     * Téléverse tous les fichiers reçus dans `images[]` et retourne leurs noms.
     *
     * Chaque fichier passe par uploadImage(), qui conserve les contrôles en place :
     * 5 Mo maximum, extensions autorisées, et vérification par getimagesize() que
     * le contenu est réellement une image.
     */
    private function uploadedImageFiles(string $uploadDir): array
    {
        $out = [];
        if (empty($_FILES['images']['name']) || !is_array($_FILES['images']['name'])) {
            return $out;
        }

        $count = count($_FILES['images']['name']);
        for ($i = 0; $i < $count; $i++) {
            // Un champ multiple laissé vide envoie une entrée UPLOAD_ERR_NO_FILE :
            // ce n'est pas une erreur, seulement l'absence de fichier.
            if (($_FILES['images']['error'][$i] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            if (trim((string)$_FILES['images']['name'][$i]) === '') {
                continue;
            }

            $out[] = $this->uploadImage([
                'name'     => $_FILES['images']['name'][$i],
                'tmp_name' => $_FILES['images']['tmp_name'][$i],
                'error'    => $_FILES['images']['error'][$i],
                'size'     => $_FILES['images']['size'][$i],
            ], $uploadDir);
        }

        return $out;
    }

    /**
     * Les images d'un projet, dans l'ordre d'affichage.
     */
    private function fetchProjectImages(int $projectId): array
    {
        include_once 'includes/db.php';
        global $pdo;

        $stmt = $pdo->prepare(
            "SELECT id, filename FROM project_images
              WHERE project_id = ? ORDER BY sort_order, id"
        );
        $stmt->execute([$projectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    private function uploadImage($file, $uploadDir)
    {
        // Vérification des erreurs
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Erreur lors du téléchargement de l\'image.');
        }

        // Vérification de la taille (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            throw new Exception('L\'image est trop volumineuse (max 5MB).');
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedExtensions)) {
            throw new Exception('Type d\'image non autorisé. Utilisez JPG, PNG, GIF ou WebP.');
        }

        if (function_exists('getimagesize')) {
            $imageInfo = getimagesize($file['tmp_name']);
            if ($imageInfo === false) {
                throw new Exception('Le fichier n\'est pas une image valide.');
            }

            $mimeType = $imageInfo['mime'];
            if (!in_array($mimeType, $allowedTypes)) {
                throw new Exception('Type d\'image non autorisé. Utilisez JPG, PNG, GIF ou WebP.');
            }
        }

        // Génération d'un nom unique
        $fileName = uniqid('project_') . '.' . $extension;
        $filePath = $uploadDir . $fileName;

        // Déplacement du fichier
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $fileName;
        } else {
            throw new Exception('Erreur lors de la sauvegarde de l\'image.');
        }
    }

    private function insertProject($data)
    {
        include_once 'includes/db.php';
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, is_markdown, link, visibilite, languages, categories)
                VALUES (:title, :description, :is_markdown, :link, :visibilite, :languages, :categories)");

        $result = $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':is_markdown' => $data['is_markdown'],
            ':link' => $data['link'],
            ':visibilite' => $data['visibilite'],
            ':languages' => $data['languages'],
            ':categories' => $data['categories'],
        ]);

        if (!$result) {
            throw new Exception('Erreur lors de l\'insertion en base de données.');
        }

        return $pdo->lastInsertId();
    }

    // ===== Page de liste des projets =====
    public function listProjects()
    {
        $this->checkAuth();

        // Si c'est une requête POST, traiter les actions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['projectId'])) {
                // Vérifier si c'est une suppression
                if (isset($_POST['delete']) && $_POST['delete'] == '1') {
                    $this->deleteProject();
                    return;
                }
                // Sinon c'est une modification de visibilité
                elseif (isset($_POST['visible'])) {
                    $this->toggleProjectVisibility();
                    return;
                }
            }

            // Si on arrive ici, la requête POST n'est pas valide
            $_SESSION['error'] = 'Requête invalide.';
            header('Location: ' . url('admin/projects'));
            exit;
        }

        // Affichage de la liste des projets
        try {
            include_once 'includes/db.php';
            global $pdo;

            // La vignette est la première image du projet, exposée sous le nom
            // `img1` : les vues consommatrices n'ont pas eu à changer quand les
            // colonnes img1/img2/img3 ont laissé place à la table project_images.
            $stmt = $pdo->query(
                "SELECT p.*, (SELECT filename FROM project_images
                               WHERE project_id = p.id ORDER BY sort_order, id LIMIT 1) AS img1
                   FROM projects p ORDER BY p.id DESC"
            );
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo $this->view('listProjects', ['projects' => $projects]);
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la récupération des projets : ' . $e->getMessage();
            echo $this->view('listProjects', ['projects' => []]);
        }
    }

    // Modification de la visibilité d'un projet
    public function toggleProjectVisibility()
    {
        try {
            if (!isset($_POST['projectId']) || !isset($_POST['visible'])) {
                throw new Exception('Données manquantes pour la modification de visibilité.');
            }

            include_once 'includes/db.php';
            global $pdo;

            $projectId = (int)$_POST['projectId'];
            $visibility = (int)$_POST['visible'];

            // Vérifier que le projet existe
            $checkStmt = $pdo->prepare("SELECT id FROM projects WHERE id = :id");
            $checkStmt->execute([':id' => $projectId]);

            if (!$checkStmt->fetch()) {
                throw new Exception('Le projet n\'existe pas.');
            }

            // Mettre à jour la visibilité
            $stmt = $pdo->prepare("UPDATE projects SET visibilite = :visibilite WHERE id = :id");
            $result = $stmt->execute([':visibilite' => $visibility, ':id' => $projectId]);

            if (!$result) {
                throw new Exception('Erreur lors de la mise à jour de la visibilité.');
            }

            $_SESSION['success'] = 'Visibilité du projet mise à jour avec succès.';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la modification de la visibilité : ' . $e->getMessage();
        }

        header('Location: ' . url('admin/projects'));
        exit;
    }

    // suppression d'un projet
    public function deleteProject()
    {
        try {
            if (!isset($_POST['projectId'])) {
                throw new Exception('ID du projet manquant.');
            }

            include_once 'includes/db.php';
            global $pdo;

            $projectId = (int)$_POST['projectId'];

            $stmt = $pdo->prepare("SELECT id FROM projects WHERE id = :id");
            $stmt->execute([':id' => $projectId]);
            if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
                throw new Exception('Le projet n\'existe pas.');
            }

            // Les fichiers d'abord : la clé étrangère de project_images est en
            // ON DELETE CASCADE, une fois le projet supprimé on ne saurait plus
            // quels fichiers effacer du disque.
            $this->deleteProjectImages($projectId);

            // Supprimer le projet de la base de données
            $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
            $result = $stmt->execute([':id' => $projectId]);

            if (!$result) {
                throw new Exception('Erreur lors de la suppression du projet en base de données.');
            }

            $_SESSION['success'] = 'Le projet a été supprimé avec succès.';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la suppression : ' . $e->getMessage();
        }

        header('Location: ' . url('admin/projects'));
        exit;
    }

    /**
     * Efface du disque tous les fichiers images d'un projet.
     *
     * Les lignes de project_images, elles, partent d'elles-mêmes avec le projet :
     * la clé étrangère est en ON DELETE CASCADE.
     */
    private function deleteProjectImages(int $projectId): void
    {
        $uploadDir = $this->projectImageDir();

        foreach ($this->fetchProjectImages($projectId) as $img) {
            $filePath = $uploadDir . basename((string)$img['filename']);
            if ($img['filename'] !== '' && is_file($filePath)) {
                if (!@unlink($filePath)) {
                    // On journalise sans interrompre : un fichier manquant ou
                    // verrouillé ne doit pas empêcher la suppression du projet.
                    error_log("Impossible de supprimer le fichier : " . $filePath);
                }
            }
        }
    }

    // ===== Page modification de projet =====
    public function editProject($projectId){
        $this->checkAuth();

        // Si c'est une requête POST, traiter le formulaire AVANT de charger la vue
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processEditProject($projectId);
            return; // Important : arrêter l'exécution après le traitement POST
        }

        include_once 'includes/db.php';
        global $pdo;

        // Vérifier si le projet existe
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id");
        $stmt->execute([':id' => $projectId]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$project) {
            $_SESSION['error'] = 'Le projet n\'existe pas.';
            header('Location: ' . url('admin/projects'));
            exit;
        }

        // Afficher le formulaire avec les données du projet
        echo $this->view('edit_project', [
            'project'         => $project,
            'knownCategories' => collectDistinctTags($pdo, 'categories'),
            'projectImages'   => $this->fetchProjectImages((int)$projectId),
        ]);
    }

    private function processEditProject($projectId)
    {
        try {
            include_once 'includes/db.php';
            global $pdo;

            // Récupérer les informations actuelles du projet
            $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id");
            $stmt->execute([':id' => $projectId]);
            $currentProject = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$currentProject) {
                throw new Exception('Le projet n\'existe pas.');
            }

            // Validation des données
            $errors = $this->validateEditProjectData();

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ' . url('admin/projects/edit-project/') . $projectId);
                exit;
            }

            // Préparation des données pour la base
            $projectData = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'is_markdown' => isset($_POST['is_markdown']) ? 1 : 0,
                'link' => trim($_POST['link']) ?: null,
                'visibilite' => (($_POST['projectStatus'] ?? '') === 'visible') ? 1 : 0,
                'languages' => trim($_POST['tools']),
                'categories' => trim($_POST['categories'] ?? '') ?: null,
                'id' => $projectId
            ];

            // Mise à jour en base de données, puis alignement des images
            $this->updateProject($projectData);
            $this->syncProjectImages((int)$projectId);

            // Message de succès
            $_SESSION['success'] = 'Le projet a été modifié avec succès !';
            header('Location: ' . url('admin/projects'));
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur lors de la modification du projet : ' . $e->getMessage();
            header('Location: ' . url('admin/projects/edit-project/') . $projectId);
            exit;
        }
    }

    private function validateEditProjectData()
    {
        $errors = [];

        // Validation du titre
        if (empty($_POST['title']) || strlen(trim($_POST['title'])) < 2) {
            $errors[] = 'Le titre du projet doit contenir au moins 2 caractères.';
        }

        // Validation de la description
        if (empty($_POST['description']) || strlen(trim($_POST['description'])) < 10) {
            $errors[] = 'La description doit contenir au moins 10 caractères.';
        }

        // Validation du lien
        if (!empty($_POST['link']) && !filter_var($_POST['link'], FILTER_VALIDATE_URL)) {
            $errors[] = 'Veuillez saisir un lien valide.';
        }

        // Validation des langages
        if (empty($_POST['tools'])) {
            $errors[] = 'Veuillez saisir les langages utilisés.';
        }

        return $errors;
    }

    private function updateProject($data)
    {
        include_once 'includes/db.php';
        global $pdo;

        $stmt = $pdo->prepare("UPDATE projects
            SET title = :title,
                description = :description,
                is_markdown = :is_markdown,
                link = :link,
                visibilite = :visibilite,
                languages = :languages,
                categories = :categories
            WHERE id = :id");

        $result = $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':is_markdown' => $data['is_markdown'],
            ':link' => $data['link'],
            ':visibilite' => $data['visibilite'],
            ':languages' => $data['languages'],
            ':categories' => $data['categories'],
            ':id' => $data['id']
        ]);

        if (!$result) {
            throw new Exception('Erreur lors de la mise à jour en base de données.');
        }

        return true;
    }
}
