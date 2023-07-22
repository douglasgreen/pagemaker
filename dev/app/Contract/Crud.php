<?php

namespace PageMaker;

/**
 * @interface CRUD stands for the four primary functions: create, read, update, and delete.
 */
interface Crud
{
    public function setPrimaryKey(string $primaryKey): void;
    public function create(array $data): int;
    public function delete(int $id): void;
    public function deleteWhere(array $data, string $op): array;
    public function read(int $id): ?array;
    public function readAll(): array;
    public function readWhere(array $data, string $op): array;
    public function update(array $data, int $id): void;
    public function updateWhere(array $data, array $whereData, string $op): void;
}
