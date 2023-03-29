<?php

namespace App\Controllers;

use App\Database\QueryMethods;
use App\Models\Author;

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

    public function store(array $data): void
    {
        $name = $data['name'];
        $query = $this->db->prepare('INSERT INTO authors (name) VALUES (:name)');
        $query->bindParam(':name', $name);
        $query->execute();
    }

    public function update(array $data): void
    {
        $id = $data['id'];
        $name = $data['name'];
        $query = $this->db->prepare('UPDATE authors SET name = :name WHERE id = :id');
        $query->bindParam(':name', $name);
        $query->bindParam(':id', $id);
        $query->execute();
    }

    public function delete(array $data): array
    {
        $id = $data['id'];
        return $this->author->deleteById($id);
    }

    public function books(array $data): array
    {
        $id = $data['id'];
        $query = $this->db->prepare('SELECT * FROM books WHERE authors_id = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }
}