<?php

namespace Core;

use Exception;
use Routes\Middleware;

class Router
{
    private string $url;
    private array $routes = [];
    private array $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
    }

    public function get($path, $callable, $middleware=false, $name=null): Route
    {
        return $this->add($path, $callable, $name, "GET", $middleware);
    }

    public function post($path, $callable, $middleware=false, $name=null): Route
    {
        return $this->add($path, $callable, $name, "POST", $middleware);
    }

    public function put($path, $callable, $middleware=false, $name=null): Route
    {
        return $this->add($path, $callable, $name, "PUT", $middleware);
    }

    public function delete($path, $callable, $middleware=false, $name=null): Route
    {
        return $this->add($path, $callable, $name, "DELETE", $middleware);
    }

    public function resources($path, $controller, $middleware=false, $name=null): void
    {
        $this->get("$path", "$controller#index", $name, $middleware);
        $this->post("$path", "$controller#store", $name, $middleware);
        $this->get("$path/id/:id", "$controller#show", $name, $middleware);
        $this->put("$path/id/:id", "$controller#update", $name, $middleware);
        $this->delete("$path/id/:id", "$controller#delete", $name, $middleware);
    }

    /**
     * @throws Exception
     */
    private function add($path, $callable, $name, $method, $middleware): Route
    {
        if($name === ''){
            $name = null;
        }
        $route = new Route($path, $callable, $middleware);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }

        if($middleware){
            $session = Middleware::verifyCookieHeader();
            if($session){
                return $route;
            } else {
                throw new Exception("Unauthorized");
            }
        } elseif (!$middleware) {
            return $route;
        } else {
            throw new Exception("Middleware must be true or false");
        }
    }

    /**
     * @throws Exception
     */
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

    /**
     * @throws Exception
     */
    public function url($name, $params = []): string
    {
        if(!isset($this->namedRoutes[$name])){
            throw new Exception("No route matches this name");
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}