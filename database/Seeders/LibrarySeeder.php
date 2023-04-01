<?php

namespace Database\Seeders;

use App\Models\Library;

class LibrarySeeder
{
    public static function seed(): void
    {
        $libraries = [
            [
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl.',
                'editions_id' => 1,
                'users_id' => 1,
                'status_id' => 1
            ],
            [
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl.',
                'editions_id' => 2,
                'users_id' => 2,
                'status_id' => 3
            ],
            [
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl.',
                'editions_id' => 3,
                'users_id' => 3,
                'status_id' => 1
            ],
            [
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl.',
                'editions_id' => 4,
                'users_id' => 4,
                'status_id' => 2
            ],
            [
                'note' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl. Donec auctor, nisl eget ultricies tincidunt, nisl nisl aliquet nisl, eget aliquet nunc nisl eget nisl.',
                'editions_id' => 5,
                'users_id' => 5,
                'status_id' => 1
            ]
        ];
        foreach ($libraries as $library) {

            (new Library())->create($library);
        }
    }
}