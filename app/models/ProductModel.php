<?php

    namespace App\Models;

    use App\Core\Model;

    class ProductModel extends Model
    {
        public function getProduct(string $url): array
        {
            return $this->fetch_assoc("SELECT * FROM `films` WHERE `url`='$url' AND `active`='1'");
        }

        public function getSchedule($urlFilm): array
        {
            return $this->fetch_all("
                SELECT DISTINCT `s`.*
                FROM `schedule` `s`
                LEFT JOIN `films` `f` ON `f`.url='{$urlFilm}'
                LEFT JOIN `time-halls-films` `t-h-f` on `f`.id = `t-h-f`.film_id
                WHERE `s`.id=`t-h-f`.time_id");
        }

        public function getHalls($time_id): array
        {
            return $this->fetch_all("
                SELECT 
                       `t-h-f`.hall_id as hall, 
                       `h`.count_place,
                       `th`.price
                FROM `time-halls-films` `t-h-f`
                LEFT JOIN `halls` `h` on `t-h-f`.hall_id = `h`.id
                LEFT JOIN `type_halls` `th` on `h`.type = `th`.id
                WHERE `t-h-f`.time_id='{$time_id}' AND `h`.active='1'");
        }
        public function getCountPlaceInHall($hall_id)
        {
            return $this->fetch_assoc("SELECT count_place FROM halls WHERE id='{$hall_id}' AND active='1'")['count_place'];
        }
        public function getIdFilmWithUrl($film)
        {
            return $this->fetch_assoc("SELECT id FROM films WHERE url='{$film}'")['id'];
        }
        public function getSelectedPlaceInHall($data, $date): array
        {
            return $this->fetch_all("
                SELECT * FROM `occupied-place`
                WHERE `time_id`='{$data['time']}' AND 
                      `film_id`='{$data['film']}' AND 
                      `hall_id`='{$data['hall']}' AND date='{$date}'");
        }
        public function setPlace($data, $user_id, $place)
        {
            return $this->query("
                INSERT INTO `occupied-place` SET
                hall_id='{$data['hall']}', 
                place='{$place}',
                film_id='{$data['film']}',
                time_id='{$data['time']}',
                user_id='{$user_id}',
                price='{$data['price']}'");
        }
        public function checkFreePlace($data, $place, $date)
        {
            return $this->fetch_assoc("
                SELECT place FROM `occupied-place`
                WHERE hall_id='{$data['hall']}' AND
                      time_id='{$data['time']}' AND
                      film_id='{$data['film']}' AND
                      place='{$place}' AND 
                      date='{$date}'")['place'];
        }

    }