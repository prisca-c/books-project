<?php

namespace Core;

use Core\Database\QueryMethods;
use Helpers\ModelHandler;
use MongoDB\InsertOneResult;

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

    public function findById(int $id): array
    {
        return $this->query->findById($this->table, $id);
    }

    public function findBy(string $field, string $value): array
    {
        return $this->query->findBy($this->table, $field, $value);
    }

    public function deleteById(int $id): array
    {
        $this->query->deleteById($this->table, $id);
        return $this->response->ok('Deleted');
    }

    public function create(array $data): InsertOneResult
    {
        return $this->query->create($this->table, $data);
        //return $this->response->created();
    }

    public function update(array $data): array
    {
        $this->query->update($this->table, $data, $data['id']);
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
