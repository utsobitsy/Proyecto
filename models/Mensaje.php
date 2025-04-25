<?php

namespace Models;

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
<?php
// Modelo actualizadp

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

    // Obtener conversaciones únicas: IDs de usuarios con los que ha conversado
    public function getUserConversations(int $userId): array {
        $stmt = $this->pdo->prepare(
            "SELECT DISTINCT CASE
                 WHEN id_emisor = :uid THEN id_receptor
                 ELSE id_emisor END AS other_id
             FROM mensajes
             WHERE id_emisor = :uid OR id_receptor = :uid"
        );
        $stmt->execute([':uid' => $userId]);
        return array_column($stmt->fetchAll(), 'other_id');
    }

    // Obtener conversaciones entre dos usuarios
    public function getConversation(int $u1, int $u2): array {
        $stmt = $this->pdo->prepare(
            "SELECT m.*, em.nombre AS emisor_nombre, rc.nombre AS receptor_nombre
             FROM mensajes m
             JOIN usuarios em ON m.id_emisor = em.id
             JOIN usuarios rc ON m.id_receptor = rc.id
             WHERE (id_emisor = :u1 AND id_receptor = :u2)
                OR (id_emisor = :u2 AND id_receptor = :u1)
             ORDER BY creado_en ASC"
        );
        $stmt->execute([':u1' => $u1, ':u2' => $u2]);
        return $stmt->fetchAll();
    }
}
?>