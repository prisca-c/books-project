<?php

namespace App\Controllers;

use App\Models\Publisher;
use Core\Controller;

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

    public function show(string|int $id): array
    {
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

    public function delete(string $id): array
    {
        return $this->publishers->deleteById($id);
    }
}