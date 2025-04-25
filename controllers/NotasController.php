<?php
// Refactorización de controlador

namespace Controllers;

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Materia.php';

class NotasController {
    private $notaModel;
    private $userModel;
    private $materiaModel;

    public function __construct() {
        session_start();
        
        // Solo Profesores, Coordinadores o Administradores
        $rol = $_SESSION['rol'] ?? '';
        if (!in_array($rol, ['Profesor', 'Coordinador', 'Administrador'])) {
            header('Location: /auth/denied_access');
            exit;
        }
        $this->notaModel    = new Nota();
        $this->userModel    = new Usuario();
        $this->materiaModel = new Materia();
    }

    // Listar notas con paginación
    public function index() {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $offset  = ($page - 1) * $perPage;

        $grades     = $this->notaModel->getPaginatedWithStudentAndSubject($perPage, $offset);
        $total      = $this->notaModel->countAll();
        $totalPages = (int)ceil($total / $perPage);

        include __DIR__ . '/../views/notas/index.php';
    }

    // Mostrar formulario de creación
    public function create() {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $students = $this->userModel->getAllByRole('Estudiante');
        $subjects = $this->materiaModel->getAll();
        include __DIR__ . '/../views/notas/form.php';
    }

    // Almacenar nueva nota
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }
        $data = [
            'id_estudiante' => filter_input(INPUT_POST, 'id_estudiante', FILTER_VALIDATE_INT),
            'id_materia'    => filter_input(INPUT_POST, 'id_materia', FILTER_VALIDATE_INT),
            'calificacion'  => filter_input(INPUT_POST, 'calificacion', FILTER_VALIDATE_FLOAT),
            'descripcion'   => trim($_POST['descripcion'] ?? ''),
            'periodo'       => trim($_POST['periodo'] ?? ''),
        ];
        try {
            $this->notaModel->create($data);
            $_SESSION['flash_success'] = 'Nota creada correctamente.';
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error al crear nota.';
        }
        header('Location: /notas'); exit;
    }

    // Mostrar formulario de edición
    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $note = $this->notaModel->findById($id);
        if (!$note) { header('Location: /notas'); exit; }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $students = $this->userModel->getAllByRole('Estudiante');
        $subjects = $this->materiaModel->getAll();
        include __DIR__ . '/../views/notas/form.php';
    }

    // Actualizar nota
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $data = [
            'calificacion'=> filter_input(INPUT_POST, 'calificacion', FILTER_VALIDATE_FLOAT),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'periodo'     => trim($_POST['periodo'] ?? ''),
        ];
        try {
            $this->notaModel->update($id, $data);
            $_SESSION['flash_success'] = 'Nota actualizada correctamente.';
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error al actualizar nota.';
        }
        header('Location: /notas'); exit;
    }

    // Eliminar nota
    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        try {
            $this->notaModel->delete($id);
            $_SESSION['flash_success'] = 'Nota eliminada correctamente.';
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error al eliminar nota.';
        }
        header('Location: /notas'); exit;
    }
}
?>