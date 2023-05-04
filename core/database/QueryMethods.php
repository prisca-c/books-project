<?php

namespace Core\Database;

use MongoDB\InsertOneResult;
use MongoDB\Model\BSONDocument;
use webObj;


class QueryMethods extends QueryMethodsExtends
{
    public static function findAll(string $table): array
    {
        $query = (new Database)->connect()->$table;
        return $query->find()->toArray();
    }

    public static function findById(string $table, string $id): BSONDocument
    {
      $query = (new Database)->connect()->$table;
      return $query->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
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

    public static function findByOne(string $table, $field, $value): BSONDocument | null
    {
      $query = (new Database)->connect()->$table;
      return $query->findOne([$field => $value]);
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
      $data['created_at'] = date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');
      return $query->insertOne($data);
    }

    /**
     *
     * @param string $table
     * @param array $data
     * @param integer $id
     * @return void
     */
    public static function update(string $table, BSONDocument $data, string $id): void
    {
      $query = (new Database)->connect()->$table;
      $data['updated_at'] = date('Y-m-d H:i:s');
      $query->updateOne(['_id' => new \MongoDB\BSON\ObjectId($id)], ['$set' => $data]);
    }

    /**
     *
     * @param string $table
     * @param integer $id
     * @return void
     */
    public static function deleteById(string $table, string $id): void
    {
      $query = (new Database)->connect()->$table;
      $query->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
    }
}
