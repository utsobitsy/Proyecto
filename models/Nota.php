<?php

namespace Models;

require_once __DIR__ . '/../config/db.php';

class Nota {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Obtener nota por ID
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM notas WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    // Obtener notas paginadas con estudiante y materia
    public function getPaginatedWithStudentAndSubject(int $limit, int $offset): array {
        $stmt = $this->pdo->prepare(
            "SELECT n.*, u.nombre AS estudiante_nombre, m.nombre AS materia_nombre
             FROM notas n
             JOIN usuarios u ON n.id_estudiante = u.id
             JOIN materias m ON n.id_materia = m.id
             ORDER BY n.created_at DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Contar todas las notas
    public function countAll(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM notas");
        return (int)$stmt->fetchColumn();
    }

    // Obtener notas por estudiante
    public function getByEstudiante(int $idEstudiante): array {
        $stmt = $this->pdo->prepare(
            "SELECT n.*, m.nombre AS materia FROM notas n
             JOIN materias m ON n.id_materia = m.id
             WHERE id_estudiante = :id"
        );
        $stmt->execute([':id' => $idEstudiante]);
        return $stmt->fetchAll();
    }

    // Agregar nueva nota
    public function create(array $data): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO notas (id_estudiante, id_materia, calificacion, descripcion, periodo)
             VALUES (:idest, :idmat, :cal, :desc, :per)"
        );
        $stmt->execute([
            ':idest' => $data['id_estudiante'],
            ':idmat' => $data['id_materia'],
            ':cal'   => $data['calificacion'],
            ':desc'  => $data['descripcion'],
            ':per'   => $data['periodo'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    // Actualizar nota
    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE notas SET calificacion = :cal, descripcion = :desc, periodo = :per
             WHERE id = :id"
        );
        return $stmt->execute([
            ':cal'  => $data['calificacion'],
            ':desc' => $data['descripcion'],
            ':per'  => $data['periodo'],
            ':id'   => $id,
        ]);
    }

    // Eliminar nota
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM notas WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>