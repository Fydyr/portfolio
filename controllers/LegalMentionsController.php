<?php

require_once 'BaseController.php';

class LegalMentionsController extends BaseController
{
    public function legalMentions()
    {
        echo $this->view('legal_mentions');
    }
}
