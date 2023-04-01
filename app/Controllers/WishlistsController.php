<?php

namespace App\Controllers;

use App\Models\Wishlist;
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

    public function show(array $data): array
    {
        return $this->wishlists->findById($data['id']);
    }

    public function store(array $data): void
    {
        $this->wishlists->create($data);
    }

    public function update(array $data): void
    {
        $this->wishlists->update($data);
    }

    public function delete(array $data): void
    {
        $this->wishlists->deleteById($data['id']);
    }
}