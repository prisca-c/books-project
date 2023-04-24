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
        call_user_func_array([self::getRedis(), $method], $arguments);
    }

    protected static function getRedis():\Redis
    {
        if(!self::$redis)
        {
            self::init();
        }

        return self::$redis;
    }
}

