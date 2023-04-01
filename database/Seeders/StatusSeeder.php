<?php

namespace Database\Seeders;

use App\Models\Status;

class StatusSeeder
{
    public static function seed(): void
    {
        $statuses = [
            [
                'name' => 'To read',
            ],
            [
                'name' => 'Currently reading',
            ],
            [
                'name' => 'Read',
            ]
        ];

        foreach ($statuses as $status) {
            (new Status())->create($status);
        }
    }
}