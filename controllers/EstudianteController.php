<?php
// No es definitivo, es provicional
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Horario.php';

class EstudianteController {
    private $userModel;
    private $notaModel;
    private $horarioModel;

    public function __construct() {
        session_start();
        $this->userModel    = new Usuario();
        $this->notaModel    = new Nota();
        $this->horarioModel = new Horario();
    }

    public function dashboard() {
        $id = $_SESSION['user_id'];
        $notas   = $this->notaModel->getByEstudiante($id);
        $horario = $this->horarioModel->getByEstudiante($id, 'normal');
        include __DIR__ . '/../views/estudiante/dashboard.php';
    }

    public function notas() {
        $id = $_SESSION['user_id'];
        $data = $this->notaModel->getByEstudiante($id);
        include __DIR__ . '/../views/estudiante/notas.php';
    }

    public function horario() {
        $id = $_SESSION['user_id'];
        $data = $this->horarioModel->getByEstudiante($id, $_GET['tipo'] ?? 'normal');
        include __DIR__ . '/../views/estudiante/horario.php';
    }
}
?>