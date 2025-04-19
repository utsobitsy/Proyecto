<?php
// Refactorización para gestión de horarios y visualización según rol

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Horario.php';
require_once __DIR__ . '/../models/Usuario.php';

class HorarioController {
    private $horarioModel;
    private $userModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/denied_access'); exit;
        }
        $this->horarioModel = new Horario();
        $this->userModel    = new Usuario();
    }

    // Listar horarios: para estudiantes/redirigir o gestión para roles elevados
    public function index() {
        $rol = $_SESSION['rol'];
        
        // Si es estudiante o padre, redirigir a su vista
        if (in_array($rol, ['Estudiante', 'Padre'])) {
            header('Location: /estudiante/horario');
            exit;
        }

        // Paginación para gestión de horarios
        $page = isset($_GET['page']) ? max(1, (int)\$_GET['page']) : 1;
        \$perPage = 20;
        \$offset  = (\$page - 1) * \$perPage;

        // Obtener todos los horarios con usuario
        \$schedules = \$this->horarioModel->getPaginatedWithStudent(\$perPage, \$offset);
        \$total     = \$this->horarioModel->countAll();
        \$totalPages = ceil(\$total / \$perPage);

        include __DIR__ . '/../views/horario/index.php';
    }

    // Mostrar formulario para crear o editar horario
    public function form() {
        // Roles permitidos: Profesor, Coordinador, Administrador
        \$rol = \$_SESSION['rol'];
        if (!in_array(\$rol, ['Profesor', 'Coordinador', 'Administrador'])) {
            header('Location: /auth/denied_access'); exit;
        }
        \$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        // Lista de estudiantes
        \$students = \$this->userModel->getAllByRole('Estudiante');
        // Si viene ID, es edición
        \$horario = null;
        if (isset(\$_GET['id'])) {
            \$id = (int)\$_GET['id'];
            \$horario = \$this->horarioModel->findById(\$id);
        }
        include __DIR__ . '/../views/horario/form.php';
    }

    // Guardar nuevo o existente
    public function save() {
        if (\$_SERVER['REQUEST_METHOD'] !== 'POST' ||
            !hash_equals(\$_SESSION['csrf_token'] ?? '', \$_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }
        \$data = [
            'id_estudiante' => filter_input(INPUT_POST, 'id_estudiante', FILTER_VALIDATE_INT),
            'dia'           => \$_POST['dia'] ?? '',
            'hora_inicio'   => \$_POST['hora_inicio'] ?? '',
            'hora_fin'      => \$_POST['hora_fin'] ?? '',
            'tipo'          => \$_POST['tipo'] ?? 'normal',
        ];
        // Validación básica
        if (!\$data['id_estudiante'] || !\$data['dia'] || !\$data['hora_inicio'] || !\$data['hora_fin']) {
            \$_SESSION['flash_error'] = 'Todos los campos son obligatorios.';
            header('Location: /horario/form'.(isset(\$_POST['id'])? '?id='.\$_POST['id']:''));
            exit;
        }
        try {
            if (!empty(\$_POST['id'])) {
                \$this->horarioModel->update((int)\$_POST['id'], \$data);
                \$_SESSION['flash_success'] = 'Horario actualizado.';
            } else {
                \$this->horarioModel->create(\$data);
                \$_SESSION['flash_success'] = 'Horario creado.';
            }
        } catch (Exception \$e) {
            \$_SESSION['flash_error'] = 'Error al guardar horario.';
        }
        header('Location: /horario'); exit;
    }

    // Eliminar un horario
    public function destroy() {
        if (\$_SERVER['REQUEST_METHOD'] !== 'POST' ||
            !hash_equals(\$_SESSION['csrf_token'] ?? '', \$_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }
        \$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!\$id) {
            \$_SESSION['flash_error'] = 'ID inválido.';
        } else {
            try {
                \$this->horarioModel->delete(\$id);
                \$_SESSION['flash_success'] = 'Horario eliminado.';
            } catch (Exception \$e) {
                \$_SESSION['flash_error'] = 'Error al eliminar horario.';
            }
        }
        header('Location: /horario'); exit;
    }
}
?>