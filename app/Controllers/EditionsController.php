<?php

namespace App\Controllers;

use App\Models\Edition;
use Core\Controller;

class EditionsController extends Controller
{
    private Edition $editions;

    public function __construct()
    {
        parent::__construct();
        $this->editions = new Edition();
    }

    public function index(): array
    {
        return $this->editions->findAll();
    }

    public function show(string $id): array
    {
        return $this->editions->findById($id);
    }

    public function store(array $data): void
    {
        $this->editions->create($data);
    }

    public function update(array $data): void
    {
        $this->editions->update($data);
    }

    public function delete(string $id): void
    {
        $this->editions->deleteById($id);
    }
}