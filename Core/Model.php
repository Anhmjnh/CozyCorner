<?php
// core/Model.php
require_once __DIR__ . '/Database.php';

class Model
{
    protected $conn;

    public function __construct()
    {

        $this->conn = Database::getInstance()->getConnection();
    }


    public function getDbConnection()
    {
        return $this->conn;
    }

}
?>