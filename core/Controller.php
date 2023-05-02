<?php

namespace Core;

use Core\Database\Database;
use MongoDB\Database as MongoDBDatabase;

abstract class Controller
{
    protected MongoDBDatabase $db;
    protected ResponseCodeHandler $response;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        $this->response = new ResponseCodeHandler();
    }
}
