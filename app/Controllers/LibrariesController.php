<?php

namespace App\Controllers;

use App\Models\Library;

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

    public function show(array $data): array
    {
        return $this->libraries->findById($data['id']);
    }

    public function store(array $data): void
    {
        $this->libraries->create($data);
    }

    public function update(array $data): void
    {
        $this->libraries->update($data);
    }

    public function delete(array $data): void
    {
        $this->libraries->deleteById($data['id']);
    }
}