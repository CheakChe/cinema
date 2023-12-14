<?php

    namespace App\Models;

    use App\Core\Model;

    class UserModel extends Model
    {
        public function userExists($vars)
        {
            return $this->fetch_assoc("SELECT * FROM `users` WHERE `login`='$vars' AND `active`='1'");
        }
        public function numberExists($vars)
        {
            return $this->fetch_assoc("SELECT * FROM `users` WHERE `number`='$vars' AND `active`='1'");
        }

        public function userOnline($user_id): void
        {
            $this->query("UPDATE `users` SET `status`='1' WHERE `id`='$user_id'");
        }

        public function logout($user_id): void
        {
            $this->query("UPDATE `users` SET `status`='0' WHERE `id`='$user_id'");
        }

        public function addUser($login, $password, $number): void
        {
            $this->query("INSERT INTO `users` SET `login`='$login', `password`='$password', `number`='$number'");
        }

    }