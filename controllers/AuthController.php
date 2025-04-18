<?php
require_once '../config/db.php';
session_start();

class AuthController {
    private $pdo;

    // Constructor que recibe el objeto PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Mostrar la vista de login
    public function showLogin(){
        include '../views/auth/login.php';
    }

    // Verificar credenciales de usuario
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            $password = $_POST['password']; // Corregido: era $_POST('password')

            if (empty($email) || empty($password)) {
                echo "Por favor, complete todos los campos.";
                return;
            }

            $sql = "SELECT id, email, contraseña, id_rol, nombre_completo FROM usuarios WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($password, $usuario['contraseña'])){
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
                $_SESSION['id_rol'] = $usuario['id_rol'];
                $this->redirectUserByRole($usuario['id_rol']);
            } else {
                echo "Email o contraseña incorrectos.";
            }
        }
    }

    private function redirectUserByRole($roleId) {
        switch ($roleId) {
            case 1:
                header('Location: /estudiante/dashboard.php');
                break;
            case 2:
                header('Location: /padre/dashboard.php');
                break;
            case 3:
                header('Location: /profesor/dashboard.php');
                break;
            case 4:
                header('Location: /coordinador/academico.php');
                break;
            case 5:
                header('Location: /coordinador/convivencia.php');
                break;
            case 6:
                header('Location: /admin/dashboard.php');
                break;
            default:
                echo "Error: rol no válido.";
                session_destroy();
                header('Location: /views/auth/login.php?error=rol_invalido');
                break;
        }
        exit;
    }

    public function showRoleSelection() {
        if ($_SESSION['id_rol'] == 2) {
            include '../views/auth/select_role.php';
        } else {
            $this->redirectUserByRole($_SESSION['id_rol']);
        }
    }

    public function selectRole() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SESSION['id_rol'] = $_POST['role_id'];
            $this->redirectUserByRole($_SESSION['id_rol']);
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /auth/login.php');
        exit;
    }
}
?>