<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class PricesAdminController extends BaseController
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
        $prices = $pdo->query("SELECT * FROM price_items ORDER BY sort_order, id")->fetchAll(PDO::FETCH_ASSOC);
        echo $this->view('admin_prices', compact('prices'));
    }

    public function edit($id = null): void
    {
        $this->checkAuth();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':title'       => trim($_POST['title'] ?? ''),
                ':description' => trim($_POST['description'] ?? '') ?: null,
                ':price'       => trim($_POST['price'] ?? '') ?: null,
                ':icon'        => trim($_POST['icon'] ?? '') ?: null,
                ':sort_order'  => (int)($_POST['sort_order'] ?? 0),
                ':visible'     => isset($_POST['visible']) ? 1 : 0,
            ];

            if ($id === null) {
                $sql = "INSERT INTO price_items (title, description, price, icon, sort_order, visible)
                        VALUES (:title, :description, :price, :icon, :sort_order, :visible)";
            } else {
                $sql = "UPDATE price_items SET title=:title, description=:description, price=:price, icon=:icon,
                        sort_order=:sort_order, visible=:visible WHERE id=:id";
                $data[':id'] = (int)$id;
            }

            try {
                $pdo->prepare($sql)->execute($data);
                $_SESSION['success'] = $id === null ? 'Tarif ajouté.' : 'Tarif modifié.';
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erreur: ' . $e->getMessage();
            }
            header('Location: ' . url('admin/prices'));
            exit;
        }

        $price = null;
        if ($id !== null) {
            $stmt = $pdo->prepare("SELECT * FROM price_items WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $price = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$price) {
                $_SESSION['error'] = 'Tarif introuvable.';
                header('Location: ' . url('admin/prices'));
                exit;
            }
        }
        echo $this->view('admin_price_edit', compact('price'));
    }

    public function delete(): void
    {
        $this->checkAuth();
        global $pdo;
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("DELETE FROM price_items WHERE id = :id")->execute([':id' => $id]);
            $_SESSION['success'] = 'Tarif supprimé.';
        }
        header('Location: ' . url('admin/prices'));
        exit;
    }
}
