<?php

namespace App\Controllers;

use App\Models\Rating;

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

    public function show(array $data): array
    {
        return $this->ratings->findById($data['id']);
    }

    public function store(array $data): void
    {
        $this->ratings->create($data);
    }

    public function update(array $data): void
    {
        $this->ratings->update($data);
    }

    public function delete(array $data): void
    {
        $this->ratings->deleteById($data['id']);
    }
}