<?php
// Usuario.php
require_once __DIR__ . '/../config/db.php';

class Usuario {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }

        return false;
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerHijos($id_padre) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_padre = :id_padre");
        $stmt->bindParam(':id_padre', $id_padre, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($email, $nombre_completo, $password, $id_rol) {
        $stmt = $this->conn->prepare("
            INSERT INTO usuarios (email, nombre_completo, password, id_rol)
            VALUES (:email, :nombre_completo, :password, :id_rol)
        ");
        return $stmt->execute([
            ':email' => $email,
            ':nombre_completo' => $nombre_completo,
            ':password' => $password,
            ':id_rol' => $id_rol
        ]);
    }

    public function actualizarUsuario($id, $nombre_completo, $email, $id_rol) {
        $stmt = $this->conn->prepare("
            UPDATE usuarios
            SET nombre_completo = :nombre_completo, email = :email, id_rol = :id_rol
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':nombre_completo' => $nombre_completo,
            ':email' => $email,
            ':id_rol' => $id_rol
        ]);
    }

    public function eliminarUsuario($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Puedes agregar más métodos según tus necesidades (ej: obtenerPorRol)
}
?>