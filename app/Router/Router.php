<?php

namespace App\Router;

use Exception;

class Router
{
    private string $method;
    private string $request;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->request = $_SERVER['REQUEST_URI'];
    }

    public function get($path, $controller, $controller_method): void
    {
        if ($this->request == $path && $this->method == 'GET') {
            $controllerNs = "App\Controllers\\" . $controller;
            $controller = new $controllerNs();
            $data = file_get_contents("php://input");
            $data = json_decode($data, true);
            $stmt = $controller->$controller_method($data);
            $this->toJSON($stmt);
        }
    }

    public function post($path, $controller, $controller_method): void
    {
        if ($this->request == $path && $this->method == 'POST') {
            $controllerNs = "App\Controllers\\" . $controller;
            $controller = new $controllerNs();
            $stmt = $controller->$controller_method($_POST);
            $this->toJSON($stmt);
        }
    }

    public function put($path, $controller, $controller_method): void
    {
        if ($this->request == $path && $this->method == 'PUT') {
            $controllerNs = "App\Controllers\\" . $controller;
            $controller = new $controllerNs();
            $data = file_get_contents("php://input");
            $data = json_decode($data, true);
            $stmt = $controller->$controller_method($data);
            $this->toJSON($stmt);
        }
    }

    public function delete($path, $controller, $controller_method): void
    {
        if ($this->request == $path && $this->method == 'DELETE') {
            $controllerNs = "App\Controllers\\" . $controller;
            $controller = new $controllerNs();
            $data = file_get_contents("php://input");
            $data = json_decode($data, true);
            $stmt = $controller->$controller_method($data);
            $this->toJSON($stmt);
        }
    }

    /**
     * @throws Exception
     */
    public function resources($path, $controller): void
    {
        $this->get($path, $controller, 'index');
        $this->get($path . '/id', $controller, 'show');
        $this->post($path, $controller, 'store');
        $this->put($path, $controller, 'update');
        $this->delete($path, $controller, 'delete');
    }

    public function toJSON($data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}