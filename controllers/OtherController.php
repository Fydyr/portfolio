<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';

class OtherController extends BaseController
{
    public function price()
    {
        global $pdo;
        $prices = $pdo->query("SELECT * FROM price_items WHERE visible = 1 ORDER BY sort_order, id")->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->view('price', ['prices' => $prices]);
    }

    public function teapot()
    {
        echo $this->view('418');
    }
}
