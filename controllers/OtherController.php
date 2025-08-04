<?php

require_once 'BaseController.php';

class OtherController extends BaseController
{
    public function networks()
    {
        echo $this->view('networks');
    }

    public function price()
    {
        echo $this->view('price');
    }
}
