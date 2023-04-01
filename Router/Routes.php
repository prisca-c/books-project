<?php

namespace Router;

use Exception;

class Routes
{
    public static function routes(): void
    {
        $route = new Router();

        try {
            $route->resources('/users', 'UsersController');
            $route->resources('/authors', 'AuthorsController');

            $route->resources('/books', 'BooksController');
            $route->get('/books/tags/id', 'BooksController', 'booksByTagId');
            $route->get('/books/id/tags', 'BooksController', 'getTags');
            $route->post('/books/id/tags', 'BooksController', 'addTag');
            $route->delete('/books/id/tags', 'BooksController', 'removeTag');
            $route->get('/books/authors/id', 'BooksController', 'booksByAuthor');

            $route->resources('/libraries', 'LibrariesController');
            $route->resources('/wishlists', 'WishlistsController');
            $route->resources('/publishers', 'PublishersController');
            $route->resources('/tags', 'TagsController');
            $route->resources('/ratings', 'RatingsController');
        }
//    catch (PDOException $e) {
//        echo 'Something went wrong.';
//    }
        catch (Exception $e) {
            echo 'Error ' . $e->getCode() . ': ' . $e->getMessage();
        }
    }
}