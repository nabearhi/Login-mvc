<?php
namespace models;

use database\Database;
use PDO;

class Product {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
    $stmt = $this->db->query("SELECT * FROM productos");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


    public function add(string $nombre, string $descripcion, float $precio, ?string $imagen): bool {
        $stmt = $this->db->prepare("INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $descripcion, $precio, $imagen]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
