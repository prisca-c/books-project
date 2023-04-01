<?php

namespace Database\Seeders;

use App\Models\Rating;

class RatingSeeder
{
    public static function seed(): void
    {
        $ratings = [
            [
                'users_id' => 1,
                'books_id' => 1,
                'rating' => 5,
                'review' => 'This is a review'
            ],
            [
                'users_id' => 2,
                'books_id' => 2,
                'rating' => 4,
                'review' => 'This is a review'
            ],
            [
                'users_id' => 3,
                'books_id' => 3,
                'rating' => 3,
                'review' => 'This is a review'
            ],
            [
                'users_id' => 4,
                'books_id' => 4,
                'rating' => 2,
                'review' => 'This is a review'
            ],
            [
                'users_id' => 5,
                'books_id' => 5,
                'rating' => 1,
                'review' => 'This is a review'
            ]
        ];
        foreach ($ratings as $rating) {

            (new Rating())->create($rating);
        }
    }
}