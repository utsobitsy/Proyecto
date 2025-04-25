<?php
// Controlador para funciones del estudiante

namespace Controllers;

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Horario.php';

class EstudianteController {
    private $userModel;
    private $notaModel;
    private $horarioModel;

    public function __construct() {
        session_start();
        
        // Verificar que el usuario este autenticado y sea Estudiante
        if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'Estudiante') {
            header('Location: /auth/denied_access');
            exit;
        }
        $this->userModel = new Usuario();
        $this->notaModel = new Nota();
        $this->horarioModel = new Horario();
    }

    // Dashboard: vista principal del estudiante
    public function dashboard() {
        $id = $_SESSION['user_id'];
        
        // Últimas 5 notas
        $notas = $this->notaModel->getByEstudiante($id);
        
        // Horario normal
        $horario = $this->horarioModel->getByEstudiante($id, 'normal');

        include __DIR__ . '/../views/estudiante/dashboard.php';
    }

    // Listar todas las notas del estudiante
    public function notas() {
        $id = $_SESSION['user_id'];
        $data = $this->notaModel->getByEstudiante($id);
        include __DIR__ . '/../views/estudiante/notas.php';
    }

    // Mostrar horario según tipo (normal o examenes)
    public function horario() {
        $id = $_SESSION['user_id'];
        $tipo = $_GET['tipo'] ?? 'normal';
        $data = $this->horarioModel->getByEstudiante($id, $tipo);
        include __DIR__ . '/../views/estudiante/horario.php';
    }
}
?>