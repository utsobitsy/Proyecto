<?php
require_once __DIR__ . '/../config/db.php';

class Mensaje {
    private $pdo;
    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // Enviar mensaje
    public function send(array $data): int {
        $stmt = $this->pdo->prepare(
            "INSERT INTO mensajes (id_emisor, id_receptor, asunto, contenido, creado_en)
             VALUES (:emi, :rec, :asunto, :contenido, NOW())"
        );
        $stmt->execute([
            ':emi'      => $data['id_emisor'],
            ':rec'      => $data['id_receptor'],
            ':asunto'   => $data['asunto'],
            ':contenido'=> $data['contenido'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    // Obtener conversaciones entre dos usuarios
    public function getConversation(int $u1, int $u2): array {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM mensajes
             WHERE (id_emisor = :u1 AND id_receptor = :u2)
                OR (id_emisor = :u2 AND id_receptor = :u1)
             ORDER BY creado_en ASC"
        );
        $stmt->execute([':u1' => $u1, ':u2' => $u2]);
        return $stmt->fetchAll();
    }
}
?>