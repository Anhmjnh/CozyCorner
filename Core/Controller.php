<?php
// core/Controller.php

class Controller {
    // Hàm gọi Model
    public function model($model) {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model();
    }

    // Hàm gọi View và tự động truyền biến
    public function view($view, $data = []) {
        // Biến mảng $data thành các biến độc lập để dùng trực tiếp trong HTML
        extract($data);
        require_once __DIR__ . '/../view/' . $view . '.php';
    }
}
?>
