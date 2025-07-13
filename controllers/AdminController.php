<?php

require_once 'BaseController.php';

class AdminController extends BaseController
{
    public function admin()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
                header('HTTP/1.1 403 Forbidden');
                echo view('403', ['title' => '403 - Accès interdit']);
            exit;
        }
        echo $this->view('admin');
    }
}