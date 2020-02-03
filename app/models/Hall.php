<?php


namespace App\Models;


use App\Core\Model;

class Hall extends Model
{

    function Halls()
    {
        return $this->fetch_assoc("SELECT *  FROM `halls` WHERE `active`='1'");
    }

    function SubHalls()
    {

    }
}