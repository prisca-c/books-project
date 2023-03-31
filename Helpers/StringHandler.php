<?php

namespace Helpers;

class StringHandler
{
    public static function toSnakeCase(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

    public static function pluralize(string $string): string
    {
        if (str_ends_with($string, 'y')) {
            return substr($string, 0, -1) . 'ies';
        } elseif (str_ends_with($string, 's')) {
            return $string;
        } else {
            return $string . 's';
        }
    }
}