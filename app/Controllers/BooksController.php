<?php

namespace App\Controllers;

use App\Models\Book;
use Core\Controller;
use MongoDB\Model\BSONDocument;

class BooksController extends Controller
{
    private Book $books;

    public function __construct()
    {
        parent::__construct();
        $this->books = new Book();
    }

    public function index(): array
    {
        return $this->books->findAll();
    }

    public function show(string|int $id): BSONDocument
    {
        return $this->books->findById($id);
    }

    public function store(array $data): array
    {
        $data = $data['data'];
        
        $authors = $data['authors'];
        $tags = $data['tags'];
        $synopsis = $data['synopsis'];
        $title = $data['title'];
        $published_at = $data['published_at'];

        if (empty($authors) || empty($tags) || empty($synopsis) || empty($title) || empty($published_at)) {
            return $this->response->internalServerError('Missing data');
        }

        if (count($data) > 5) {
            return $this->response->internalServerError('Too many data');
        }

        $data['reviews'] = ['rating' => null, 'ratings' => []];
        $data['editions'] = [];

        $this->books->create($data);
        return $this->response->created();
    }

    public function update(array $data): void
    {
        $this->books->update($data);
    }

    public function delete(string $id): void
    {
        $this->books->deleteById($id);
    }

    public function searchBooks(array $data): array
    {
        $data = $data['data'];
        $search = $data['search'];
        $page = $data['page'];
        $skip = ($page - 1) * 10;

        $query = $this->db->books->aggregate([
            ['$lookup' => [
                'from' => 'editions',
                'localField' => 'editions',
                'foreignField' => '_id',
                'as' => 'editionsList'
            ]],
            ['$match' => [
                '$or' => [
                    ['title' => ['$regex' => $search, '$options' => 'i']],
                    ['authors' => ['$regex' => $search, '$options' => 'i']],
                    ['tags' => ['$regex' => $search, '$options' => 'i']],
                    ['editionsList.format' => ['$regex' => $search, '$options' => 'i']],
                    ['editionsList.publisher' => ['$regex' => $search, '$options' => 'i']]
                ]
            ]],
            ['$limit' => 10],
            ['$skip' => $skip],
            ['$sort' => ['published_at' => -1]]
         ]);
        
        return $query->toArray(); 
    }
}
