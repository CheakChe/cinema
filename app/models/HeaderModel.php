<?php

    namespace App\Models;

    use App\Core\Model;

    class HeaderModel extends Model
    {
        public function getMenu(): array
        {
            return $this->fetch_all('SELECT * FROM `menu` WHERE `active`="1"');
        }
    }