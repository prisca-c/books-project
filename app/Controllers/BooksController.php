<?php

namespace App\Controllers;

use App\Helpers\QueryHandler;
use App\Models\Author;
use App\Models\BookTagRelation;
use App\Models\Book;
use App\Models\Tag;

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
        $books = $this->books->findAll();
        $book_tag_relation_model = new BookTagRelation();
        $tags_model =  new Tag();
        $field = 'books_id';
        foreach ($books as $key => $book) {
            $tags = $book_tag_relation_model->findAllBy($field, $book['id']);
            foreach ($tags as $tag) {
                $books[$key]['tags'][] = $tags_model->findAllBy('id', $tag['tags_id'])[0];
            }
        }
        return $books;
    }

    public function show(array $data): array
    {
        $id = $data['id'];
        $book = $this->books->findById($id);
        $book_tag_relation_model = new BookTagRelation();
        $tags_model =  new Tag();
        $field = 'books_id';
        $tags = $book_tag_relation_model->findAllBy($field, $book['id']);
        foreach ($tags as $tag) {
            $book['tags'][] = $tags_model->findAllBy('id', $tag['tags_id'])[0];
        }
        return $book;
    }

    public function store(array $data): void
    {
        $this->books->create($data);
    }

    public function update(array $data): void
    {
        $this->books->update($data);
    }

    public function delete(array $data): void
    {
        $id = $data['id'];
        $this->books->deleteById($id);
    }

    public function booksByAuthor(array $data): array
    {
        $id = $data['id'];
        $query = $this->books->findAllBy('authors_id', $id);
        $authors_model = new Author();

        foreach ($query as $key => $book) {
            $query[$key]['author'] = $authors_model->findById($book['authors_id']);
        }
        return $query;
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
}