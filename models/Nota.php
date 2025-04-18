<?php
// Nota.php
require_once __DIR__ . '/../config/db.php';

class Nota {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function obtenerPorEstudiante($id_estudiante, $periodo = null) {
        $sql = "SELECT * FROM notas WHERE id_estudiante = :id_estudiante";
        if ($periodo) {
            $sql .= " AND periodo = :periodo";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
        if ($periodo) {
            $stmt->bindParam(':periodo', $periodo);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPromedioPorMateria($id_estudiante) {
        $stmt = $this->conn->prepare("
            SELECT materia, AVG(calificacion) as promedio
            FROM notas
            WHERE id_estudiante = :id_estudiante
            GROUP BY materia
        ");
        $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardar($id_estudiante, $materia, $calificacion, $descripcion, $periodo) {
        $stmt = $this->conn->prepare("
            INSERT INTO notas (id_estudiante, materia, calificacion, descripcion, periodo)
            VALUES (:id_estudiante, :materia, :calificacion, :descripcion, :periodo)
        ");
        return $stmt->execute([
            ':id_estudiante' => $id_estudiante,
            ':materia' => $materia,
            ':calificacion' => $calificacion,
            ':descripcion' => $descripcion,
            ':periodo' => $periodo
        ]);
    }

    public function obtenerPorEstudiantes($estudiantes) {
        if (empty($estudiantes)) return [];

        $placeholders = implode(',', array_fill(0, count($estudiantes), '?'));
        $ids = array_column($estudiantes, 'id');
        $stmt = $this->conn->prepare("SELECT * FROM notas WHERE id_estudiante IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarNota($idNota, $nuevaNota, $descripcion) {
        $stmt = $this->conn->prepare("
            UPDATE notas
            SET calificacion = :nuevaNota, descripcion = :descripcion
            WHERE id = :idNota
        ");
        return $stmt->execute([
            ':idNota' => $idNota,
            ':nuevaNota' => $nuevaNota,
            ':descripcion' => $descripcion
        ]);
    }
}
?>