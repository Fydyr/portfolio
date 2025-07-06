<?php

require_once 'BaseController.php';

class ProjectsController extends BaseController
{

    public function projects()
    {
        echo $this->view('projects');
    }
}
