<?php

namespace PageMaker;

/**
 * @class Authentication
 *
 * This implementation assumes a user system where user credentials are stored in a database. The functions provided
 * allow for login, logout, and basic access control. Please note that this is a simplified version for illustrative
 * purposes and doesn't include all possible security measures you should have in place (like hashing/salting
 * passwords, using prepared statements, etc.).
 *
 * Please remember that the quality and security of your authentication system are critical, and you should always
 * follow best practices for user authentication. These include using secure password hashing algorithms (like bcrypt),
 * HTTPS for all traffic, prevention of SQL Injection, etc. This example does not include all these practices and is a
 * basic illustrative example.
 *
 * @todo Use session class.
 */
class Authentication
{
    protected PDO $db;

    public static function logout(): void
    {
        unset($_SESSION['user_id']);
        session_destroy();
    }

    public static function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function hasUserAccessTo(string $resource): bool
    {
        if (!$this->isUserLoggedIn()) {
            return false;
        }

        // Assuming a permission system, where you link user id to resources they can access
        $stmt = $this->db->prepare("SELECT * FROM permissions WHERE user_id = :user_id AND resource = :resource");
        $stmt->bindParam(":user_id", $_SESSION['user_id']);
        $stmt->bindParam(":resource", $resource);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function login(string $username, string $password): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // You should have hashed passwords, and use password_verify for comparing.
        // This is a simplified version.
        if ($user && $user['password'] == $password) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }

        return false;
    }
}
