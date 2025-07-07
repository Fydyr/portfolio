<?php

require_once 'BaseController.php';

class ContactController extends BaseController
{
    public function contact()
    {
        echo $this->view('contact');
    }
}
