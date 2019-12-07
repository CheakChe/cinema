<?php
//Конфигурационный файл — содержит  настройки БД
$DB_setting = parse_ini_file('DB.ini');
//Создание переменной DNS для подключение к БД через PDO
$dns = $DB_setting['DB_CONNECTION'] . ':dbname=' . $DB_setting['DB_DATABASE'] . ';host=' . $DB_setting['DB_HOST'];
//Создание объекта БД
$DB = new PDO($dns, $DB_setting['DB_USERNAME'], $DB_setting['DB_PASSWORD']);
//Находим и получаем залы кинотеатра
$halls = $DB->query("SELECT *  FROM `halls` WHERE `active`='1'");
$halls = $halls->fetchAll(PDO::FETCH_ASSOC);

foreach ($halls as $key => $hall) {
//    Создаем в массиве залов подмассив со списом мест
    $halls[$key]['hall'] = $DB->query("SELECT `place`, `status` FROM `hall` WHERE `hall_id`={$hall['id']}");
    $halls[$key]['hall'] = $halls[$key]['hall']->fetchAll(PDO::FETCH_ASSOC);

//    Получаем количество мест каждого зала
    $halls_place = $DB->query("SELECT COUNT(`hall_id`) FROM `hall` WHERE `hall_id`={$hall['id']}");
//    Если количество мест в меньше заданного, создаем это место
    if ($halls_place->fetch(PDO::FETCH_NUM)[0] != $hall['count_place']) {

        for ($i = 0; $i < $hall['count_place']; $i++) {
//            Выборка каждого места отдельно
            $place = $DB->query("SELECT `place` FROM `hall` WHERE `place`={$i} AND `hall_id`={$hall['id']}");
//            Если место не найдено — создаем его
            if (!$place->fetch(PDO::FETCH_ASSOC)) {
                $DB->query("INSERT INTO `hall` SET `place`={$i}, `hall_id`={$hall['id']}");
            }
        }
    }
}
require 'main.php';