<?php

namespace Core;

use Dotenv\Dotenv;

class EnvLoader
{
    public static function envLoader(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
        $dotenv->load();
    }
}

