<?php

namespace Routes;

use Core\Router;
use Exception;
use PDOException;

class Routes
{
    public static function routes(): void
    {
        $routes = new Router($_SERVER['REQUEST_URI']);
        $routes->resources('/books', 'Books');
        $routes->post('/search', 'Books#searchBooks');
        $routes->resources('/authors', 'Authors');
        $routes->resources('/publishers', 'Publishers');
        $routes->resources('/tags', 'Tags');
        $routes->resources('/ratings', 'Ratings');
        $routes->resources('/libraries', 'Libraries');
        $routes->resources('/wishlists', 'Wishlists');
        $routes->resources('/users', 'Users');
        $routes->resources('/editions', 'Editions');

        $routes->post('/login', 'Users#login');
        $routes->post('/register', 'Users#register');

        try {
            $routes->run();
        }
//        catch (PDOException $e) {
//            echo 'Something went wrong.';
//        }
        catch (Exception $e) {
            $json = json_encode([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], JSON_PRETTY_PRINT);
            echo $json;
        }
    }
}