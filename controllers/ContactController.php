<?php

require_once 'BaseController.php';

class ContactController extends BaseController
{
    /**
     * Affiche le formulaire de contact
     */
    public function contact()
    {
        echo $this->view('contact');
    }
}
