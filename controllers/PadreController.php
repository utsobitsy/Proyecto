<?php
// Funcionalidad para vista del padre: dashboard, notas, asistencia
// Refactorización del controlador

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Asistencia.php';

class PadreController {
    private $userModel;
    private $notaModel;
    private $asistenciaModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'Padre') {
            header('Location: /auth/denied_access');
            exit;
        }
        $this->userModel      = new Usuario();
        $this->notaModel      = new Nota();
        $this->asistenciaModel = new Asistencia();
    }

    // Vista principal del padre: resumen general del hijo seleccionado
    public function dashboard() {
        $hijoId = $this->getStudentId();
        $notas = $this->notaModel->getByEstudiante($hijoId);
        $asistencias = $this->asistenciaModel->getByEstudiante($hijoId);
        $hijos = $this->getChildren();
        include __DIR__ . '/../views/padre/dashboard.php';
    }

    // Ver calificaiones del hijo
    public function notas() {
        $hijoId = $this->getStudentId();
        $notas = $this->notaModel->getByEstudiante($hijoId);
        $hijos = $this->getChildren();
        include __DIR__ . '/../views/padre/notas.php';
    }

    // Ver historial de asistencia del hijo
    public function asistencia() {
        $hijoId = $this->getStudentId();
        $asistencias = $this->asistenciaModel->getByEstudiante($hijoId);
        $hijos = $this->getChildren();
        include __DIR__ . '/../views/padre/asistencia.php';
    }

    // Obtener ID del estudiante activo (seleccionado por el padre)
    private function getStudentId(): int {
        if (isset($_GET['id_estudiante'])) {
            $_SESSION['id_estudiante_activo'] = (int)$_GET['id_estudiante'];
        }
        return $_SESSION['id_estudiante_activo'] ?? (int)$_SESSION['user_id'];
    }

    // Obtener lista de hijos asociados (por ejemplo, por correo o cuenta padre)
    // Esto se puede adaptar según el modelo de relación
    private function getChildren(): array {
        // Suponiendo una columna id_padre en la tabla usuarios
        return $this->userModel->getChildrenByParentId((int)$_SESSION['user_id']);
    }
}
?>