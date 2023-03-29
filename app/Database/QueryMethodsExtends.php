<?php

namespace App\Database;

use App\Helpers\ArrayHandler;

class QueryMethodsExtends extends QueryMethods
{
    public static function findAllBy(
        string $table,
        string $field,
        string|int $value
    ): array
    {
        $db = (new Database())->connect();

        $sql = "SELECT * FROM $table WHERE $field = :value";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function deleteBy(string $table, array $fields, array $values): void
    {
        if (count($fields) === 1) {
            $query = (new Database)->connect()->prepare(
                "DELETE FROM $table WHERE $fields[0] = :$fields[0]"
            );
        } else {
            $query = (new Database)->connect()->prepare(
                "DELETE FROM $table WHERE " . implode(' AND ', array_map(fn ($item) => "$item = :$item", $fields))
            );
        }

        foreach ($fields as $field) {
            var_dump($values[$field]);
            $query->bindParam(":$field", $values[$field]);
        }

        $query->execute();
    }
}