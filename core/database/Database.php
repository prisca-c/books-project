<?php

namespace Core\Database;

use Core\EnvLoader;
use Dotenv\Dotenv;
use MongoDB;
use MongoDB\Client;
use MongoDB\Database as MongoDBDatabase;

class Database
{
    /* define the database connection */
    private string $servername;
    private string $username;
    private string $password;
    private string $dbname;

    public function __construct()
    {
//        $this->servername = database_config::getDbHost();
//        $this->username = database_config::getDbUser();
//        $this->password = database_config::getDbPassword();
//        $this->dbname = database_config::getDbName();
    }

    /* connect to mysql database */
    public function connect(): MongoDBDatabase
    {
        $uri = 'mongodb://localhost:27017';
        $client = new MongoDB\Client($uri);
        return $client->selectDatabase('books');
    }

    public static function drop(): void
    {
      (new Database)->connect()->drop();
    }


}
