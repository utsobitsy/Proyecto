<?php

namespace Models;

require_once __DIR__ . '/../config/db.php';

class Asistencia {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Registrar asistencia
    public function mark(int $idEstudiante, string $fecha, bool $presente): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO asistencias (id_estudiante, fecha, presente)
             VALUES (:idest, :fecha, :presente)"
        );
        return $stmt->execute([
            ':idest'   => $idEstudiante,
            ':fecha'   => $fecha,
            ':presente'=> $presente ? 1 : 0,
        ]);
    }

    // Obtener asistencias de un estudiante por rango de fecha
    public function getByEstudiante(int $idEstudiante, string $desde, string $hasta): array {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM asistencias WHERE id_estudiante = :idest
             AND fecha BETWEEN :desde AND :hasta"
        );
        $stmt->execute([':idest' => $idEstudiante, ':desde' => $desde, ':hasta' => $hasta]);
        return $stmt->fetchAll();
    }
}
?>