<?php

namespace App\Controllers;

use App\Models\Wishlist;
use Core\Controller;

class WishlistsController extends Controller
{
    private Wishlist $wishlists;

    public function __construct()
    {
        parent::__construct();
        $this->wishlists = new Wishlist();
    }

    public function index(): array
    {
        return $this->wishlists->findAll();
    }

    public function show(string|int $id): array
    {
        return $this->wishlists->findById($id);
    }

    public function store(array $data): void
    {
        $this->wishlists->create($data);
    }

    public function update(array $data): void
    {
        $this->wishlists->update($data);
    }

    public function delete(string $id): void
    {
        $this->wishlists->deleteById($id);
    }
}