<?php

namespace Core\Database;

class QueryMethodsExtends
{
    public static function findAllBy(
        string $table,
        string $field,
        string|int $value
    ): array
    {
      $db = (new Database())->connect()->__get($table);
      return $db->find([$field => $value])->toArray();
    }

    /**
     *
     * @param string $table
     * @param array $fields
     * @param array $values
     * @return void
     */
    public static function deleteBy(string $table, array $fields, array $values): void
    {
      $db = (new Database())->connect()->__get($table);
      $db->deleteOne(array_combine($fields, $values));
    }
}
