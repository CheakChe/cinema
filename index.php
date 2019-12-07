<?php
$DB_setting = parse_ini_file('DB.ini');
$dns = $DB_setting['DB_CONNECTION'] . ':dbname=' . $DB_setting['DB_DATABASE'] . ';host=' . $DB_setting['DB_HOST'];
$DB = new PDO($dns, $DB_setting['DB_USERNAME'], $DB_setting['DB_PASSWORD']);
$halls = $DB->query("SELECT *  FROM `halls`");
$halls = $halls->fetchAll(PDO::FETCH_ASSOC);
foreach ($halls as $key => $hall) {

    $halls[$key]['hall'] = $DB->query("SELECT `place`, `status` FROM `hall` WHERE `hall_id`={$hall['id']}");
    $halls[$key]['hall'] = $halls[$key]['hall']->fetchAll(PDO::FETCH_ASSOC);
    $halls_place = $DB->query("SELECT COUNT(`hall_id`) FROM `hall` WHERE `hall_id`={$hall['id']}");
    if ($halls_place->fetch(PDO::FETCH_NUM)[0] != $hall['count_place']) {

        for ($i = 0; $i < $hall['count_place']; $i++) {

            $place = $DB->query("SELECT `place` FROM `hall` WHERE `place`={$i} AND `hall_id`={$hall['id']}");

            if (!$place->fetch(PDO::FETCH_ASSOC)) {
                $DB->query("INSERT INTO `hall` SET `place`={$i}, `hall_id`={$hall['id']}");
            }
        }
    }
}
require 'main.php';