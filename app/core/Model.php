<?php


namespace App\Core;


use PDO;
use PDOException;

class Model
{
    private $db;

    public function __construct()
    {
        try {
            $DB = parse_ini_file('DB.ini');
            $DB['dns'] = $DB['DB_CONNECTION'] . ':dbname=' . $DB['DB_DATABASE'] . ';host=' . $DB['DB_HOST'];
            $this->db = new PDO($DB['dns'], $DB['DB_USERNAME'], $DB['DB_PASSWORD']);
        } catch (PDOException $exception) {
            die('Fatal connection — ' . $exception->getMessage());
        }
    }

    protected function fetch_assoc($query)
    {
        try {
            $fetch_assoc = $this->db->query($query);
        } catch (PDOException $exception) {
            die('Fatal error — ' . $exception->getMessage());
        }
        return $fetch_assoc->fetchAll(PDO::FETCH_ASSOC);
    }
}