<?php
require_once __DIR__ . '/../config/db.php';

class Observacion {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
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