<?php
// Funcionalidades para profesor: acceso al modulo de notas, asistencia y observaciones
// Refactorización del controlador

require_once __DIR__ . '/../config/db.php';

class ProfesorController {
    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'Profesor') {
            header('Location: /auth/denied_access');
            exit;
        }
    }

    // Dashboard del profesor: enlaces a gestión de módulos
    public function dashboard() {
        include __DIR__ . '/../views/profesor/dashboard.php';
    }
}
?>