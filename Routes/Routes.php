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
        $routes->resources('/books', 'Books', true);
        $routes->post('/search', 'Books#searchBooks', true);
        $routes->resources('/ratings', 'Ratings', true);
        $routes->resources('/libraries', 'Libraries', true);
        $routes->resources('/wishlists', 'Wishlists', true);
        $routes->resources('/users', 'Users', true);
        $routes->resources('/editions', 'Editions', true);
        $routes->get('/users/id/:id/wishlist/count', 'Wishlists#getCount', true);
        $routes->get('/users/id/:id/libraries/current/count', 'Libraries#getLibraryCurrentReadingCount', true);

        $routes->get('/users/id/:id/wishlist/count', 'Wishlists#getCount', true);
        $routes->get('/users/id/:id/libraries/current/count', 'Libraries#getLibraryCurrentReadingCount', true);
        $routes->get('/users/id/:id/libraries/current', 'Libraries#getUserCurrentReading', true);
        // TODO:
        // Routes: Books/rating |

        $routes->post('/update/password', 'Profile#updatePassword', true);
        $routes->post('/update/details', 'Profile#updateDetails', true);

        $routes->post('/login', 'Login#login');
        $routes->post('/logout', 'Login#logout');
        $routes->post('/register', 'Login#register');

        $routes->get('/session/check', 'Login#checkSession');

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

//
//class LibraryType {
//
//}
//
//function library(array $library) : LibraryType {
//    return new LibraryType($library);
//}
