<?php

namespace Helpers;

class ModelHandler
{
    public static function tableName(string $model): string
    {
        $model = StringHandler::pluralize($model);
        return StringHandler::toSnakeCase($model);
    }
}