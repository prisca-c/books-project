<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\BookTagRelation;
use App\Models\Tag;
use Core\Controller;
use Helpers\QueryHandler;
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

        $data['rating'] = 0;
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

    public function getTags(array $data): array
    {
        $id = $data['id'];
        $book_tag_relation_model = new BookTagRelation();
        $tags_model =  new Tag();
        $field = 'books_id';
        $tags = $book_tag_relation_model->findAllBy($field, $id);
        foreach ($tags as $tag) {
            $book['tags'][] = $tags_model->findAllBy('id', $tag['tags_id'])[0];
        }
        if (empty($book['tags'])) {
            $book['tags'] = [];
        }
        return $book;
    }

    public function booksByAuthor(array $data): array
    {
        return $this->books->findAllBy('authors_id', $data['id']);
    }

    public function booksByTagId(array $data): array
    {
        $id = $data['id'];
        $query = $this->db->prepare(
            'SELECT books.id, books.title, authors.name AS author_name, publishers.name AS publisher_name,
                (
                    SELECT JSON_ARRAYAGG(JSON_OBJECT("id", tags.id, "name", tags.name))
                    FROM book_tag_relations
                    LEFT JOIN tags ON tags.id = book_tag_relations.tags_id
                    WHERE book_tag_relations.books_id = books.id
                ) AS tags
            FROM books
            LEFT JOIN authors ON authors.id = books.authors_id
            LEFT JOIN book_tag_relations ON book_tag_relations.books_id = books.id
            LEFT JOIN publishers ON publishers.id = books.publishers_id
            LEFT JOIN tags ON tags.id = book_tag_relations.tags_id
            WHERE tags.id = :id
            GROUP BY books.id'
        );
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetchAll();
        $values = ['tags'];
        return QueryHandler::queryValueToJSON($result, $values);
    }

    public function addTag(array $data): void
    {
        $book_tag_relation_model = new BookTagRelation();
        $book_tag_relation_model->create($data);
    }

    public function removeTag(array $data): array
    {
        $book_tag_relation_model = new BookTagRelation();
        return $book_tag_relation_model->deleteBy($data);
    }

    public function getBookRating(array $data): array
    {
        $id = $data['id'];
        $query = $this->db->prepare(
            'SELECT books_id, ROUND(AVG(rating),2) AS rating
            FROM ratings 
            WHERE books_id = :id
            GROUP BY books_id'
        );
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetchAll();
    }

    public function searchBooks(array $data): array
    {
        $search = $data['search'];
        $page = $data['page'];
        $skip = ($page - 1) * 10;
        $query = $this->db->books->aggregate([
            ['$lookup' => [
                'from' => 'editions',
                'localField' => 'editions',
                'foreignField' => '_id',
                'as' => 'editionsList',
            ]],
            ['$match' => [
                '$or' => [
                    ['title' => ['$regex' => $search, '$options' => 'i']],
                    ['authors' => ['$regex' => $search, '$options' => 'i']],
                    ['editionsList.format' => ['$regex' => $search, '$options' => 'i']],
                    ['editionsList.publisher' => ['$regex' => $search, '$options' => 'i']],
                    ['tags' => ['$regex' => $search, '$options' => 'i']]
                ]
            ]]
         ]);
        
        return $query->toArray(); 
    }
}
