<?php

require 'vendor/autoload.php';

use Core\Database\Database;
use Core\EnvLoader;
use Routes\Middleware;
use Routes\Routes;

EnvLoader::envLoader();

Middleware::headers();

Routes::routes();

require 'vendor/autoload.php';

$database = new Database;
try {
  $database->connect()->selectDatabase('books')->command(['ping' => 1]);
  echo "Pinged your deployment. You successfully connected to MongoDB!\n";
} catch(Exception $e)
{
  echo $e;
};
