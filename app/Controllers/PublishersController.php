<?php

namespace App\Controllers;

use App\Models\Publisher;

class PublishersController extends Controller
{
    private Publisher $publishers;

    public function __construct()
    {
        parent::__construct();
        $this->publishers = new Publisher();
    }

    public function index(): array
    {
        return $this->publishers->findAll();
    }

    public function show(array $data): array
    {
        $id = $data['id'];
        return $this->publishers->findById($id);
    }

    public function store(array $data): void
    {
        $name = $data['name'];
        $query = $this->db->prepare('INSERT INTO publishers (name) VALUES (:name)');
        $query->bindParam(':name', $name);
        $query->execute();
    }

    public function update(array $data): void
    {
        $id = $data['id'];
        $name = $data['name'];
        $query = $this->db->prepare('UPDATE publishers SET name = :name WHERE id = :id');
        $query->bindParam(':name', $name);
        $query->bindParam(':id', $id);
        $query->execute();
    }

    public function delete(array $data): array
    {
        $id = $data['id'];
        return $this->publishers->deleteById($id);
    }
}