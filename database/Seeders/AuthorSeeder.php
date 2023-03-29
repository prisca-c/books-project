<?php

namespace Database\Seeders;

use App\Models\Author;

class AuthorSeeder
{
    public static function seed(): void
    {
        $authors = [
            ['name' => 'J. K. Rowling'],
            ['name' => 'J. R. R. Tolkien'],
            ['name' => 'George R. R. Martin'],
            ['name' => 'Stephen King']
        ];
        foreach ($authors as $author) {
            (new Author())->create($author);
        }
    }
}