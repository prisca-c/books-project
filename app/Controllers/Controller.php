<?php

namespace App\Controllers;

use App\Database\Database;
use App\Helpers\ResponseCodeHandler;
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