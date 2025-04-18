<?php
// Refactorización usando modelo, validación, CSRF y paginación

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Asistencia.php';
require_once __DIR__ . '/../models/Usuario.php';

class AsistenciaController {
    private $asistenciaModel;
    private $userModel;

    public function __construct() {
        session_start();
        // Solo Profesores y Coordinadores pueden gestionar asistencia
        $rol = $_SESSION['rol'] ?? null,
        if (!in_array($rol, ['Profesor', 'Coordinador'])) {
            header('Location: /auth/denied_access');
            exit;
        }
        $this->asistenciaModel = new Asistencia();
        $this->userModel = new Usuario();
    }

    // Listar asistencia (opcional por estudiante y rango de fecha)
    public function index() {
        // Parámetros de filtro
        $desde      = $_GET['desde'] ?? date('Y-m-d');
        $hasta      = $_GET['hasta'] ?? date('Y-m-d');
        $idEst      = isset($_GET['id_estudiante']) ? (int)$_GET['id_estudiante'] : null;

        if ($idEst) {
            $records = $this->asistenciaModel->getByEstudiante($idEst, $desde, $hasta);
        } else {
            // TODO: implementar getAllByDateRange en el modelo Asistencia
            $records = $this->asistenciaModel->getAllByDateRange($desde, $hasta);
        }

        include __DIR__ . '/../views/coordinador/asistencia.php';
    }

    // Mostrar formulario para registrar asistencia
    public function create() {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        // Obtener lista de estudiantes
        $students = $this->userModel->getAllByRole('Estudiante');
        include __DIR__ . '/../views/coordinador/asistencia_form.php';
    }

    // Guardar nuevo registro de asistencia
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || 
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }

        // Validar datos
        $idEstudiante = filter_input(INPUT_POST, 'id_estudiante', FILTER_VALIDATE_INT);
        $fecha        = $_POST['fecha'] ?? date('Y-m-d');
        $presente     = isset($_POST['presente']) && $_POST['presente'] == '1';

        if (!$idEstudiante) {
            $_SESSION['flash_error'] = 'Estudiante inválido.';
            header('Location: /asistencia/create');
            exit;
        }

        try {
            $this->asistenciaModel->mark($idEstudiante, $fecha, $presente);
            $_SESSION['flash_success'] = 'Asistencia registrada correctamente.';
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = 'Error al registrar asistencia.';
        }

        header('Location: /asistencia');
        exit;
    }

    // Eliminar un registro de asistencia
    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || 
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $_SESSION['flash_error'] = 'ID de asistencia inválido.';
        } else {
            try {
                // TODO: implementar delete en modelo Asistencia
                $this->asistenciaModel->delete($id);
                $_SESSION['flash_success'] = 'Registro de asistencia eliminado.';
            } catch (\Exception $e) {
                $_SESSION['flash_error'] = 'Error al eliminar registro.';
            }
        }

        header('Location: /asistencia');
        exit;
    }
}
?>