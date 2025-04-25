<?php

namespace Models;

require_once __DIR__ . '/../config/db.php';

class Observacion {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Obtener todas las observaciones con emisor y receptor
    public function getAllOrdered(): array {
        $stmt = $this->pdo->query(
            "SELECT o.*, em.nombre AS emisor_nombre, rc.nombre AS receptor_nombre
             FROM observaciones o
             JOIN usuarios em ON o.id_emisor = em.id
             JOIN usuarios rc ON o.id_receptor = rc.id
             ORDER BY o.fecha DESC"
        );
        return $stmt->fetchAll();
    }

    // Eliminar observación
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM observaciones WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Crear observación
    public function create(array $data): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO observaciones (id_emisor, id_receptor, tipo, comentario, fecha)
             VALUES (:emi, :rec, :tipo, :comentario, NOW())"
        );
        $stmt->execute([
            ':emi'       => $data['id_emisor'],
            ':rec'       => $data['id_receptor'],
            ':tipo'      => $data['tipo'],
            ':comentario'=> $data['comentario'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    // Historial de observaciones por estudiante
    public function getByReceptor(int $idReceptor): array {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM observaciones WHERE id_receptor = :rec ORDER BY fecha DESC"
        );
        $stmt->execute([':rec' => $idReceptor]);
        return $stmt->fetchAll();
    }
}
?>