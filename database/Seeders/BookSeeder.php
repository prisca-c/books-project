<?php

namespace Database\Seeders;

use App\Models\Book;
class BookSeeder
{
    public static function seed(): void
    {
        $books = [
            ['title' => 'Harry Potter and the Philosopher\'s Stone', 'authors_id' => 1, 'publishers_id' => 1, 'published_at' => '1997'],
            ['title' => 'Harry Potter and the Chamber of Secrets', 'authors_id' => 1, 'publishers_id' => 1, 'published_at' => '1998'],
            ['title' => 'The Fellowship of the Ring', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1954'],
            ['title' => 'The Two Towers', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1954'],
            ['title' => 'The Return of the King', 'authors_id' => 2, 'publishers_id' => 2, 'published_at' => '1955'],
            ['title' => 'A Game of Thrones', 'authors_id' => 3, 'publishers_id' => 3, 'published_at' => '1996'],
            ['title' => 'A Clash of Kings', 'authors_id' => 3, 'publishers_id' => 3, 'published_at' => '1998'],
            ['title' => 'The Shining', 'authors_id' => 4, 'publishers_id' => 4, 'published_at' => '1977']
        ];

        foreach ($books as $book) {
            (new Book())->create($book);
        }
    }
}