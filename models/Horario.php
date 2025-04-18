<?php
// Horario.php

class Horario {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function obtenerHorarioNormal($id_grupo) {
        $stmt = $this->conn->prepare("
            SELECT dia, hora_inicio, hora_fin, materia
            FROM horarios
            WHERE id_grupo = :grupo AND tipo = 'normal'
            ORDER BY dia, hora_inicio
        ");
        $stmt->bindParam(':grupo', $id_grupo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerHorarioExamen($id_grupo) {
        $stmt = $this->conn->prepare("
            SELECT dia, hora_inicio, hora_fin, materia
            FROM horarios
            WHERE id_grupo = :grupo AND tipo = 'examen'
            ORDER BY dia, hora_inicio
        ");
        $stmt->bindParam(':grupo', $id_grupo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($datos) {
        $stmt = $this->conn->prepare("
            INSERT INTO horarios (id_grupo, dia, hora_inicio, hora_fin, materia, tipo)
            VALUES (:id_grupo, :dia, :hora_inicio, :hora_fin, :materia, :tipo)
        ");
        return $stmt->execute([
            ':id_grupo' => $datos['id_grupo'],
            ':dia' => $datos['dia'],
            ':hora_inicio' => $datos['hora_inicio'],
            ':hora_fin' => $datos['hora_fin'],
            ':materia' => $datos['materia'],
            ':tipo' => $datos['tipo']
        ]);
    }
}
?>