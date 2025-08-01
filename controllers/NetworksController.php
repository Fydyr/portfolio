<?php

require_once 'BaseController.php';

class NetworksController extends BaseController
{
    public function networks()
    {
        echo $this->view('networks');
    }
}
