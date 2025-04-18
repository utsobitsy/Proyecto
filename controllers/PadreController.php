<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Observaciones.php';
require_once __DIR__ . '/../config/db.php';

class PadreController {
    private $usuarioModel;
    private $notaModel;
    private $observacionModel;

    public function __construct($pdo) {
        $this->usuarioModel = new Usuario($pdo);
        $this->notaModel = new Nota($pdo);
        $this->observacionModel = new Observacion($pdo);
    }

    public function dashboard() {
        $usuario = $this->usuarioModel->obtenerPorId($_SESSION['user_id']);
        $hijos = $this->usuarioModel->obtenerHijos($usuario['id']);
        $notas = $this->notaModel->obtenerPorEstudiantes($hijos);
        require_once 'views/padre/dashboard.php';
    }

    public function verNotas() {
        $notas = $this->notaModel->obtenerPorEstudiantes($_SESSION['user_id']);
        require_once 'views/padre/notas.php';
    }

    public function verObservaciones() {
        $observaciones = $this->observacionModel->obtenerPorEstudiante($_SESSION['user_id']);
        require_once 'views/padre/observaciones.php';
    }
}
?>