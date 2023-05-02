<?php

namespace Core\Database;

use MongoDB\InsertOneResult;


class QueryMethods extends QueryMethodsExtends
{
    public static function findAll(string $table): array
    {
        $query = (new Database)->connect()->$table;
        return $query->find()->toArray();
    }

    public static function findById(string $table, int $id): array
    {
      $query = (new Database)->connect()->$table;
      return $query->find($id)->toArray();
    }

    /**
     *
     * @param string $table
     * @param string $field
     * @param string $value
     * @return array
     */
    public static function findBy(string $table, $field, $value): array
    {
      $query = (new Database)->connect()->$table;
      return $query->find([$field => $value])->toArray();
    }

    /**
     *
     * @param string $table
     * @param array $data
     * @return InsertOneResult
     */
    public static function create(string $table, array $data): InsertOneResult
    {
      $query = (new Database)->connect()->__get($table);
      return $query->insertOne($data);
    }

    /**
     *
     * @param string $table
     * @param array $data
     * @param integer $id
     * @return void
     */
    public static function update(string $table, array $data, int $id): void
    {
      $query = (new Database)->connect()->$table;
      $query->updateOne($data, $id);
    }

    /**
     *
     * @param string $table
     * @param integer $id
     * @return void
     */
    public static function deleteById(string $table, int $id): void
    {
      $query = (new Database)->connect()->$table;
      $query->deleteOne($id);
    }
}
