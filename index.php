<?php

require 'vendor/autoload.php';
use App\Router\Router;

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

        $route->resources('/publishers', 'PublishersController');
        $route->resources('/tags', 'TagsController');
    }
//    catch (PDOException $e) {
//        echo 'Something went wrong.';
//    }
    catch (Exception $e) {
        echo 'Error ' . $e->getCode() . ': ' . $e->getMessage();
    }
