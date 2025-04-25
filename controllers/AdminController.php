<?php
    // Refactorización usando modelos, validación, CSRF y paginación

namespace Controllers;

require once __DIR__ . '/../config/db.php';
require once __DIR__ . '/../models/Usuario.php';
require once __DIR__ . '/../models/Rol.php';

class AdminController {
    private $userModel;

    public function __construct() {
        session_start();
        // Verificar que el usuario es admin
        if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador'){
            header('Location: /auth/denied_access');
            exit;
        }
        $this->userModel = new Usuario();
    }

    // Mostrar lista de usuarios con paginación
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $users = $this->userModel->getPaginated($perPage, $offset);
        $total = $this->userModel->countAll();
        $totalPages = ceil($total / $perPage);

        include __DIR__ . '/../views/admin/usuarios.php'
    }

    // Mostrar formulario de creación de usuario
    public function create() {
        // Generar toke CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        include __DIR__ . '/views/admin/usuario_form.php';
    }

    // Almacenar nuevo usuario
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
           die('Acceso inválido');
        }

        //Validar entradas
        $nombre = trim($_POST['nombre']);
        $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
        $rol = $_POST['rol'];

        if(!$nombre || !$correo || !$rol) {
            $_SESSION['flash_error'] = 'Todos los campos son obligatorios.';
            header('Location: /admin/usuarios/create');
            exit;
        }

        // Crear usuario
        try {
            $id = $this->userModel->create([
                'nombre' => $nombre,
                'correo' => $correo,
                'contraseña' => $_POST['contraseña'], // dentro del modelo se encripta
                'rol' => $rol
            ]);
            $_SESSION['flash_success'] = 'Usuario creado con ID ' . $id;
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error al crear usuario.';
        }

        header('Location: /admin/usuarios');
        exit;
    }

    // Mostrar formulario de edición
    public function edit(){
        $id = (int)$_GET['id'];
        $user = $this->userModel->findById($id);
        if (!$user) {
            header('Location: /admin/usuarios');
            exit;
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        include __DIR__ . '/../views/admin/usuario_edit.php';
    }

    // Actualizar usuario
    public function update(){
        if ($_SERVE['REQUEST_METHOD'] !== 'POST' ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')){
            die('Acceso inválido');
        }

        $id = (int)$_POST['id'];
        $nombre = trim($_POST['nombre']);
        $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
        $rol = $_POST['rol'];

        try {
            $ok = $this->userModel->update($id, [
                'nombre' => $nombre,
                'correo' => $correo,
                'rol' => $rol
            ]);
            $_SESSION['flash_success'] = $ok ? 'Usuario actualizado.' : 'No se realizaron cambios.';
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error al actualizar usuario.';
        }

        header('Location: /admin/usuarios');
        exit;
    }

    // Eliminar usuario
    public function destroy() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || 
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }

        $id = (int)$_POST['id'];
        try {
            $this->userModel->delete($id);
            $_SESSION['flash_success'] = 'Usuario eliminado.';
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error al eliminar usuario.';
        }

        header('Location: /admin/usuarios');
        exit;
    }

    // Reporte de usuarios (descargar PDF/Excel)
    public function report(){
        // Logica para generar reportes, usando PHPSpreadsheet o TCPDF
    }
}
?>