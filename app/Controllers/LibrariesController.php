<?php

namespace App\Controllers;

use App\Models\Library;
use Core\Auth;
use Core\Controller;
use MongoDB\BSON\ObjectId;
use MongoDB\Model\BSONDocument;

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

    public function show(string $id): BSONDocument
    {
        return $this->libraries->findById($id);
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
        $data['user'] = $this->db->__get('users')->findOne(['_id' => new ObjectId($userId)]);

        $result = $this->libraries->create($data);

        $this->db->__get('users')->updateOne(
            ['_id' => new ObjectId($userId)],
            ['$push' => ['libraries' => $result->getInsertedId()]]
        );

        $this->db->__get('editions')->updateOne(
            ['_id' => new ObjectId($edition['_id']['$oid'])],
            ['$push' => ['libraries' => $result->getInsertedId()]]
        );

        return $this->response->created();
    }

    public function update(array $data): array
    {
        $data = $data['data'];
        $id = $data['_id'];
        $edition = $data['edition'];

        if (empty($id) || empty($edition)) {
            return $this->response->internalServerError('Missing data');
        }

        if (count($data) > 2) {
            return $this->response->internalServerError('Too many data');
        }

        $token = $_COOKIE['cookie-session'];
        $userId = Auth::decodeToken($token)['id'];

        $user = $this->db->__get('users')->findOne(['_id' => new ObjectId($userId)]);
        $data['user'] = $user;
        
        $this->libraries->update($data);
    }

    public function delete(string $id): void
    {
        $this->db->__get('editions')->updateOne(
            ['libraries' => new ObjectId($id)],
            ['$pull' => ['libraries' => new ObjectId($id)]]
        );

        $this->db->__get('users')->updateOne(
            ['libraries' => new ObjectId($id)],
            ['$pull' => ['libraries' => new ObjectId($id)]]
        );

        $this->libraries->deleteById($id);
    }

    public function getUserLibraries(string $id): array
    {
        $user = $this->db->__get('users')->findOne(['_id' => new ObjectId($id)]);
        $libraries = $this->db->__get('libraries')->find(
            ['user._id' => new ObjectId($user['_id'])],
            ['projection' => 
                [
                    'user' => 0,
                    'edition.wishlists' => 0,
                    'edition.libraries' => 0
                ]
            ]
        )->toArray();

        $payload = [
            'count' => count($libraries),
            'libraries' => $libraries
        ];

        return $payload;
    }
}
