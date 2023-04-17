<?php

namespace Routes;

use Core\Router;
use Exception;

class Routes
{
    public static function routes(): void
    {
        $router = new Router($_SERVER['REQUEST_URI']);
        $router->resources('/books', 'Books');

        try {
            $router->run();
        }
        catch (PDOException $e) {
            echo 'Something went wrong.';
        }
        catch (Exception $e) {
            var_dump([
                'code' => $e->getCode(),
                'message' => $e->getMessage()]);
        }
    }
}