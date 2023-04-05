<?php

namespace Core;

use Core\Database\Database;
use PDO;

abstract class Controller
{
    protected PDO $db;
    protected ResponseCodeHandler $response;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }
}