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
}