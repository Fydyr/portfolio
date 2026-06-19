<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class AboutAdminController extends BaseController
{
    /** Liste des settings éditables sur la page about (clé => label) */
    private const EDITABLE_SETTINGS = [
        'about_hero_subtitle' => [
            'label'   => "Sous-titre du hero (sous le nom)",
            'markdown'=> false,
            'hint'    => "Variable disponible : %age% (remplacée par l'âge calculé). Les sauts de ligne sont gardés.",
        ],
        'about_bio'           => [
            'label'   => "Bio (Qui suis-je ?)",
            'markdown'=> true,
            'hint'    => "Markdown supporté : **gras**, *italique*, [lien](url), listes, paragraphes (ligne vide).",
        ],
        'github_user'         => [
            'label'   => "Compte GitHub à afficher",
            'markdown'=> false,
            'hint'    => "Login GitHub uniquement (ex: Fydyr). Sert à fetcher les derniers repos.",
        ],
    ];

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

        // Settings
        $stored = [];
        try {
            foreach ($pdo->query("SELECT `key`, `value`, `is_markdown` FROM site_settings") as $row) {
                $stored[$row['key']] = $row;
            }
        } catch (Exception $e) {}

        // Sections
        $sections = [];
        try {
            $sections = $pdo->query("SELECT * FROM about_sections ORDER BY sort_order, id")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {}

        echo $this->view('admin_about', [
            'settingsDef' => self::EDITABLE_SETTINGS,
            'stored'      => $stored,
            'sections'    => $sections,
        ]);
    }

    public function saveSettings(): void
    {
        $this->checkAuth();
        global $pdo;

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO site_settings (`key`, `value`, `is_markdown`) VALUES (:k, :v, :m)
                 ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `is_markdown` = VALUES(`is_markdown`)"
            );
            foreach (self::EDITABLE_SETTINGS as $key => $def) {
                $val = $_POST[$key] ?? '';
                $stmt->execute([
                    ':k' => $key,
                    ':v' => $val,
                    ':m' => $def['markdown'] ? 1 : 0,
                ]);
            }
            $_SESSION['success'] = 'Paramètres À propos enregistrés.';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Erreur : ' . $e->getMessage();
        }
        header('Location: ' . url('admin/about'));
        exit;
    }

    public function editSection($id = null): void
    {
        $this->checkAuth();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':slug'        => trim($_POST['slug'] ?? ''),
                ':title'       => trim($_POST['title'] ?? ''),
                ':icon'        => trim($_POST['icon'] ?? '') ?: null,
                ':content'     => trim($_POST['content'] ?? '') ?: null,
                ':is_markdown' => isset($_POST['is_markdown']) ? 1 : 0,
                ':sort_order'  => (int)($_POST['sort_order'] ?? 0),
                ':visible'     => isset($_POST['visible']) ? 1 : 0,
            ];
            try {
                if ($id === null) {
                    $sql = "INSERT INTO about_sections (slug, title, icon, content, is_markdown, sort_order, visible)
                            VALUES (:slug, :title, :icon, :content, :is_markdown, :sort_order, :visible)";
                } else {
                    $sql = "UPDATE about_sections SET slug=:slug, title=:title, icon=:icon, content=:content,
                            is_markdown=:is_markdown, sort_order=:sort_order, visible=:visible WHERE id=:id";
                    $data[':id'] = (int)$id;
                }
                $pdo->prepare($sql)->execute($data);
                $_SESSION['success'] = $id === null ? 'Section ajoutée.' : 'Section modifiée.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erreur : ' . $e->getMessage();
            }
            header('Location: ' . url('admin/about'));
            exit;
        }

        $section = null;
        if ($id !== null) {
            $stmt = $pdo->prepare("SELECT * FROM about_sections WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $section = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$section) {
                $_SESSION['error'] = 'Section introuvable.';
                header('Location: ' . url('admin/about'));
                exit;
            }
        }
        echo $this->view('admin_about_section_edit', compact('section'));
    }

    public function deleteSection(): void
    {
        $this->checkAuth();
        global $pdo;
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("DELETE FROM about_sections WHERE id = :id")->execute([':id' => $id]);
            $_SESSION['success'] = 'Section supprimée.';
        }
        header('Location: ' . url('admin/about'));
        exit;
    }
}
