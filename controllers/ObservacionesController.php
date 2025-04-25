<?php

namespace Controllers;

require_once __DIR__ . '/../models/Observacion.php';
require_once __DIR__ . '/../config/db.php';

class ObservacionesController {
    private $observacionModel;

    public function __construct($pdo) {
        $this->observacionModel = new Observacion($pdo);
    }

    public function agregarObservacion($datos) {
        return $this->observacionModel->registrar(
            $datos['id_estudiante'],
            $datos['tipo'],
            $datos['descripcion'],
            $datos['fecha'],
            $datos['registrado_por']
        );
    }

    public function obtenerPorEstudiante($estudianteId) {
        return $this->observacionModel->obtenerPorEstudiante($estudianteId);
    }
}
?>

<?php
// CRUD de observaciones para profesor y Coordinadores de convivencia

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Observacion.php';
require_once __DIR__ . '/../models/Usuario.php';

class ObservacionesController {
    private $obsModel;
    private $userModel;

    public function __construct(){
        session_start();
        // Solo Profesores y Coordinadores de Convivencia
        $rol = $_SESSION['rol'] ?? '';
        if (!in_array($rol, ['Profesor', 'Coordinador'])) {
            header('Location: /auth/denied_access');
            exit;
        }
        $this->obsModel  = new Observacion();
        $this->userModel = new Usuario();
    }

    // Listar todas las observaciones
    public function index() {
        $observaciones = $this->obsModel->getAllOrdered();
        include __DIR__ . '/../views/observaciones/index.php';
    }

    // Mostrar formulario para crear observación
    public function create() {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        // Lista de estudiantes
        $students = $this->userModel->getAllByRole('Estudiante');
        include __DIR__ . '/../views/observaciones/form.php';
    }

    // Guardar nueva observación
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
            !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }
        $idReceptor  = filter_input(INPUT_POST, 'id_receptor', FILTER_VALIDATE_INT);
        $tipo        = trim($_POST['tipo'] ?? '');
        $comentario  = trim($_POST['comentario'] ?? '');

        if (!$idReceptor || !$tipo || !$comentario) {
            $_SESSION['flash_error'] = 'Todos los campos son obligatorios.';
            header('Location: /observaciones/create');
            exit;
        }

        try {
            $this->obsModel->create([
                'id_emisor'   => $_SESSION['user_id'],
                'id_receptor' => $idReceptor,
                'tipo'        => $tipo,
                'comentario'  => $comentario
            ]);
            $_SESSION['flash_success'] = 'Observación creada correctamente.';
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error al crear observación.';
        }
        header('Location: /observaciones');
        exit;
    }

    // Eliminar observación existente
    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
            !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['flash_error'] = 'ID inválido.';
        } else {
            try {
                $this->obsModel->delete($id);
                $_SESSION['flash_success'] = 'Observación eliminada.';
            } catch (Exception $e) {
                $_SESSION['flash_error'] = 'Error al eliminar observación.';
            }
        }
        header('Location: /observaciones');
        exit;
    }
}
?>
