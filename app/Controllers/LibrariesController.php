<?php

namespace App\Controllers;

use App\Models\Library;
use Core\Controller;

class LibrariesController extends Controller
{
    private Library $libraries;

    public function __construct()
    {
        parent::__construct();
        $this->libraries = new Library();
    }

    public function index(): array
    {
        return $this->libraries->findAll();
    }

    public function show(string $id): array
    {
        return $this->libraries->findById($id);
    }

    public function store(array $data): void
    {
        $this->libraries->create($data);
    }

    public function update(array $data): void
    {
        $this->libraries->update($data);
    }

    public function delete(string $id): void
    {
        $this->libraries->deleteById($id);
    }
}