<?php
// Refactorización con CSRF, modelo Usuario y flujo de login/logout y selección de rol

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/UsuarioAuth.php';

namespace Controllers;

class AuthController {
    private $userModel;

    public function __construct() {
        session_start();
        $this->userModel = new Usuario();
    }

    // Mostrar formulario de login
    public function showLoginForm() {
        // Generar token CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        include __DIR__ . '/../views/auth/login.php';
    }

    // Procesar login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
            !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }

        $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            $_SESSION['flash_error'] = 'Email y contraseña son obligatorios.';
            header('Location: /auth/login'); exit;
        }

        // Buscar usuario
        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['contraseña'])) {
            $_SESSION['flash_error'] = 'Credenciales incorrectas.';
            header('Location: /auth/login'); exit;
        }

        // Guardar datos en sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['roles'] = explode(',', $user['rol']); // si tienes múltiples roles separados por comas

        // Si es Estudiante o Padre, mostrar selección de vista
        if (in_array('Estudiante', $_SESSION['roles']) && in_array('Padre', $_SESSION['roles'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            include __DIR__ . '/../views/auth/select_role.php';
            return;
        }

        // Si solo tiene un rol, redirigir directamente
        $rol = $_SESSION['roles'][0];
        $this->redirectByRole($rol);
    }

    // Procesar selección de rol (Estudiante o Padre)
    public function selectRole() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
            !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }

        $rol = $_POST['role'] ?? '';
        if (!in_array($rol, $_SESSION['roles'])) {
            $_SESSION['flash_error'] = 'Rol inválido.';
            header('Location: /auth/select-role'); exit;
        }

        $_SESSION['rol'] = $rol;
        $this->redirectByRole($rol);
    }

    // Cerrar sesión
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /auth/login');
        exit;
    }

    // Redirige al dashboard según rol
    private function redirectByRole(string $rol) {
        switch ($rol) {
            case 'Administrador':
                header('Location: views/admin/usuarios'); break;
            case 'Coordinador':
                header('Location: views/coordinador/academico'); break;
            case 'Profesor':
                header('Location: views/profesor/dashboard'); break;
            case 'Estudiante':
                $_SESSION['rol'] = 'Estudiante';
                header('Location: views/estudiante/dashboard'); break;
            case 'Padre':
                $_SESSION['rol'] = 'Padre';
                header('Location: views/padre/dashboard'); break;
            default:
                header('Location: views/auth/denied_access'); break;
        }
        exit;
    }
}
?>