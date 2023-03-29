<?php

namespace Database\Seeders;

class Seeder
{

    public function __construct()
    {
    }

    public static function run(): void
    {
        AuthorSeeder::seed();
        PublisherSeeder::seed();
        TagSeeder::seed();
        UserSeeder::seed();
        BookSeeder::seed();
        BookTagRelationSeeder::seed();
    }
}