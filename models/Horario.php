<?php
require_once __DIR__ . '/../config/db.php';

class Horario {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Obtener horario normal o de exámenes según tipo
    public function getByEstudiante(int $idEstudiante, string $tipo = 'normal'): array {
        $stmt = $this->pdo->prepare(
            "SELECT h.* FROM horarios h
             WHERE id_estudiante = :idest AND tipo = :tipo"
        );
        $stmt->execute([':idest' => $idEstudiante, ':tipo' => $tipo]);
        return $stmt->fetchAll();
    }
}
?>