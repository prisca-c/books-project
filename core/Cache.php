<?php

namespace Core;

class Cache
{
    public static $redis;

    public static function init(): void
    {
        try
        {
            self::$redis = new \Redis();
            self::$redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
        }
        catch (\RedisException $e)
        {
        }
    }

    public static function __callStatic(string $method, array $arguments)
    {
        return call_user_func_array([self::redis(), $method], $arguments);
    }

    public static function redis():\Redis
    {
        if(!self::$redis)
        {
            self::init();
        }

        return self::$redis;
    }
}

