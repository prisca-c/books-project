<?php

namespace Database\Seeders;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

class Seeder
{

    public function __construct()
    {
    }

    public static function run(): void
    {
        AuthorSeeder::seed();
        PublisherSeeder::seed();
        StatusSeeder::seed();
        TagSeeder::seed();
        UserSeeder::seed();
        BookSeeder::seed();
        BookTagRelationSeeder::seed();
        EditionSeeder::seed();
        LibrarySeeder::seed();
        WishlistSeeder::seed();
        RatingSeeder::seed();
    }
}