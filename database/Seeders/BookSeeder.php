<?php

namespace Database\Seeders;

use App\Models\Book;
use Core\Database\Database;
use Core\Database\QueryMethods;
class BookSeeder
{
    public static function seed(): void
    {
        $books = [
            ['title' => 'Harry Potter and the Philosopher\'s Stone', 'authors_id' => 1, 'publishers_id' => 1, 'published_at' => '1997', 'synopsis' => 'Harry Potter is a wizard.'],
            ['title' => 'Harry Potter and the Chamber of Secrets', 'authors_id' => 1, 'publishers_id' => 1, 'published_at' => '1998', 'synopsis' => 'Harry Potter is a wizard.'],
            ['title' => 'The Fellowship of the Ring', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1954', 'synopsis' => 'The Fellowship of the Ring is a novel by J. R. R. Tolkien.'],
            ['title' => 'The Two Towers', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1954', 'synopsis' => 'The Two Towers is a novel by J. R. R. Tolkien.'],
            ['title' => 'The Return of the King', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1955', 'synopsis' => 'The Return of the King is a novel by J. R. R. Tolkien.'],
            ['title' => 'A Game of Thrones', 'authors_id' => 3, 'publishers_id' => 3, 'published_at' => '1996', 'synopsis' => 'A Game of Thrones is a fantasy novel by American author George R. R. Martin.'],
            ['title' => 'A Clash of Kings', 'authors_id' => 3, 'publishers_id' => 3, 'published_at' => '1998', 'synopsis' => 'A Clash of Kings is a fantasy novel by American author George R. R. Martin.'],
            ['title' => 'The Shining', 'authors_id' => 4, 'publishers_id' => 4, 'published_at' => '1977', 'synopsis' => 'The Shining is a horror novel by American author Stephen King.']
        ];

        //foreach ($books as $book) {
        //    (new Database)->connect()->books->insertOne($book);
        //}
        //

        (new Database)->connect()->books->insertMany($books);
    }
}
