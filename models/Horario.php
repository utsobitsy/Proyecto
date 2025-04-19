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

<?php
// Actualización modelo

require_once __DIR__ . '/../config/db.php';

class Horario {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Obtener horario normal o de examenes según tipo
    public function getByEstudiante(int $idEstudiante, string $tipo = 'normal'): array {
        $stmt = $this->pdo->prepare(
            "SELECT h.* FROM horarios h
             WHERE h.id_estudiante = :idest AND h.tipo = :tipo"
        );
        $stmt->execute([':idest' => $idEstudiante, ':tipo' => $tipo]);
        return $stmt->fetchAll();
    }

    // Obtener horarios paginados con datos de estudiante
    public function getPaginatedWithStudent(int $limit, int $offset): array {
        $stmt = $this->pdo->prepare(
            "SELECT h.*, u.nombre AS estudiante_nombre
             FROM horarios h
             JOIN usuarios u ON h.id_estudiante = u.id
             ORDER BY h.dia ASC, h.hora_inicio ASC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Contara total de registros para paginación
    public function countAll(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM horarios");
        return (int)$stmt->fetchColumn();
    }

    // Buscar horario por ID
    public function findById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM horarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    // Crear nuevo horario
    public function create(array $data): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO horarios (id_estudiante, dia, hora_inicio, hora_fin, tipo)
             VALUES (:idest, :dia, :hin, :hfi, :tipo)"
        );
        $stmt->execute([
            ':idest' => $data['id_estudiante'],
            ':dia'   => $data['dia'],
            ':hin'   => $data['hora_inicio'],
            ':hfi'   => $data['hora_fin'],
            ':tipo'  => $data['tipo'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    // Actualizar horario existente
    public function update(int $id, array $data): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE horarios SET id_estudiante = :idest, dia = :dia,
             hora_inicio = :hin, hora_fin = :hfi, tipo = :tipo
             WHERE id = :id"
        );
        return $stmt->execute([
            ':idest' => $data['id_estudiante'],
            ':dia'   => $data['dia'],
            ':hin'   => $data['hora_inicio'],
            ':hfi'   => $data['hora_fin'],
            ':tipo'  => $data['tipo'],
            ':id'    => $id,
        ]);
    }

    // Eliminar un horario
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM horarios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>