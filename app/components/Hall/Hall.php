<?php


namespace App\Components\Hall;

use App\Components\Basic\Basic;
use App\Core\Router;
use PDO;

class Hall extends Basic
{
    public function __construct($DB)
    {
        parent::__construct($DB);
    }

    function ff()
    {
        $data['content'] = Router::render('hall/hall', $this->index());
        return $data;
    }

    public function index()
    {
        //Находим и получаем залы кинотеатра
        $halls = $this->db->query("SELECT *  FROM `halls` WHERE `active`='1'");
        $halls = $halls->fetchAll(PDO::FETCH_ASSOC);
        foreach ($halls as $key => $hall) {
            //Создаем в массиве залов подмассив со списом мест
            $halls[$key]['hall'] = $this->db->query("SELECT `place`, `status` FROM `hall` WHERE `hall_id`={$hall['id']} ORDER BY `place`");
//            Проблема с нумерацией места в зале!!!!!!!
            $halls[$key]['hall'] = $halls[$key]['hall']->fetchAll(PDO::FETCH_ASSOC);

            //Получаем количество мест каждого зала
            $halls_place = $this->db->query("SELECT COUNT(`hall_id`) FROM `hall` WHERE `hall_id`={$hall['id']}");
            $places = $this->db->query("SELECT COUNT(`hall_id`) FROM `hall` WHERE `hall_id`={$hall['id']} AND `status`='1'");
            $place_available[] = $places->fetchAll(PDO::FETCH_NUM)[0][0];
            //Если количество мест в меньше заданного, создаем это место
            if ($halls_place->fetch(PDO::FETCH_NUM)[0] != $hall['count_place']) {

                for ($i = 0; $i < $hall['count_place']; $i++) {
                    //Выборка каждого места отдельно
                    $place = $this->db->query("SELECT `place` FROM `hall` WHERE `place`={$i} AND `hall_id`={$hall['id']}");
                    //Если место не найдено — создаем его
                    if (!$place->fetch(PDO::FETCH_ASSOC)) {
                        $this->db->query("INSERT INTO `hall` SET `place`={$i}, `hall_id`={$hall['id']}");
                    }
                }
            }
        }
        return ['halls' => $halls, 'place_available' => $place_available];
    }

    function place($place_available = NULL)
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        if ($_POST['status'] == '1') {
            $_POST['status'] = '2';
            try {
                $this->db->prepare("
                    UPDATE `hall` SET `status`=? 
                    WHERE `place`=? AND `hall_id`=?")->execute([$_POST['status'], $_POST['id'], $_POST['hall_id']]);
                $places = $this->db->query("SELECT COUNT(`place`) FROM `hall` WHERE `hall_id`={$_POST['hall_id']} AND `status`='1' ORDER BY `id`");
                $place_available = $places->fetchAll(PDO::FETCH_NUM)[0][0];
            } catch (PDOException $exception) {
                throw new Exception($exception->getMessage(), (int)$exception->getCode());
            }
        }
        echo(json_encode(['status' => $_POST['status'], 'available' => $place_available]));
    }
}