<?php

namespace App\Controllers;

use App\Database\QueryMethods;

class TagsController extends Controller
{

    public function index(): array
    {
        return QueryMethods::findAll('tags');
    }

    public function show(array $data): array
    {
        $id = $data['id'];
        return QueryMethods::findById('tags', $id);
    }

    public function store(array $data): void
    {
        $name = $data['name'];
        $query = $this->db->prepare('INSERT INTO tags (name) VALUES (:name)');
        $query->bindParam(':name', $name);
        $query->execute();
    }

    public function update(array $data): void
    {
        $id = $data['id'];
        $name = $data['name'];
        $query = $this->db->prepare('UPDATE tags SET name = :name WHERE id = :id');
        $query->bindParam(':name', $name);
        $query->bindParam(':id', $id);
        $query->execute();
    }

    public function delete(array $data): void
    {
        $id = $data['id'];
        QueryMethods::deleteById('tags', $id);
    }
}