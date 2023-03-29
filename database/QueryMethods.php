<?php

namespace Database;

use App\Helpers\ArrayHandler;

class QueryMethods extends QueryMethodsExtends
{
    public static function findAll(string $table, array $selectedFields = ['*']): array
    {
        $selectedFields = ArrayHandler::implodeArray($selectedFields, ', ');
        $query = (new Database)->connect()->prepare(
            "SELECT * FROM $table"
        );
        $query->execute();
        return $query->fetchAll();
    }

    public static function findById(string $table, int $id, array $selectedFields = ['*']): array
    {
        $selectedFields = ArrayHandler::implodeArray($selectedFields, ', ');
        $query = (new Database)->connect()->prepare(
            "SELECT * FROM $table WHERE id = :id"
        );
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch();
    }

    public static function create(string $table, array $data, array $fillable): void
    {
        $query = (new Database)->connect()->prepare(
            "INSERT INTO $table (" . implode(',', $fillable) . ") 
            VALUES (" . implode(',', array_map(fn ($item) => ":$item", $fillable)) . ")"
        );
        foreach ($fillable as $item) {
            $query->bindParam(":$item", $data[$item]);
        }
        $query->execute();
    }

    public static function update(string $table, array $data, array $fillable, int $id): void
    {
        $query = (new Database)->connect()->prepare(
            "UPDATE $table 
            SET " . implode(',', array_map(fn ($item) => "$item = :$item", $fillable)) . "
            WHERE id = :id"
        );
        foreach ($fillable as $item) {
            $query->bindParam(":$item", $data[$item]);
        }
        $query->bindParam(':id', $id);
        $query->execute();
    }

    public static function deleteById(string $table, int $id): void
    {
        $query = (new Database)->connect()->prepare(
            "DELETE FROM $table WHERE id = :id"
        );
        $query->bindParam(':id', $id);
        $query->execute();
    }
}