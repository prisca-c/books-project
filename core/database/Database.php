<?php

namespace Core\Database;

use Config\database_config;
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
        $this->servername = database_config::$db_host;
        $this->username = database_config::$db_user;
        $this->password = database_config::$db_password;
        $this->dbname = database_config::$db_name;
    }

    /* connect to mysql database */
    public function connect(): PDO
    {
        return new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public static function drop(): void
    {
        $db = (new Database())->connect();
        $tables = $db->query("SHOW TABLES")->fetchAll();
        $db->query("SET FOREIGN_KEY_CHECKS = 0");
        $database = database_config::$db_name;
        foreach ($tables as $table) {
            $table = $table['Tables_in_'.$database];
            $db->query("DROP TABLE $table");
        }
        $db->query("SET FOREIGN_KEY_CHECKS = 1");
    }


}