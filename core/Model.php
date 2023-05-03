<?php

namespace Core;

use Core\Database\QueryMethods;
use Helpers\ModelHandler;
use MongoDB\InsertOneResult;
use MongoDB\Model\BSONDocument;

abstract class Model
{
    protected string $table;
    protected string $model;
    protected array $fillable = [];
    protected ResponseCodeHandler $response;
    protected QueryMethods $query;

    public function __construct()
    {
        $this->model = (new \ReflectionClass($this))->getShortName();
        $this->table = ModelHandler::tableName($this->model);
        $this->response = new ResponseCodeHandler();
        $this->query = new QueryMethods();
    }

    public function findAll(): array
    {
        return $this->query->findAll($this->table);
    }

    public function findById(string $id): BSONDocument
    {
        return $this->query->findById($this->table, $id);
    }

    public function findBy(string $field, string $value): array
    {
        return $this->query->findBy($this->table, $field, $value);
    }

    public function findByOne(string $field, string $value): BSONDocument | null
    {
        return $this->query->findByOne($this->table, $field, $value);
    }

    public function deleteById(string $id): array
    {
        $this->query->deleteById($this->table, $id);
        return $this->response->ok('Deleted');
    }

    public function create(array $data): InsertOneResult
    {
        return $this->query->create($this->table, $data);
        //return $this->response->created();
    }

    public function update(BSONDocument $data): array
    {
        $this->query->update($this->table, $data, $data['_id']);
        return $this->response->ok('Updated');
    }

    public function findAllBy(string $field, string $value): array
    {
        return $this->query->findAllBy($this->table, $field, $value);
    }

    public function deleteBy(array $data): array
    {
        $this->query->deleteBy($this->table, $data);
        return $this->response->ok('Deleted');
    }

    public function getFields(): array
    {
        return $this->fillable;
    }

    public function __toString(): string
    {
        return $this->table;
    }
}
