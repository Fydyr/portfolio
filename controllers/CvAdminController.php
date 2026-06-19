<?php

require_once 'BaseController.php';

class CvAdminController extends BaseController
{
    private const CV_DIR  = __DIR__ . '/../assets/docs';
    private const CV_NAME = 'mon_cv.pdf';

    private function checkAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('HTTP/1.1 403 Forbidden');
            echo view('403', ['title' => '403 - Accès interdit']);
            exit;
        }
    }

    public function index(): void
    {
        $this->checkAuth();

        $cvPath = self::CV_DIR . '/' . self::CV_NAME;
        $cv = is_file($cvPath) ? [
            'exists'   => true,
            'size'     => filesize($cvPath),
            'modified' => filemtime($cvPath),
        ] : ['exists' => false];

        echo $this->view('admin_cv', compact('cv'));
    }

    public function upload(): void
    {
        $this->checkAuth();

        try {
            if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Aucun fichier reçu (ou erreur durant l\'upload).');
            }
            $file = $_FILES['cv'];

            // 10 Mo max
            if ($file['size'] > 10 * 1024 * 1024) {
                throw new Exception('Fichier trop volumineux (10 Mo max).');
            }

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if ($ext !== 'pdf') {
                throw new Exception('Seul le format PDF est accepté.');
            }

            // Vérification MIME (basée sur les bytes du fichier, pas sur l'extension)
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);
            if ($mime !== 'application/pdf') {
                throw new Exception('Le fichier n\'est pas un PDF valide (MIME: ' . htmlspecialchars($mime) . ').');
            }

            if (!is_dir(self::CV_DIR)) {
                mkdir(self::CV_DIR, 0775, true);
            }
            $target = self::CV_DIR . '/' . self::CV_NAME;

            if (!move_uploaded_file($file['tmp_name'], $target)) {
                throw new Exception('Erreur lors de l\'écriture du fichier.');
            }
            @chmod($target, 0644);

            $_SESSION['success'] = 'CV mis à jour avec succès.';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ' . url('admin/cv'));
        exit;
    }

    public function delete(): void
    {
        $this->checkAuth();

        $cvPath = self::CV_DIR . '/' . self::CV_NAME;
        if (is_file($cvPath)) {
            if (@unlink($cvPath)) {
                $_SESSION['success'] = 'CV supprimé.';
            } else {
                $_SESSION['error'] = 'Impossible de supprimer le fichier.';
            }
        } else {
            $_SESSION['error'] = 'Aucun CV à supprimer.';
        }

        header('Location: ' . url('admin/cv'));
        exit;
    }
}
