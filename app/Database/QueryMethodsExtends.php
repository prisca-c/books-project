<?php

namespace App\Database;

use App\Helpers\ArrayHandler;

class QueryMethodsExtends extends QueryMethods
{
    public static function findAllBy(
        string $table,
        array $selectedFields,
        string $field,
        string|int $value
    ): array
    {
        $db = (new Database())->connect();
        $selectedFields = ArrayHandler::implodeArray($selectedFields, ', ');

        $sql = "SELECT $selectedFields FROM $table WHERE $field = :value";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}