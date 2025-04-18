<?php
// Observacion.php
require_once __DIR__ . '/../config/db.php';

class Observacion {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function registrar($id_estudiante, $tipo, $descripcion, $fecha, $registrado_por) {
        $stmt = $this->conn->prepare("
            INSERT INTO observaciones (id_estudiante, tipo, descripcion, fecha, registrado_por)
            VALUES (:id_estudiante, :tipo, :descripcion, :fecha, :registrado_por)
        ");
        return $stmt->execute([
            ':id_estudiante' => $id_estudiante,
            ':tipo' => $tipo,
            ':descripcion' => $descripcion,
            ':fecha' => $fecha,
            ':registrado_por' => $registrado_por
        ]);
    }

    public function obtenerPorEstudiante($id_estudiante) {
        $stmt = $this->conn->prepare("SELECT * FROM observaciones WHERE id_estudiante = :id_estudiante");
        $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstadisticasPorGrupo($id_grupo) {
        $stmt = $this->conn->prepare("
            SELECT tipo, COUNT(*) as cantidad
            FROM observaciones o
            JOIN usuarios u ON o.id_estudiante = u.id
            WHERE u.id_grupo = :id_grupo
            GROUP BY tipo
        ");
        $stmt->bindParam(':id_grupo', $id_grupo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM observaciones");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>