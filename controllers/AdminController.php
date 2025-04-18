<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/db.php';

class AdminController {
    private $usuarioModel;

    public function __construct($pdo) {
        $this->usuarioModel = new Usuario($pdo);
    }

    public function dashboard() {
        // Error: Call to unknown method: Usuario::getAll()
        // Solución: Necesitas agregar un método getAll() al modelo Usuario.
        // Por ahora, si quieres mostrar todos los usuarios, podrías adaptar el método obtenerPorId.
        // Sin embargo, lo ideal es crear un getAll en el modelo Usuario.
        // Ejemplo (tendrías que implementarlo en Usuario.php):
        // $usuarios = $this->usuarioModel->getAll();
        $usuarios = []; // Temporalmente vacío hasta que implementes getAll en el modelo
        require_once 'views/admin/dashboard.php';
    }

    public function crearUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $nombre = $_POST['nombre_completo'];
            $password = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
            $rol = $_POST['id_rol'];

            // Error: Call to unknown method: Usuario::crear()
            // Solución: Necesitas agregar un método crear() al modelo Usuario que inserte un nuevo usuario.
            // Ejemplo (tendrías que implementarlo en Usuario.php):
            // $this->usuarioModel->crear($email, $nombre, $password, $rol);
            // Por ahora, asumiendo que tienes una forma de crear usuarios en tu modelo:
            // $this->usuarioModel->insertarUsuario($email, $nombre, $password, $rol); // Ejemplo de nombre de método
            // ¡Implementa el método correcto en Usuario.php!

            header('Location: /admin/dashboard');
        }
        require_once 'views/admin/crear_usuario.php';
    }

    public function editarUsuario($id) {
        // Error: Call to unknown method: Usuario::getById()
        // Solución: El modelo Usuario tiene un método obtenerPorId($id). Úsalo.
        $usuario = $this->usuarioModel->obtenerPorId($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario['nombre_completo'] = $_POST['nombre_completo'];
            $usuario['email'] = $_POST['email'];
            $usuario['id_rol'] = $_POST['id_rol'];
            // Error: Call to unknown method: Usuario::save()
            // Solución: El modelo Usuario no tiene un método save(). Necesitas implementar un método para actualizar un usuario por su ID.
            // Ejemplo (tendrías que implementarlo en Usuario.php):
            // $this->usuarioModel->actualizarUsuario($id, $usuario['nombre_completo'], $usuario['email'], $usuario['id_rol']);
            // ¡Implementa el método correcto en Usuario.php!

            header('Location: /admin/dashboard');
        }
        require_once 'views/admin/editar_usuario.php';
    }

    public function eliminarUsuario($id) {
        // Error: Call to unknown method: Usuario::getById()
        // Solución: Usa el método existente obtenerPorId($id).
        $usuario = $this->usuarioModel->obtenerPorId($id);
        // Error: Call to unknown method: Usuario::delete()
        // Solución: Necesitas agregar un método delete() al modelo Usuario para eliminar un usuario por su ID.
        // Ejemplo (tendrías que implementarlo en Usuario.php):
        // $this->usuarioModel->eliminarUsuario($id);
        // ¡Implementa el método correcto en Usuario.php!
        header('Location: /admin/dashboard');
    }
}
?>