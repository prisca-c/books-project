<?php

namespace Routes;

use Core\Router;
use Exception;

class Routes
{
    public static function routes(): void
    {
        $routes = new Router($_SERVER['REQUEST_URI']);
        $routes->resources('/books', 'Books', true);
        $routes->post('/search', 'Books#searchBooks', true);
        $routes->resources('/ratings', 'Ratings', true);
        $routes->resources('/libraries', 'Libraries', true);
        $routes->resources('/wishlists', 'Wishlists', true);
        $routes->resources('/users', 'Users', true);
        $routes->resources('/editions', 'Editions', true);

        $routes->get('/authors/name/:name/books', 'Authors#getAuthorBooks', true);

        $routes->get('/users/id/:id/wishlists', 'Wishlists#getUserWishlists', true);
        $routes->get('/users/id/:id/libraries', 'Libraries#getUserLibraries', true);
        $routes->get('/users/id/:id/libraries/current', 'Libraries#getUserCurrentReading', true);

        $routes->post('/update/password', 'Profile#updatePassword', true);
        $routes->post('/update/details', 'Profile#updateDetails', true);

        $routes->post('/login', 'Login#login');
        $routes->post('/logout', 'Login#logout');
        $routes->post('/register', 'Login#register');

        $routes->get('/session/check', 'Login#checkSession');

        try {
            $routes->run();
        }
        catch (Exception $e) {
            $json = json_encode([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], JSON_PRETTY_PRINT);
            echo $json;
        }
    }
}

//
//class LibraryType {
//
//}
//
//function library(array $library) : LibraryType {
//    return new LibraryType($library);
//}
