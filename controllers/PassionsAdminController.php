<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class PassionsAdminController extends BaseController
{
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
        global $pdo;
        $passions = $pdo->query("SELECT * FROM passions ORDER BY sort_order, name")->fetchAll(PDO::FETCH_ASSOC);
        echo $this->view('admin_passions', compact('passions'));
    }

    public function edit($id = null): void
    {
        $this->checkAuth();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $likesRaw = trim($_POST['likes'] ?? '');
            $likes = $likesRaw === ''
                ? null
                : json_encode(array_values(array_filter(array_map('trim', explode("\n", $likesRaw)))), JSON_UNESCAPED_UNICODE);

            $data = [
                ':slug'              => trim($_POST['slug'] ?? ''),
                ':name'              => trim($_POST['name'] ?? ''),
                ':short_description' => trim($_POST['short_description'] ?? '') ?: null,
                ':long_description'  => trim($_POST['long_description'] ?? '') ?: null,
                ':why'               => trim($_POST['why'] ?? '') ?: null,
                ':icon'              => trim($_POST['icon'] ?? '') ?: null,
                ':likes'             => $likes,
                ':sort_order'        => (int)($_POST['sort_order'] ?? 0),
                ':visible'           => isset($_POST['visible']) ? 1 : 0,
            ];

            if ($id === null) {
                $sql = "INSERT INTO passions (slug, name, short_description, long_description, why, icon, likes, sort_order, visible)
                        VALUES (:slug, :name, :short_description, :long_description, :why, :icon, :likes, :sort_order, :visible)";
            } else {
                $sql = "UPDATE passions SET slug=:slug, name=:name, short_description=:short_description,
                        long_description=:long_description, why=:why, icon=:icon, likes=:likes, sort_order=:sort_order,
                        visible=:visible WHERE id=:id";
                $data[':id'] = (int)$id;
            }

            try {
                $pdo->prepare($sql)->execute($data);
                $_SESSION['success'] = $id === null ? 'Passion ajoutée.' : 'Passion modifiée.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            }
            header('Location: ' . url('admin/passions'));
            exit;
        }

        $passion = null;
        if ($id !== null) {
            $stmt = $pdo->prepare("SELECT * FROM passions WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $passion = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$passion) {
                $_SESSION['error'] = 'Passion introuvable.';
                header('Location: ' . url('admin/passions'));
                exit;
            }
        }
        echo $this->view('admin_passion_edit', compact('passion'));
    }

    public function delete(): void
    {
        $this->checkAuth();
        global $pdo;
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("DELETE FROM passions WHERE id = :id")->execute([':id' => $id]);
            $_SESSION['success'] = 'Passion supprimée.';
        }
        header('Location: ' . url('admin/passions'));
        exit;
    }
}
