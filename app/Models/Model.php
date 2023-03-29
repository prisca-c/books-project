<?php

namespace App\Models;

use App\Database\QueryMethods;
use App\Helpers\ResponseCodeHandler;

class Model
{
    protected string $table;
    protected array $fillable = [];
    protected ResponseCodeHandler $response;
    protected QueryMethods $query;

    public function __construct()
    {
        $this->table = strtolower((new \ReflectionClass($this))->getShortName()) . 's';
        $this->response = new ResponseCodeHandler();
        $this->query = new QueryMethods();
    }

    public function findAll(): array
    {
        return $this->query->findAll($this->table, $this->fillable);
    }

    public function findById(int $id): array
    {
        return $this->query->findById($this->table, $id, $this->fillable);
    }

    public function deleteById(int $id): array
    {
        $this->query->deleteById($this->table, $id);
        return $this->response->ok('User deleted');
    }

    public function create(array $data): array
    {
        $this->query->create($this->table, $data, $this->fillable);
        return $this->response->ok('User created');
    }

    public function update(array $data): array
    {
        $this->query->update($this->table, $data, $this->fillable, $data['id']);
        return $this->response->ok('User updated');
    }

    public function findAllBy(string $field, string $value): array
    {
        return $this->query->findAllBy($this->table, $this->fillable, $field, $value);
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