<?php

namespace Core\Database;

use Core\EnvLoader;
use Dotenv\Dotenv;
use MongoDB;
use MongoDB\Client;
use PDO;

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
    public function connect(): Client
    {
        $uri = 'mongodb://localhost:27017';
        return new MongoDB\Client($uri);
    }

    public static function drop(): void
    {

//        EnvLoader::envLoader();
//
//        $db = (new Database())->connect();
//        $tables = $db->query("SHOW TABLES")->fetchAll();
//        $db->query("SET FOREIGN_KEY_CHECKS = 0");
//        $database = database_config::getDbName();
//        foreach ($tables as $table) {
//            $table = $table['Tables_in_'.$database];
//            $db->query("DROP TABLE $table");
//        }
//        $db->query("SET FOREIGN_KEY_CHECKS = 1");
    }


}
