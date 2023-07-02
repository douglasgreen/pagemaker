<?php

namespace PageMaker;

/**
 * @class Database handler
 *
 * Here's a simple PHP class named Database that connects to a MySQL database using PDO, has methods to execute queries
 * and manage transactions. It's a basic example and might need to be modified to suit your needs.
 *
 * This class provides some basic functionality, including:
 *
 * __construct(): Initializes a new database connection when an object of this class is created. You can provide the host, database name, username, and password for your database connection, or use the defaults provided.
 * executeQuery(): Takes a SQL query as a string and an optional array of parameters for any placeholder values in the query. It executes the query and returns true or false to indicate whether the query succeeded.
 * fetchQuery(): Similar to executeQuery(), but intended for SELECT queries that return results. It executes the query and returns the results as an array of associative arrays, where each associative array represents a row from the result set.
 * startTransaction(), commitTransaction(), and rollbackTransaction(): These functions are used to begin, commit, or roll back a database transaction.
 *
 * Please note that this is a basic example and doesn't cover many things you'll probably need in a real-world
 * application, such as connection pooling, query logging, error handling, prepared statements, etc.
 */
class Database
{
    protected $connection;

    public function __construct(
        string $host = 'localhost',
        string $dbname = 'test',
        string $username = 'root',
        string $password = ''
    ) {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception('Connection failed: ' . $e->getMessage());
        }
    }

    public function executeQuery(string $sql, array $parameters = []): bool
    {
        try {
            $stmt = $this->connection->prepare($sql);
            return $stmt->execute($parameters);
        } catch (PDOException $e) {
            throw new Exception('Query failed: ' . $e->getMessage());
        }
    }

    public function fetchQuery(string $sql, array $parameters = []): array
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($parameters);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Query failed: ' . $e->getMessage());
        }
    }

    public function startTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function commitTransaction(): void
    {
        $this->connection->commit();
    }

    public function rollbackTransaction(): void
    {
        $this->connection->rollBack();
    }
}
