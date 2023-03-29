<?php

namespace Database\Seeders;

use App\Models\Book;
class BookSeeder
{
    public static function seed(): void
    {
        $books = [
            ['title' => 'Harry Potter and the Philosopher\'s Stone', 'authors_id' => 1, 'publishers_id' => 1, 'published_at' => '1997-06-26'],
            ['title' => 'Harry Potter and the Chamber of Secrets', 'authors_id' => 1, 'publishers_id' => 1, 'published_at' => '1998-07-02'],
            ['title' => 'The Fellowship of the Ring', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1954-07-29'],
            ['title' => 'The Two Towers', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1954-11-11'],
            ['title' => 'The Return of the King', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1955-10-20'],
            ['title' => 'A Game of Thrones', 'authors_id' => 3, 'publishers_id' => 3, 'published_at' => '1996-08-01'],
            ['title' => 'A Clash of Kings', 'authors_id' => 3, 'publishers_id' => 3, 'published_at' => '1998-11-16'],
            ['title' => 'The Shining', 'authors_id' => 4, 'publishers_id' => 4, 'published_at' => '1977-01-28']
        ];

        foreach ($books as $book) {
            (new Book())->create($book);
        }
    }
}