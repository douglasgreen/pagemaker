<?php

namespace PageMaker\Database;

class Table
{
    protected $pdo;
    protected $database;
    protected $table;

    /** @var string Fully-qualified table name */
    protected $fqtn;
    protected $primaryKey;

    public function __construct(PDO $pdo, string $database, string $table)
    {
        $this->pdo = $pdo;
        $this->database = $database;
        $this->table = $table;
        $this->fqtn = $database . '.' . $table;
    }

    public function setPrimaryKey(string $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

    /*
     * @param array $data An array of field names and values, excluding any auto-increment or timestamp fields.
     * @return New primary key or 0 if there is no primary key field.
     */
    public function create(array $data): int
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $markedFields = $this->markFields($fields);

        $fieldsStr = implode(', ', $fields);
        $paramStr = implode(', ', $markedFields);

        $query = "INSERT INTO $this->fqtn ($fieldsStr) VALUES ($paramStr)";

        $stmt = $this->pdo->prepare($query);

        $markedData = array_combine($markedFields, $values);
        $stmt->execute($markedData);

        $newId = $this->pdo->lastInsertId();
        return $newId;
    }

    public function delete(int $id): void
    {
        if (!isset($this->primaryKey)) {
            throw new Exception('Primary key not set');
        }

        $markedKey = ':' . $this->primaryKey;

        $query = "DELETE FROM $this->fqtn WHERE $this->primaryKey = $markedKey";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute([$markedKey => $id]);
    }

    public function deleteWhere(array $data, string $op = 'AND'): array
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $markedFields = $this->markFields($fields);

        $whereClause = $this->buildWhereClause($fields, $op);

        $query = "DELETE FROM $this->fqtn $whereClause";

        $stmt = $this->pdo->prepare($query);

        $markedData = array_combine($markedFields, $values);
        $stmt->execute($markedData);
    }

    public function read(int $id): ?array
    {
        if (!isset($this->primaryKey)) {
            throw new Exception('Primary key not set');
        }

        $markedKey = ':' . $this->primaryKey;

        $query = "SELECT * FROM $this->fqtn WHERE $this->primaryKey = $markedKey";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute([$markedKey => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row;
        }
        return null;
    }

    public function readAll(): array
    {
        $query = "SELECT * FROM $this->fqtn";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readWhere(array $data, string $op = 'AND'): array
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $markedFields = $this->markFields($fields);

        $whereClause = $this->buildWhereClause($fields, $op);

        $query = "SELECT * FROM $this->fqtn $whereClause";

        $stmt = $this->pdo->prepare($query);

        $markedData = array_combine($markedFields, $values);
        $stmt->execute($markedData);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(array $data, int $id): void
    {
        if (!isset($this->primaryKey)) {
            throw new Exception('Primary key not set');
        }

        $fields = array_keys($data);
        $values = array_values($data);
        $markedFields = $this->markFields($fields);

        $updateList = $this->buildUpdateList($fields);

        $markedKey = ':' . $this->primaryKey;

        $query = "UPDATE $this->fqtn SET $updateList WHERE $this->primaryKey = $markedKey";

        $markedData = array_combine($markedFields, $values);
        $markedData[$markedKey] = $id;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($markedData);
    }

    public function updateWhere(array $data, array $whereData, string $op = 'AND'): void
    {
        $fields = array_keys($data);
        $values = array_values($data);
        $markedFields = $this->markFields($fields);

        $whereFields = array_keys($whereData);
        $whereValues = array_values($whereData);
        $whereMarkedFields = $this->markFields($whereFields, $fields);

        $updateList = $this->buildUpdateList($fields);

        $whereClause = $this->buildWhereClause($whereFields, $op);

        $query = "UPDATE $this->fqtn SET $updateList $whereClause";

        $markedData = array_combine($markedFields, $values);
        $whereMarkedData = array_combine($whereMarkedFields, $whereValues);
        $allData = array_merge($markedData, $whereMarkedData);
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($allData);
    }

    protected function buildUpdateList(array $fields): string
    {
        if (!$fields) {
            throw new Exception('Fields required');
        }

        $updateList = '';
        foreach ($fields as $field) {
            $updateList .= "$field = :$field, ";
        }
        $updateList = rtrim($updateList, ', ');
        return $updateList;
    }

    protected function buildWhereClause(array $fields, string $op = 'AND'): string
    {
        if (!$fields) {
            return '';
        }
        $whereClause = 'WHERE ';
        foreach ($fields as $field) {
            $whereClause .= "$field = :$field $op ";
        }
        $whereClause = rtrim($whereClause, " $op ");
        return $whereClause;
    }

    protected function markFields(array $fields, array $usedFields = []): array
    {
        $markedFields = [];
        foreach ($fields as $field) {
            $i = 1;
            $newField = $field;
            while (in_array($newField, $usedFields)) {
                $newField = $field . $i++;
            }
            $markedFields[] = ':' . $newField;
        }
        return $markedFields;
    }
}
