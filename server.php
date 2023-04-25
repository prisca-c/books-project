<?php

require 'vendor/autoload.php';

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Content-Type': 'application/json");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

use Core\EnvLoader;
use Routes\Routes;

Routes::routes();
EnvLoader::envLoader();

