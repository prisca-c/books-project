<?php

require 'vendor/autoload.php';

use Core\EnvLoader;
use Routes\Middleware;
use Routes\Routes;

EnvLoader::envLoader();

Middleware::headers();

Routes::routes();

