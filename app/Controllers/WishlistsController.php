<?php

namespace App\Controllers;

use App\Models\Wishlist;
use Core\Auth;
use Core\Controller;
use MongoDB\BSON\ObjectId;
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

    public function store(array $data): array
    {
        $data = $data['data'];
        $edition = $data['edition'];
        $token = $_COOKIE['cookie-session'];

        $userId = Auth::decodeToken($token)['id'];

        if (empty($edition)) {
            return $this->response->internalServerError('Missing data');
        }

        if (count($data) > 1) {
            return $this->response->internalServerError('Too many data');
        }

        $data['status'] = 'to-read';
        $data['note'] = '';

        $result = $this->wishlists->create($data);

        $this->db->__get('users')->updateOne(
            ['_id' => new ObjectId($userId)],
            ['$push' => ['wishlists' => $result->getInsertedId()]]
        );

        $this->db->__get('editions')->updateOne(
            ['_id' => new ObjectId($edition['_id']['$oid'])],
            ['$push' => ['wishlists' => $result->getInsertedId()]]
        );

        return $this->response->created();
    }

    public function update(array $data): array
    {
        $data = $data['data'];
        $id = $data['_id'];
        $status = $data['status'];
        $note = $data['note'];
        $edition = $data['edition'];
        $user = $data['user'];

        if (empty($id) || empty($status) || empty($note) || empty($edition) || empty($user)) {
            return $this->response->internalServerError('Missing data');
        }

        if (count($data) > 5) {
            return $this->response->internalServerError('Too many data');
        }

        $this->wishlists->update($data);
    }

    public function delete(string $id): void
    {
        $this->wishlists->deleteById($id);
    }

    public function getUserWishlist(string $id): array
    {
        $wishlist = $this->db->__get('wishlists')->findOne(['user' => new ObjectId($id)])->toArray();
        if (empty($wishlist)) {
            return $this->response->notFound();
        }
        return $wishlist;
    }
}
