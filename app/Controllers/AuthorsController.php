<?php

namespace App\Controllers;

use App\Models\Author;
use App\Models\Book;
use Core\Controller;

class AuthorsController extends Controller
{
    private Author $author;
    public function __construct()
    {
        parent::__construct();
        $this->author = new Author();
    }

    public function index(): array
    {
        return $this->author->findAll();
    }

    public function show(string|int $id): array
    {
        $query = $this->db->prepare("
            SELECT authors.id, authors.name, ROUND(AVG(ratings.rating), 2) AS rating, COUNT(DISTINCT books.id) AS books_count, COUNT(DISTINCT libraries.id) AS libraries_count, COUNT(DISTINCT wishlists.id) AS wishlists_count
            FROM authors 
            LEFT JOIN books ON authors.id = books.authors_id
            LEFT JOIN editions ON books.id = editions.books_id 
            LEFT JOIN libraries ON editions.id = libraries.editions_id
            LEFT JOIN wishlists ON editions.id = wishlists.editions_id
            LEFT JOIN ratings ON books.id = ratings.books_id
            WHERE authors.id = :id");
        $query->bindParam(':id', $id);
        $query->execute();

        return $query->fetch();
    }

    public function store(array $data): array
    {
        return $this->author->create($data);
    }

    public function update(array $data): array
    {
        return $this->author->update($data);
    }

    public function delete(string $id): array
    {
        return $this->author->deleteById($id);
    }

    public function booksByAuthor(array $data): array
    {
        return (new Book())->findAllBy('authors_id', $data['id']);
    }
}