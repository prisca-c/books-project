<?php

namespace Core\Database;


class QueryMethods extends QueryMethodsExtends
{
    public static function findAll(string $table): array
    {
        $query = (new Database)->connect()->__get($table);
        return $query->find()->toArray();
    }

    public static function findById(string $table, int $id): array
    {
      $query = (new Database)->connect()->__get($table);
      return $query->find($id)->toArray();
    }

    /**
     *
     * @param string $table
     * @param array $data
     * @return void
     */
    public static function create(string $table, array $data):void
    {
      $query = (new Database)->connect()->__get($table);
      $query->insertOne($data);
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
      $query = (new Database)->connect()->__get($table);
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
      $query = (new Database)->connect()->__get($table);
      $query->deleteOne($id);
    }
}
