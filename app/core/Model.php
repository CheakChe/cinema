<?php


namespace App\Core;


use PDO;

class Model
{
    private $db;

    function __construct()
    {
        $this->db = new PDO($_SESSION['DB']['dns'], $_SESSION['DB']['DB_USERNAME'], $_SESSION['DB']['DB_PASSWORD']);
    }

    function fetch_assoc($query)
    {
        $query = $this->db->query($query);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}