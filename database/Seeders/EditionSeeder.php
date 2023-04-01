<?php

namespace Database\Seeders;

use App\Models\Edition;

class EditionSeeder
{
    public static function seed(): void
    {
        $editions = [
            [
                'format' => 'MinaLima Edition',
                'description' => 'This is a MinaLima Edition',
                'books_id' => 1,
                'image' => 'https://m.media-amazon.com/images/I/91r0dvXhNGL.jpg',
                'published_at' => '2021'
            ],
            [
                'format' => 'Illustrated Edition',
                'description' => 'This is an illustrated edition',
                'books_id' => 1,
                'image' => 'https://m.media-amazon.com/images/I/515BXreGGoL._SX421_BO1,204,203,200_.jpg',
                'published_at' => '2021'
            ],
            [
                'format' => 'MinaLima Edition',
                'description' => 'This is a MinaLima Edition',
                'books_id' => 2,
                'image' => 'https://m.media-amazon.com/images/I/5128SJqk8bL._SX327_BO1,204,203,200_.jpg',
                'published_at' => '2021'
            ],
            [
                'format' => 'Pocket\'s Edition',
                'description' => 'This is a pocket\'s edition',
                'books_id' => 2,
                'published_at' => '2021'
            ],
            [
                'format' => 'Limited Edition',
                'description' => 'This is a limited edition',
                'books_id' => 3,
                'published_at' => '2021'
            ],
            [
                'format' => 'Collector\'s Edition',
                'description' => 'This is a collector\'s edition',
                'books_id' => 4,
                'published_at' => '2021'
            ],
            [
                'format' => 'Collector\'s Edition',
                'description' => 'This is a collector\'s edition',
                'books_id' => 5,
                'published_at' => '2021'
            ],
            [
                'format' => 'Collector\'s Edition',
                'description' => 'This is a collector\'s edition',
                'books_id' => 6,
                'published_at' => '2021'
            ],
            [
                'format' => 'Collector\'s Edition',
                'description' => 'This is a collector\'s edition',
                'books_id' => 7,
                'published_at' => '2021'
            ],
            [
                'format' => 'Collector\'s Edition',
                'description' => 'This is a collector\'s edition',
                'books_id' => 8,
                'published_at' => '2021'
            ],
        ];

        foreach ($editions as $edition) {
            (new Edition())->create($edition);
        }
    }
}