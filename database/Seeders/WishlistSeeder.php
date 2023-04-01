<?php

namespace Database\Seeders;

use App\Models\Wishlist;

class WishlistSeeder
{
    public static function seed(): void
    {
        $wishlists = [
            [
                'users_id' => 1,
                'editions_id' => 1
            ],
            [
                'users_id' => 2,
                'editions_id' => 2
            ],
            [
                'users_id' => 5,
                'editions_id' => 3
            ],
            [
                'users_id' => 5,
                'editions_id' => 4
            ],
            [
                'users_id' => 3,
                'editions_id' => 5
            ],
            [
                'users_id' => 3,
                'editions_id' => 6
            ],
            [
                'users_id' => 3,
                'editions_id' => 4
            ],
            [
                'users_id' => 4,
                'editions_id' => 1
            ],
            [
                'users_id' => 4,
                'editions_id' => 2
            ]
        ];

        foreach ($wishlists as $wishlist) {
            (new Wishlist())->create($wishlist);
        }
    }
}