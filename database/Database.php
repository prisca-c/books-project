<?php

namespace database;

use PDO;

class Database
{
    /* define the database connection */
    private string $servername = "localhost:3306";
    private string $username = "root";
    private string $password = "root";
    private string $dbname = "database_course_creative";

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