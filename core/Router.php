<?php

namespace Core;

use Exception;

class Router
{
    private string $url;
    private array $routes = [];
    private array $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, "GET");
    }

    public function post($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, "POST");
    }

    public function put($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, "PUT");
    }

    public function delete($path, $callable, $name = null): Route
    {
        return $this->add($path, $callable, $name, "DELETE");
    }

    public function resources($path, $controller): void
    {
        $this->get("$path", "$controller#index");
        $this->post("$path", "$controller#store");
        $this->get("$path/id/:id", "$controller#show");
        $this->put("$path/id/:id", "$controller#update");
        $this->delete("$path/id/:id", "$controller#delete");
    }

    private function add($path, $callable, $name, $method): Route
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function run()
    {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new Exception("REQUEST_METHOD does not exist");
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new Exception("No matching routes");
    }

    public function url($name, $params = []): string
    {
        if(!isset($this->namedRoutes[$name])){
            throw new Exception("No route matches this name");
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}