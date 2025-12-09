<?php
namespace models;

use database\Database;
use PDO;

class User {
    public int $id;
    public string $email;
    public string $telefono;
    public string $password_hash;
    public string $role;
    public int $is_active;

    private static function connect(): PDO {
        return Database::getConnection();
    }

    public static function findByEmail(string $email): ?self {
        $stmt = self::connect()->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $user = new self();
        foreach ($row as $key => $value) {
            if (property_exists($user, $key)) {
                $user->$key = $value;
            }
        }
        return $user;
    }

    public static function create(string $email, string $telefono, string $hash, string $role): bool {
        $db = self::connect();
        $stmt = $db->prepare("INSERT INTO users (email, telefono, password_hash, role, is_active) VALUES (?, ?, ?, ?, 1)");
        return $stmt->execute([$email, $telefono, $hash, $role]);
    }

    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->password_hash);
    }

    public static function getAll(): array {
    $db = self::connect();
    $stmt = $db->query("SELECT * FROM users");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


    public static function updateRole(int $id, string $role): bool {
        $stmt = self::connect()->prepare("UPDATE users SET role = :role WHERE id = :id");
        return $stmt->execute(['role' => $role, 'id' => $id]);
    }

    public static function delete(int $id): bool {
        $stmt = self::connect()->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
