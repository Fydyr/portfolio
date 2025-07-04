<?php

require_once 'BaseController.php';

class HomeController extends BaseController
{

    public function index()
    {
        echo $this->view('home', [
            'title' => 'Accueil',
        ]);
    }

    public function about()
    {
        echo $this->view('about', [
            'title' => 'À propos de nous'
        ]);
    }
}
