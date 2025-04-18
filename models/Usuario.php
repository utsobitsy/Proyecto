<?php
require_once __DIR__ . '/../config/db.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Obtener todos los usuarios
    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT id, nombre, correo, rol FROM usuarios");
        return $stmt->fetchAll();
    }

    // Obtener usuario por ID
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT id, nombre, correo, rol FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    // Crear nuevo usuario
    public function create(array $data): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (:nombre, :correo, :pass, :rol)"
        );
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':correo' => $data['correo'],
            ':pass'   => password_hash($data['contraseña'], PASSWORD_DEFAULT),
            ':rol'    => $data['rol']
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    // Actualizar usuario
    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE usuarios SET nombre = :nombre, correo = :correo, rol = :rol WHERE id = :id"
        );
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':correo' => $data['correo'],
            ':rol'    => $data['rol'],
            ':id'     => $id
        ]);
    }

    // Eliminar usuario
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>