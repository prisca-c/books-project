<?php

namespace App\Controllers;

use App\Models\Author;
use App\Models\Book;
use Core\Controller;

class AuthorsController extends Controller
{
    public function getAuthorBooks(string $name): array
    {
        // string is a uri encoded string
        $name = urldecode($name);
        return $this->db->books->aggregate([
            ['$match' => ['authors' => $name]],
            ['$facet' => [
                'count' => [['$count' => 'total']],
                'rating' => [
                    ['$unwind' => '$reviews.rating'],
                    ['$group' => ['_id' => $name, 'avg' => ['$avg' => '$reviews.rating']]]
                ],
                'books'=>[]
            ]]
        ])->toArray();
    }
}
