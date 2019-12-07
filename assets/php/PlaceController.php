<?php

class PlaceController
{
    public function __construct()
    {
        session_start();
        $DB = new PDO(
            $_SESSION['DB']['dns'],
            $_SESSION['DB']['DB_USERNAME'],
            $_SESSION['DB']['DB_PASSWORD']);
        $this->index($DB);
        unset($DB);
    }

    function index($DB)
    {
        if ($_POST['status'] == '1') {
            $_POST['status'] = '2';
            $DB->prepare("
                UPDATE `hall` SET `status`=? 
                WHERE `place`=? AND `hall_id`=?")->execute([$_POST['status'], $_POST['id'], $_POST['hall_id']]);
            $places = $DB->query("SELECT COUNT(`hall_id`) FROM `hall` WHERE `hall_id`={$_POST['hall_id']} AND `status`='1'");
            $place_available = $places->fetchAll(PDO::FETCH_NUM)[0][0];
        }
        echo [$message = $_POST['status'], $place_available];
    }
}

new PlaceController;