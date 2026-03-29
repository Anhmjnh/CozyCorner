<?php
// core/Database.php
require_once __DIR__ . '/../config.php';

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Tự động đóng kết nối khi toàn bộ chương trình (script) PHP kết thúc
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
