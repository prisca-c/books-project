<?php

namespace Core;

class Route
{
    private string $path;
    private mixed $callable;
    private array $matches = [];
    private array $params = [];

    public function __construct($path, $callable){
        $this->path = trim($path, "/");
        $this->callable = $callable;
    }

    public function match($url): bool
    {
        $url = trim($url, "/");
        $path = preg_replace_callback("#:([\w]+)#", [$this, "paramMatch"], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function with($param, $regex): static
    {
        $this->params[$param] = str_replace("(", "(?:", $regex);
        return $this;
    }

    public function call(): void
    {
        if(is_string($this->callable)){
            $params = explode("#", $this->callable);
            $controller = "App\\Controllers\\" . $params[0] . "Controller";
            $controller = new $controller();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' or $_SERVER['REQUEST_METHOD'] === 'PUT') {
                $data = json_decode(file_get_contents('php://input'), true);
                $controller->{$params[1]}($data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                return;
            } else {
                echo json_encode(call_user_func_array([$controller, $params[1]], $this->matches), JSON_PRETTY_PRINT);
            }
        } else {
            echo json_encode(call_user_func_array($this->callable, $this->matches), JSON_PRETTY_PRINT);
        }
    }

    private function paramMatch($match): string
    {
        if(isset($this->params[$match[1]])){
            return "(" . $this->params[$match[1]] . ")";
        }
        return "([^/]+)";
    }

    public function getUrl($params): string
    {
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}