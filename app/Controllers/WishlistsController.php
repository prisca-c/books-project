<?php

namespace App\Controllers;

use App\Models\Wishlist;
use Core\Controller;
use MongoDB\Model\BSONDocument;

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

    public function show(string|int $id): BSONDocument
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

    public function getCount(int|string $id): array
    {
        $query = $this->db->prepare("
            SELECT COUNT(DISTINCT wishlists.id) AS wishlists_count
            FROM wishlists
            WHERE wishlists.users_id = :id");
        $query->bindParam(':id', $id);
        $query->execute();

        return $query->fetch();
    }
}
