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

    public function show(array $data): array
    {
        $id = $data['id'];
        return $this->author->findById($id);
    }

    public function store(array $data): array
    {
        return $this->author->create($data);
    }

    public function update(array $data): array
    {
        return $this->author->update($data);
    }

    public function delete(array $data): array
    {
        $id = $data['id'];
        return $this->author->deleteById($id);
    }

    public function booksByAuthor(array $data): array
    {
        return (new Book())->findAllBy('authors_id', $data['id']);
    }
}