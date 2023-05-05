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

        $user = $this->db->__get('users')->findOne(['_id' => new ObjectId($userId)]);
        
        $data['user'] = $user;

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
        $edition = $data['edition'];
        
        if (empty($edition) || empty($user)) {
            return $this->response->internalServerError('Missing data');
        }

        if (count($data) > 2) {
            return $this->response->internalServerError('Too many data');
        }

        $token = $_COOKIE['cookie-session'];
        $userId = Auth::decodeToken($token)['id'];
        
        $data['user'] = $this->db->__get('users')->findOne(['_id' => new ObjectId($userId)]);

        $this->wishlists->update($data);
    }

    public function delete(string $id): void
    {
        $this->wishlists->deleteById($id);
    }

    public function getUserWishlists(string $id): array
    {
        $user = $this->db->__get('users')->findOne(['_id' => new ObjectId($id)]);

        $wishldist = $this->db->__get('wishlists')->find(
            ['user._id' => new ObjectId($id)],
            ['projection' => 
                [
                    'user' => 0,
                    'edition.wishlists' => 0,
                    'edition.libraries' => 0,
                ],
            ]
        )->toArray();

        //same above excpet with aggregate
        $wishlist = $this->db->wishlists->aggregate([
            ['$match' => ['user._id' => new ObjectId($id)]],
            ['$project' => [
                'user' => 0,
                'edition.wishlists' => 0,
                'edition.libraries' => 0,
            ]],
            ['$facet' => [
                'count' => [['$count' => 'total']],
                'wishlist' => []
            ]]
        ])->toArray();


        return $wishlist;
    }
}
