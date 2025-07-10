<?php

require_once 'BaseController.php';

class LoginController extends BaseController
{

    public function login()
    {
        echo $this->view('login');
    }
}
