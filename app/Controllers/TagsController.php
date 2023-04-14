<?php

namespace App\Controllers;

use App\Models\Tag;
use Core\Controller;

class TagsController extends Controller
{
    private Tag $tag;

    public function __construct()
    {
        parent::__construct();
        $this->tag = new Tag();
    }

    public function index(): array
    {
        return $this->tag->findAll();
    }

    public function show(string $id): array
    {
        return $this->tag->findById($id);
    }

    public function store(array $data): array
    {
        return $this->tag->create($data);
    }

    public function update(array $data): array
    {
        return $this->tag->update($data);
    }

    public function delete(string $id): array
    {
        return $this->tag->deleteById($id);
    }
}