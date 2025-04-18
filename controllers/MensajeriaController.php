<?php
require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../config/db.php';

class MensajeriaController {
    private $mensajeModel;

    public function __construct($pdo) {
        $this->mensajeModel = new Mensaje($pdo);
    }

    public function enviarMensaje($emisorId, $receptorId, $asunto, $contenido) {
        return $this->mensajeModel->enviar($emisorId, $receptorId, $asunto, $contenido);
    }

    public function obtenerMensajesRecibidos($usuarioId) {
        return $this->mensajeModel->listarRecibidos($usuarioId);
    }

    public function obtenerMensajesEnviados($usuarioId) {
        return $this->mensajeModel->listarEnviados($usuarioId);
    }

    public function marcarComoLeido($mensajeId) {
        return $this->mensajeModel->marcarLeido($mensajeId);
    }
}
?>