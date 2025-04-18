<?php

class Mensaje {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function enviar($emisorId, $receptorId, $asunto, $contenido) {
        $query = $this->db->prepare("INSERT INTO mensajes (emisor_id, receptor_id, asunto, contenido) VALUES (?, ?, ?, ?)");
        return $query->execute([$emisorId, $receptorId, $asunto, $contenido]);
    }

    public function listarRecibidos($usuarioId) {
        $query = $this->db->prepare("SELECT * FROM mensajes WHERE receptor_id = ? ORDER BY fecha_envio DESC");
        $query->execute([$usuarioId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarEnviados($usuarioId) {
        $query = $this->db->prepare("SELECT * FROM mensajes WHERE emisor_id = ? ORDER BY fecha_envio DESC");
        $query->execute([$usuarioId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function marcarLeido($mensajeId) {
        $query = $this->db->prepare("UPDATE mensajes SET leido = 1 WHERE id = ?");
        return $query->execute([$mensajeId]);
    }
}
?>