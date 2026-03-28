<?php
// core/Model.php
require_once __DIR__ . '/Database.php';

class Model {
    protected $conn;

    public function __construct() {
        // Sử dụng kết nối Singleton duy nhất
        $this->conn = Database::getInstance()->getConnection();
    }
}
?>
