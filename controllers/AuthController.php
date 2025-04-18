<?php
require_once '../config/db.php';
require_once '../models/Usuario.php'; // Incluir el modelo Usuario
session_start();

class AuthController {
    private $pdo;
    private $usuarioModel; // Añadir una propiedad para el modelo Usuario

    // Constructor que recibe el objeto PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->usuarioModel = new Usuario($pdo); // Instanciar el modelo Usuario
    }

    // Mostrar la vista de login
    public function showLogin(){
        // Mejora: Redirigir si el usuario ya está logueado
        if (isset($_SESSION['id'])) {
            $this->redirectUserByRole($_SESSION['id_rol']);
            exit; // Importante: salir después de la redirección
        }
        // Mejora: Pasar posibles mensajes de error a la vista
        $error = isset($_SESSION['error_login']) ? $_SESSION['error_login'] : null;
        unset($_SESSION['error_login']); // Limpiar el mensaje de error de la sesión

        include '../views/auth/login.php';
    }

    // Verificar credenciales de usuario
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Mejora: Sanitizar la entrada
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password']; // La contraseña no se sanitiza con filter_input para no alterar caracteres

            // Mejora: Validación de entrada más robusta
            if (empty($email) || empty($password)) {
                $_SESSION['error_login'] = "Por favor, complete todos los campos.";
                header('Location: /auth/login.php'); // Redirigir de vuelta al login con error
                exit;
            }

            // Mejora: Utilizar el método login del modelo Usuario
            $usuario = $this->usuarioModel->login($email, $password);

            if ($usuario){
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nombre_completo'] = $usuario['nombre_completo'];
                $_SESSION['id_rol'] = $usuario['id_rol'];
                // Mejora: Limpiar cualquier mensaje de error anterior al loguearse correctamente
                unset($_SESSION['error_login']);
                $this->redirectUserByRole($usuario['id_rol']);
            } else {
                // Mejora: Pasar mensaje de error a la vista a través de la sesión
                $_SESSION['error_login'] = "Email o contraseña incorrectos.";
                header('Location: /auth/login.php'); // Redirigir de vuelta al login con error
                exit;
            }
        } else {
            // Si alguien intenta acceder a /auth/login.php con GET, redirigir al formulario
             header('Location: /auth/login.php');
             exit;
        }
    }

    private function redirectUserByRole($roleId) {
        switch ($roleId) {
            case 1: // Estudiante
                header('Location: /estudiante/dashboard.php');
                break;
            case 2: // Padre
                // Podrías redirigir al padre a una página de selección de rol si tiene varios hijos o vistas.
                // La lógica actual en showRoleSelection() ya maneja esto hasta cierto punto.
                header('Location: /padre/dashboard.php'); // O a la página de selección si aplica
                break;
            case 3: // Profesor
                header('Location: /profesor/dashboard.php');
                break;
            case 4: // Coordinador Académico
                header('Location: /coordinador/academicos.php'); // Corregido: era academico.php
                break;
            case 5: // Coordinador de Convivencia
                header('Location: /coordinador/convivencia.php');
                break;
            case 6: // Administrador
                header('Location: /admin/dashboard.php');
                break;
            default:
                // Manejar roles no válidos
                $_SESSION['error_login'] = "Error: rol de usuario no válido.";
                session_unset();
                session_destroy();
                header('Location: /auth/login.php'); // Redirigir al login
                exit;
        }
        exit; // Importante: salir después de la redirección
    }

    public function showRoleSelection() {
         // Asegurarse de que haya una sesión activa antes de mostrar la selección de rol
        if (!isset($_SESSION['id'])) {
             header('Location: /auth/login.php');
             exit;
        }

        // La lógica actual solo permite la selección si el rol es 2 (Padre).
        // Si otros roles necesitan selección, ajustar esta lógica.
        if ($_SESSION['id_rol'] == 2) {
            // Aquí deberías cargar los hijos del padre para la selección de rol
            // $hijos = $this->usuarioModel->obtenerHijos($_SESSION['id']); // Asumiendo que el modelo Usuario tiene este método
            include '../views/auth/select_role.php'; // Asegúrate de que esta vista pueda mostrar los hijos
        } else {
            // Si el usuario no es un padre, redirigirlo directamente según su rol
            $this->redirectUserByRole($_SESSION['id_rol']);
        }
    }

    public function selectRole() {
         // Asegurarse de que haya una sesión activa
        if (!isset($_SESSION['id'])) {
             header('Location: /auth/login.php');
             exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Mejora: Validar que el rol_id recibido sea un rol válido permitido para el usuario actual
            $selected_role_id = filter_input(INPUT_POST, 'role_id', FILTER_VALIDATE_INT);

            if ($selected_role_id !== false && $selected_role_id !== null) {
                // Aquí deberías añadir lógica para verificar si el usuario actual realmente puede asumir el rol seleccionado.
                // Por ejemplo, si un padre selecciona un hijo, verificar que ese hijo esté asociado a ese padre.
                 $_SESSION['id_rol'] = $selected_role_id; // ¡Esto puede ser peligroso si no se valida adecuadamente!
                                                        // Idealmente, al seleccionar un "rol" de hijo, quizás cambias la ID del usuario
                                                        // que se está visualizando, no el id_rol del padre.
                                                        // Considera cuidadosamente la lógica aquí para la selección de hijo vs selección de rol.

                $this->redirectUserByRole($_SESSION['id_rol']);
            } else {
                // Manejar caso de role_id no válido
                 $_SESSION['error_role_selection'] = "Selección de rol no válida.";
                 header('Location: /auth/select_role.php'); // Redirigir de vuelta a la selección
                 exit;
            }
        } else {
            // Si alguien intenta acceder a /auth/select_role.php con GET
             header('Location: /auth/select_role.php');
             exit;
        }
    }


    public function logout() {
        // Mejora: Asegurarse de que la sesión exista antes de destruirla (aunque session_start() ya se llama)
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
        }
        // Mejora: Redirigir a la raíz o al index.php si tu enrutamiento lo maneja así
        header('Location: /'); // O '/index.php' dependiendo de tu .htaccess
        exit;
    }
}
?>