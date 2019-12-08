<?php
new Base;

class Base
{
    public function __construct()
    {
        //Начало сессии
        session_start();
        //Конфигурационный файл — содержит  настройки БД
        $_SESSION['DB'] = parse_ini_file('DB.ini');
        //Создание переменной DNS для подключение к БД через PDO
        $_SESSION['DB']['dns'] = $_SESSION['DB']['DB_CONNECTION'] . ':dbname=' . $_SESSION['DB']['DB_DATABASE'] . ';host=' . $_SESSION['DB']['DB_HOST'];
        //Создание объекта БД
        $DB = new PDO($_SESSION['DB']['dns'], $_SESSION['DB']['DB_USERNAME'], $_SESSION['DB']['DB_PASSWORD']);
        $this->index($DB);
        unset($DB);
    }

    function index($DB)
    {
        //Находим и получаем залы кинотеатра
        $halls = $DB->query("SELECT *  FROM `halls` WHERE `active`='1'");
        $halls = $halls->fetchAll(PDO::FETCH_ASSOC);

        foreach ($halls as $key => $hall) {
            //Создаем в массиве залов подмассив со списом мест
            $halls[$key]['hall'] = $DB->query("SELECT `place`, `status` FROM `hall` WHERE `hall_id`={$hall['id']}");
            $halls[$key]['hall'] = $halls[$key]['hall']->fetchAll(PDO::FETCH_ASSOC);

            //Получаем количество мест каждого зала
            $halls_place = $DB->query("SELECT COUNT(`hall_id`) FROM `hall` WHERE `hall_id`={$hall['id']}");
            $places = $DB->query("SELECT COUNT(`hall_id`) FROM `hall` WHERE `hall_id`={$hall['id']} AND `status`='1'");
            $place_available[] = $places->fetchAll(PDO::FETCH_NUM)[0][0];
            //Если количество мест в меньше заданного, создаем это место
            if ($halls_place->fetch(PDO::FETCH_NUM)[0] != $hall['count_place']) {

                for ($i = 0; $i < $hall['count_place']; $i++) {
                    //Выборка каждого места отдельно
                    $place = $DB->query("SELECT `place` FROM `hall` WHERE `place`={$i} AND `hall_id`={$hall['id']}");
                    //Если место не найдено — создаем его
                    if (!$place->fetch(PDO::FETCH_ASSOC)) {
                        $DB->query("INSERT INTO `hall` SET `place`={$i}, `hall_id`={$hall['id']}");
                    }
                }
            }
        }
        require 'main.php';
    }
}