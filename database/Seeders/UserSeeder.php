<?php

namespace Database\Seeders;

use App\Models\User;
class UserSeeder
{
    public static function seed(): void
    {
        $users = [
            ['username' => 'johndoe', 'password' => 'password', 'email' => 'johndoe@gmail.com'],
            ['username' => 'janedoe', 'password' => 'password', 'email' => 'janedoe@gmail.com'],
            ['username' => 'awesomeuser', 'password' => 'password', 'email' => 'awesomeuser@gmail.com'],
            ['username' => 'cooluser', 'password' => 'password', 'email' => 'cooluser@gmail.com'],
            ['username' => 'randomuser', 'password' => 'password', 'email' => 'randomuser@gmail.com']
        ];
        foreach ($users as $user) {
            (new User())->create($user);
        }
    }
}