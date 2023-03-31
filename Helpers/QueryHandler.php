<?php

namespace Helpers;

class QueryHandler
{
    public static function queryValueToJSON(array $data, array $setValues): array
    {
        foreach ($data as $key => $value) {
            foreach ($setValues as $setValue) {
                if (isset($value[$setValue])) {
                    $data[$key][$setValue] = json_decode($value[$setValue]);
                } else {
                    $data[$key][$setValue] = [];
                }
            }
        }
        return $data;
    }

    public static function querySetMapFromArray(string $separator, array $data, array $setValues): string
    {
        return ArrayHandler::implodeArray(
            ArrayHandler::mapArray($data, fn ($item) => "$item = :$item"),
            $separator
        );
    }
}