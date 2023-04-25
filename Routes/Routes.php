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
        $routes->resources('/books', 'Books', '', true);
        $routes->post('/search', 'Books#searchBooks', '', true);
        $routes->resources('/authors', 'Authors', '', true);
        $routes->resources('/publishers', 'Publishers', '', true);
        $routes->resources('/tags', 'Tags', '', true);
        $routes->resources('/ratings', 'Ratings', '', true);
        $routes->resources('/libraries', 'Libraries', '', true);
        $routes->resources('/wishlists', 'Wishlists', '', true);
        $routes->resources('/users', 'Users', '', true);
        $routes->resources('/editions', 'Editions', '', true);
        $routes->get('/users/id/:id/wishlist/count', 'Wishlists#getCount', '', true);
        $routes->get('/users/id/:id/libraries/current/count', 'Libraries#getLibraryCurrentReadingCount', '', true);

        $routes->post('/login', 'Login#login');
        $routes->post('/register', 'Login#register');

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