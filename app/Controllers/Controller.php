<?php

namespace App\Controllers;

use Database\Database;
use Helpers\ResponseCodeHandler;
use PDO;

class Controller
{
    protected PDO $db;
    protected ResponseCodeHandler $response;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }
}