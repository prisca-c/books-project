<?php

namespace Database\Seeders;

use App\Models\BookTagRelation;
class BookTagRelationSeeder
{
    public static function seed(): void
    {
        $bookTagRelations = [
            ['books_id' => 1, 'tags_id' => 1],
            ['books_id' => 2, 'tags_id' => 1],
            ['books_id' => 3, 'tags_id' => 1],
            ['books_id' => 4, 'tags_id' => 1],
            ['books_id' => 5, 'tags_id' => 1],
            ['books_id' => 6, 'tags_id' => 1],
            ['books_id' => 7, 'tags_id' => 1],
            ['books_id' => 8, 'tags_id' => 3],
            ['books_id' => 1, 'tags_id' => 2],
            ['books_id' => 2, 'tags_id' => 2],
            ['books_id' => 3, 'tags_id' => 2],
            ['books_id' => 4, 'tags_id' => 2],
            ['books_id' => 5, 'tags_id' => 2],
            ['books_id' => 6, 'tags_id' => 2],
            ['books_id' => 7, 'tags_id' => 2],
            ['books_id' => 8, 'tags_id' => 4],
            ['books_id' => 1, 'tags_id' => 4],
            ['books_id' => 2, 'tags_id' => 4],
            ['books_id' => 3, 'tags_id' => 4],
            ['books_id' => 4, 'tags_id' => 4],
            ['books_id' => 5, 'tags_id' => 4],
            ['books_id' => 6, 'tags_id' => 4],
            ['books_id' => 7, 'tags_id' => 4],
            ['books_id' => 8, 'tags_id' => 5],
            ['books_id' => 1, 'tags_id' => 5],
            ['books_id' => 2, 'tags_id' => 5],
            ['books_id' => 3, 'tags_id' => 5],
            ['books_id' => 4, 'tags_id' => 5],
            ['books_id' => 5, 'tags_id' => 5],
            ['books_id' => 6, 'tags_id' => 5],
            ['books_id' => 7, 'tags_id' => 5],
            ['books_id' => 8, 'tags_id' => 6],
            ['books_id' => 1, 'tags_id' => 6],
            ['books_id' => 2, 'tags_id' => 6],
            ['books_id' => 3, 'tags_id' => 6],
            ['books_id' => 4, 'tags_id' => 6],
            ['books_id' => 5, 'tags_id' => 6],
        ];
        foreach ($bookTagRelations as $bookTagRelation) {
            (new BookTagRelation())->create($bookTagRelation);
        }
    }
}