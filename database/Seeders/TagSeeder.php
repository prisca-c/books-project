<?php

namespace Database\Seeders;

use App\Models\Tag;
class TagSeeder
{
    public static function seed(): void
    {
        $tags = [
            ['name' => 'Fantasy'],
            ['name' => 'Science Fiction'],
            ['name' => 'Horror'],
            ['name' => 'Romance'],
            ['name' => 'Mystery'],
            ['name' => 'Thriller'],
            ['name' => 'Historical Fiction'],
            ['name' => 'Biography'],
            ['name' => 'Autobiography'],
            ['name' => 'Memoir'],
            ['name' => 'Self Help'],
            ['name' => 'Cookbook'],
            ['name' => 'Guide'],
            ['name' => 'Travel'],
            ['name' => 'Children\'s'],
        ];
        foreach ($tags as $tag) {
            (new Tag())->create($tag);
        }
    }
}