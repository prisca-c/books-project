<?php

namespace Database\Seeders;

use App\Models\Publisher;

class PublisherSeeder
{
    public static function seed(): void
    {
        $publishers = [
            ['name' => 'Hachette Livre'],
            ['name' => 'Editis'],
            ['name' => 'Gallimard'],
            ['name' => 'La Martinière'],
            ['name' => 'Libella'],
            ['name' => 'Aparis'],
            ['name' => 'Albin Michel']
        ];
        foreach ($publishers as $publisher) {
            (new Publisher())->create($publisher);
        }
    }
}