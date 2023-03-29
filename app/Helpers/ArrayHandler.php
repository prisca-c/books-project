<?php

namespace App\Helpers;

class ArrayHandler
{
    public static function implodeArray(array $array, string $separator): string
    {
        return implode($separator, $array);
    }

    public static function explodeArray(string $string, string $separator): array
    {
        return explode($separator, $string);
    }

    public static function mapArray(array $array, callable $callback): array
    {
        return array_map($callback, $array);
    }
}