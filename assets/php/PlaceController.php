<?php

class PlaceController
{
    public function __construct()
    {
//        Начало сессии
        session_start();
//        Создание объекта БД
        $DB = new PDO(
            $_SESSION['DB']['dns'],
            $_SESSION['DB']['DB_USERNAME'],
            $_SESSION['DB']['DB_PASSWORD']);
//        Запуск базовой функции
        $this->index($DB);
        unset($DB);
    }

    function index($DB)
    {
        $place_available = NULL;
        if ($_POST['status'] == '1') {
            $_POST['status'] = '2';
            try {
                $DB->prepare("
                    UPDATE `hall` SET `status`=? 
                    WHERE `place`=? AND `hall_id`=?")->execute([$_POST['status'], $_POST['id'], $_POST['hall_id']]);
                $places = $DB->query("SELECT COUNT(`place`) FROM `hall` WHERE `hall_id`={$_POST['hall_id']} AND `status`='1' ORDER BY `id`");
                foreach ($places->fetchAll(PDO::FETCH_ASSOC) as $ke) {
                    var_dump($ke);
                }
                $place_available = $places->fetchAll(PDO::FETCH_NUM)[0][0];
            } catch (PDOException $exception) {
                throw new MyDatabaseException($exception->getMessage(), (int)$exception->getCode());
            }
        }
        echo(json_encode(['status' => $_POST['status'], 'available' => $place_available]));
    }
}

new PlaceController;