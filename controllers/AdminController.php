<?php

require_once 'BaseController.php';

class AdminController extends BaseController
{
    // ===== Page administration =====
    public function admin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 403 Forbidden');
            echo view('403', ['title' => '403 - Accès interdit']);
            exit;
        } else {
            echo $this->view('admin');
        }
    }

    // ===== Page d'ajout de projet =====
    public function addProject()
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 403 Forbidden');
            echo view('403', ['title' => '403 - Accès interdit']);
            exit;
        }

        // Si c'est une requête POST, traiter le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processAddProject();
        } else {
            // Sinon, afficher le formulaire
            echo $this->view('add_project');
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

            // Traitement des images
            $imageFiles = $this->processImages();

            // Préparation des données pour la base
            $projectData = [
                'title' => trim($_POST['projectName']),
                'description' => trim($_POST['projectDescription']),
                'link' => trim($_POST['projectLink']) ?: null,
                'img1' => $imageFiles[0] ?? null,
                'img2' => $imageFiles[1] ?? null,
                'img3' => $imageFiles[2] ?? null,
                'visibilite' => ($_POST['projectStatus'] === 'visible') ? 1 : 0,
                'languages' => trim($_POST['projectLanguage']),
            ];

            // Insertion en base de données
            $this->insertProject($projectData);

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

    private function processImages()
    {

        $uploadDir = __DIR__ . '/../assets/img/projects/';

        // Vérifie si le dossier est accessible en écriture
        if (!is_writable($uploadDir)) {
            // Tente de changer les permissions à 0755
            if (!chmod($uploadDir, 0755)) {
                // Si échec, tente 0777
                if (!chmod($uploadDir, 0777)) {
                    die("Erreur : Le dossier '$uploadDir' n'est pas accessible en écriture et les permissions n'ont pas pu être modifiées.");
                }
            }
        }


        $uploadedFiles = [];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/projects/';

        // Créer le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Traitement des 3 images possibles
        for ($i = 0; $i < 3; $i++) {
            if (isset($_FILES['projectImage']['name'][$i]) && !empty($_FILES['projectImage']['name'][$i])) {
                $file = [
                    'name' => $_FILES['projectImage']['name'][$i],
                    'tmp_name' => $_FILES['projectImage']['tmp_name'][$i],
                    'error' => $_FILES['projectImage']['error'][$i],
                    'size' => $_FILES['projectImage']['size'][$i]
                ];

                $uploadedFile = $this->uploadImage($file, $uploadDir);
                if ($uploadedFile) {
                    $uploadedFiles[] = $uploadedFile;
                }
            }
        }

        return $uploadedFiles;
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
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, link, img1, img2, img3, visibilite, languages) 
                VALUES (:title, :description, :link, :img1, :img2, :img3, :visibilite, :languages)");

        $result = $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':link' => $data['link'],
            ':img1' => $data['img1'],
            ':img2' => $data['img2'],
            ':img3' => $data['img3'],
            ':visibilite' => $data['visibilite'],
            ':languages' => $data['languages'],
        ]);

        if (!$result) {
            throw new Exception('Erreur lors de l\'insertion en base de données.');
        }

        return $pdo->lastInsertId();
    }

    // ===== Page de liste des projets =====
    public function listProjects()
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 403 Forbidden');
            echo view('403', ['title' => '403 - Accès interdit']);
            exit;
        }

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

            $stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
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

            // Récupérer les informations du projet avant suppression
            $stmt = $pdo->prepare("SELECT img1, img2, img3 FROM projects WHERE id = :id");
            $stmt->execute([':id' => $projectId]);
            $project = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$project) {
                throw new Exception('Le projet n\'existe pas.');
            }

            // Supprimer les images du projet
            $this->deleteProjectImages($project);

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

    private function deleteProjectImages($project)
    {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/projects/';

        foreach (['img1', 'img2', 'img3'] as $imgField) {
            if (!empty($project[$imgField])) {
                $filePath = $uploadDir . $project[$imgField];
                if (file_exists($filePath)) {
                    if (!unlink($filePath)) {
                        // Log l'erreur mais ne pas interrompre le processus
                        error_log("Impossible de supprimer le fichier : " . $filePath);
                    }
                }
            }
        }
    }
}
