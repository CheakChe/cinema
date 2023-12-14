<?php

    namespace App\Models;

    use App\Core\Model;

    class AccountModel extends Model
    {
        public function getAccountInfo($user_id): array
        {
            return $this->fetch_assoc("SELECT * FROM `users` WHERE id='{$user_id}' AND `active`='1'");
        }

        public function getAccountHistory($user_id)
        {
            return $this->fetch_all("
                SELECT DISTINCT `occupied-place`.date,
                                `occupied-place`.time_id,
                                `occupied-place`.hall_id,
                                `occupied-place`.film_id,
                                f.name,
                                f.img,
                                f.url,
                                h.id,
                                s.time
                FROM `occupied-place`
                LEFT JOIN films f on `occupied-place`.film_id = f.id
                LEFT JOIN halls h on `occupied-place`.hall_id = h.id
                LEFT JOIN schedule s on `occupied-place`.time_id = s.id
                WHERE user_id='{$user_id}'
                ORDER BY `occupied-place`.id DESC, `occupied-place`.date DESC ");
        }

        public function getAccountPlace($user_id, $film_id, $time_id, $hall_id, $date)
        {
            return $this->fetch_all("
                SELECT place
                FROM `occupied-place`
                WHERE user_id='{$user_id}' AND film_id='{$film_id}' AND time_id='{$time_id}' AND hall_id='{$hall_id}' AND date='{$date}'");
        }
        public function getAccountPrice($user_id, $film_id, $time_id, $hall_id, $date)
        {
            return $this->fetch_assoc("
                SELECT SUM(price) as price
                FROM `occupied-place`
                WHERE user_id='{$user_id}' AND film_id='{$film_id}' AND time_id='{$time_id}' AND hall_id='{$hall_id}' AND date='{$date}'")['price'];
        }
    }