<?php
// core/Router.php

class Router {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // ---- ROUTING CHO ADMIN ----
        if (isset($url[0]) && strtolower($url[0]) === 'admin') {
            $this->controller = 'AdminController';
            unset($url[0]);
            
            if (isset($url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        } else {
            // ---- ROUTING CHO USER ----
            if (isset($url[0])) {
                $controllerNameSegment = strtolower($url[0]) === 'ghn' ? 'GHNController' : ucfirst($url[0]) . 'Controller';
                if (file_exists(__DIR__ . '/../controllers/' . $controllerNameSegment . '.php')) {
                    $this->controller = $controllerNameSegment;
                    unset($url[0]);
                }
            }
            
            if (isset($url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        require_once __DIR__ . '/../controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        $this->params = $url ? array_values($url) : [];

        if (method_exists($this->controller, $this->method)) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            echo "<h1>404 - Action không tồn tại: " . htmlspecialchars($this->method) . "</h1>";
        }
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
?>
