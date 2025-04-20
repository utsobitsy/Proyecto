<?php
// Modelo UsuarioAuth: Manejo exclusivo de autenticación de usuarios

require_once __DIR__ . '/../config/db.php';

class UsuarioAuth {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    /**
     * Buscar usuario por correo electrónico
     * Retorna id, nombre, correo, contraseña (hashed), rol y estado
     */
    public function findByEmail($email) {
        $sql = "SELECT id, nombre, correo, contraseña, rol, activo FROM usuarios WHERE correo = :correo LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':correo', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si el usuario está activo
     * @param array $user - resultado de findByEmail
     */
    public function estaActivo($user) {
        return isset($user['activo']) && $user['activo'] == 1;
    }

    /**
     * Verificar contraseña con hash
     * @param string $inputPassword - contraseña ingresada por el usuario
     * @param string $hashedPassword - contraseña almacenada (hash)
     */
    public function verificarContraseña($inputPassword, $hashedPassword) {
        return password_verify($inputPassword, $hashedPassword);
    }

    /**
     * Generar hash de una nueva contraseña
     */
    public function generarHash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Actualizar contraseña del usuario
     */
    public function actualizarContraseña($userId, $nuevaContraseña) {
        $hash = $this->generarHash($nuevaContraseña);
        $sql = "UPDATE usuarios SET contraseña = :hash WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Cambiar estado de actividad del usuario (activar/desactivar cuenta)
     */
    public function cambiarEstado($userId, $activo) {
        $sql = "UPDATE usuarios SET activo = :activo WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':activo', $activo, PDO::PARAM_INT);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Obtener roles de usuario en forma de array (si están separados por comas)
     */
    public function obtenerRoles($user) {
        return isset($user['rol']) ? array_map('trim', explode(',', $user['rol'])) : [];
    }
}
