<?php

namespace App\Controllers;

use App\Models\Rating;
use Core\Controller;

class RatingsController extends Controller
{
    private Rating $ratings;

    public function __construct()
    {
        parent::__construct();
        $this->ratings = new Rating();
    }

    public function index(): array
    {
        return $this->ratings->findAll();
    }

    public function show(string $id): array
    {
        return $this->ratings->findById($id);
    }

    public function store(array $data): void
    {
        $this->ratings->create($data);
    }

    public function update(array $data): void
    {
        $this->ratings->update($data);
    }

    public function delete(string $id): void
    {
        $this->ratings->deleteById($id);
    }
}