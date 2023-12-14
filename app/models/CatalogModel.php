<?php

    namespace App\Models;

    use App\Core\Model;

    class CatalogModel extends Model
    {
        public function getCatalog(): array
        {
            return $this->fetch_all('SELECT * FROM `films` WHERE `active`="1"');
        }
    }