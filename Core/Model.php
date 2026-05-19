<?php
// core/Model.php
require_once __DIR__ . '/Database.php';

class Model
{
    protected $conn;

    public function __construct()
    {

        $this->conn = Database::getInstance()->getConnection();
        // Đảm bảo MySQL trả về thời gian theo múi giờ Việt Nam (+07:00)
        $this->conn->query("SET time_zone = '+07:00'");
    }


    public function getDbConnection()
    {
        return $this->conn;
    }

}
?>