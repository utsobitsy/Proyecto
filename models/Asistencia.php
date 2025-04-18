<?php
// Asistencia.php

class Asistencia {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function registrarAsistencia($id_estudiante, $fecha, $estado) {
        $stmt = $this->conn->prepare("
            INSERT INTO asistencias (id_estudiante, fecha, estado)
            VALUES (:id_estudiante, :fecha, :estado)
        ");
        return $stmt->execute([
            ':id_estudiante' => $id_estudiante,
            ':fecha' => $fecha,
            ':estado' => $estado
        ]);
    }

    public function obtenerPorEstudiante($id_estudiante) {
        $stmt = $this->conn->prepare("SELECT * FROM asistencias WHERE id_estudiante = :id_estudiante");
        $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function porCurso($cursoId, $fecha = null) {
        $sql = "SELECT a.* FROM asistencias a
                JOIN usuarios u ON a.id_estudiante = u.id
                JOIN cursos_estudiantes ce ON u.id = ce.id_estudiante
                WHERE ce.id_curso = :cursoId";
        if ($fecha) {
            $sql .= " AND a.fecha = :fecha";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cursoId', $cursoId, PDO::PARAM_INT);
        if ($fecha) {
            $stmt->bindParam(':fecha', $fecha);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function resumenPorEstudiante($estudianteId) {
        $stmt = $this->conn->prepare("
            SELECT
                COUNT(*) AS total_clases,
                SUM(CASE WHEN estado = 'Presente' THEN 1 ELSE 0 END) AS presentes,
                SUM(CASE WHEN estado = 'Ausente' THEN 1 ELSE 0 END) AS ausentes,
                SUM(CASE WHEN estado = 'Tarde' THEN 1 ELSE 0 END) AS tardanzas
            FROM asistencias
            WHERE id_estudiante = :estudianteId
        ");
        $stmt->bindParam(':estudianteId', $estudianteId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>