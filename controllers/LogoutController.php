<?php

require_once 'BaseController.php';

class LogoutController extends BaseController
{
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
}
