<?php

namespace App\Controllers;

use App\Helpers\ResponseCodeHandler;
use Database\Database;
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