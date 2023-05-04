<?php

namespace App\Controllers;

use App\Models\Edition;
use Core\Controller;
use MongoDB\BSON\ObjectId;
use MongoDB\Model\BSONDocument;

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

    public function show(string $id): BSONDocument
    {
        return $this->editions->findById($id);
    }

    public function store(array $data): array
    {
        $data = $data['data'];
        $format = $data['format'];
        $description = $data['description'];
        $image = $data['image'];
        $book = $data['book'];
        $publisher = $data['publisher'];
        $published_at = $data['published_at'];

        if (empty($format) || empty($description) || empty($image) || empty($book) || empty($publisher) || empty($published_at)) {
            return $this->response->internalServerError('Missing data');
        }

        if (count($data) > 6) {
            return $this->response->internalServerError('Too many data');
        }

        $data['libraries'] = [];
        $data['wishlists'] = [];

        $editions = $this->editions->create($data);
        $this->db->books->updateOne(
            ['_id' => new ObjectId($book['_id']['$oid'])],
            ['$push' => ['editions' => $editions->getInsertedId()]]
        );

        return $this->response->created();
    }

    public function update(array $data): void
    {
        $this->editions->update($data);
    }

    public function delete(string $id): void
    {
        $this->editions->deleteById($id);
        $this->db->books->updateOne(
            ['editions' => $id],
            ['$pull' => ['editions' => $id]]
        );
    }
}
