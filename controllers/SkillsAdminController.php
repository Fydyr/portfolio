<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class SkillsAdminController extends BaseController
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
        $categories = $pdo->query("SELECT * FROM skill_categories ORDER BY sort_order, name")->fetchAll(PDO::FETCH_ASSOC);
        $skills = $pdo->query("SELECT * FROM skills ORDER BY category_id, sort_order, name")->fetchAll(PDO::FETCH_ASSOC);
        echo $this->view('admin_skills', compact('categories', 'skills'));
    }

    public function editSkill($id = null): void
    {
        $this->checkAuth();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveSkill($id);
            return;
        }

        $skill = null;
        if ($id !== null) {
            $stmt = $pdo->prepare("SELECT * FROM skills WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $skill = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$skill) {
                $_SESSION['error'] = 'Skill introuvable.';
                header('Location: ' . url('admin/skills'));
                exit;
            }
        }

        $categories = $pdo->query("SELECT * FROM skill_categories ORDER BY sort_order, name")->fetchAll(PDO::FETCH_ASSOC);
        echo $this->view('admin_skill_edit', compact('skill', 'categories'));
    }

    private function saveSkill($id): void
    {
        global $pdo;
        try {
            $featuresRaw = trim($_POST['features'] ?? '');
            $features = $featuresRaw === ''
                ? null
                : json_encode(array_values(array_filter(array_map('trim', explode("\n", $featuresRaw)))), JSON_UNESCAPED_UNICODE);

            $data = [
                ':category_id' => (int)($_POST['category_id'] ?? 0),
                ':name'        => trim($_POST['name'] ?? ''),
                ':slug'        => trim($_POST['slug'] ?? ''),
                ':description' => trim($_POST['description'] ?? '') ?: null,
                ':type'        => trim($_POST['type'] ?? '') ?: null,
                ':level'       => trim($_POST['level'] ?? '') ?: 'Intermédiaire',
                ':icon'        => trim($_POST['icon'] ?? '') ?: null,
                ':doc_url'     => trim($_POST['doc_url'] ?? '') ?: null,
                ':features'    => $features,
                ':sort_order'  => (int)($_POST['sort_order'] ?? 0),
                ':visible'     => isset($_POST['visible']) ? 1 : 0,
            ];

            if ($id === null) {
                $sql = "INSERT INTO skills (category_id, name, slug, description, type, level, icon, doc_url, features, sort_order, visible)
                        VALUES (:category_id, :name, :slug, :description, :type, :level, :icon, :doc_url, :features, :sort_order, :visible)";
            } else {
                $sql = "UPDATE skills SET category_id=:category_id, name=:name, slug=:slug, description=:description, type=:type,
                        level=:level, icon=:icon, doc_url=:doc_url, features=:features, sort_order=:sort_order, visible=:visible
                        WHERE id=:id";
                $data[':id'] = (int)$id;
            }

            $pdo->prepare($sql)->execute($data);
            $_SESSION['success'] = $id === null ? 'Skill ajouté.' : 'Skill modifié.';
            header('Location: ' . url('admin/skills'));
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            header('Location: ' . url('admin/skills'));
            exit;
        }
    }

    public function deleteSkill(): void
    {
        $this->checkAuth();
        global $pdo;
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("DELETE FROM skills WHERE id = :id")->execute([':id' => $id]);
            $_SESSION['success'] = 'Skill supprimé.';
        }
        header('Location: ' . url('admin/skills'));
        exit;
    }

    public function editCategory($id = null): void
    {
        $this->checkAuth();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':name'        => trim($_POST['name'] ?? ''),
                ':description' => trim($_POST['description'] ?? '') ?: null,
                ':icon'        => trim($_POST['icon'] ?? '') ?: null,
                ':icon_bg'     => trim($_POST['icon_bg'] ?? '') ?: null,
                ':sort_order'  => (int)($_POST['sort_order'] ?? 0),
                ':visible'     => isset($_POST['visible']) ? 1 : 0,
            ];
            if ($id === null) {
                $sql = "INSERT INTO skill_categories (name, description, icon, icon_bg, sort_order, visible)
                        VALUES (:name, :description, :icon, :icon_bg, :sort_order, :visible)";
            } else {
                $sql = "UPDATE skill_categories SET name=:name, description=:description, icon=:icon, icon_bg=:icon_bg,
                        sort_order=:sort_order, visible=:visible WHERE id=:id";
                $data[':id'] = (int)$id;
            }
            $pdo->prepare($sql)->execute($data);
            $_SESSION['success'] = $id === null ? 'Catégorie ajoutée.' : 'Catégorie modifiée.';
            header('Location: ' . url('admin/skills'));
            exit;
        }

        $category = null;
        if ($id !== null) {
            $stmt = $pdo->prepare("SELECT * FROM skill_categories WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        echo $this->view('admin_skill_category_edit', compact('category'));
    }

    public function deleteCategory(): void
    {
        $this->checkAuth();
        global $pdo;
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("DELETE FROM skill_categories WHERE id = :id")->execute([':id' => $id]);
            $_SESSION['success'] = 'Catégorie supprimée (et ses skills associés).';
        }
        header('Location: ' . url('admin/skills'));
        exit;
    }
}
