<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Observacion.php';
require_once __DIR__ . '/../config/db.php';

class CoordinadorController {
    private $usuarioModel;
    private $notaModel;
    private $observacionModel;

    public function __construct($pdo) {
        $this->usuarioModel = new Usuario($pdo);
        $this->notaModel = new Nota($pdo);
        $this->observacionModel = new Observacion($pdo);
    }

    public function dashboardAcademico() {
        $estudiantes = $this->usuarioModel->obtenerPorId('Estudiante'); // Asumo que quieres obtener un estudiante por ID 'Estudiante', revisa la lógica
        // Error: Too many arguments to function obtenerPorEstudiantes(), 2 provided, but 1 accepted.
        // Solución: El modelo Nota tiene dos métodos con nombres similares:
        // - obtenerPorEstudiante($id_estudiante)
        // - obtenerPorEstudiantes($estudiantes)
        // Parece que querías usar el segundo, pero le estás pasando directamente el resultado de obtenerPorId (que es un array asociativo, no un array de estudiantes).
        // Si quieres obtener las notas de *todos* los estudiantes, necesitarías primero obtener una lista de todos los estudiantes con rol 'Estudiante'.
        // Ejemplo (asumiendo que tienes un método para obtener usuarios por rol en el modelo Usuario):
        // $estudiantes = $this->usuarioModel->obtenerPorRol('Estudiante');
        // $notas = $this->notaModel->obtenerPorEstudiantes($estudiantes);
        $notas = []; // Temporalmente vacío hasta que ajustes la lógica
        require_once 'views/coordinador/academicos.php';
    }

    public function dashboardConvivencia() {
        // Error: Call to unknown method: Observacion::getAll()
        // Solución: Necesitas agregar un método getAll() al modelo Observacion.
        // Por ahora, devolviendo un array vacío hasta que implementes getAll en el modelo:
        $observaciones = [];
        require_once 'views/coordinador/convivencia.php';
    }

    public function verObservaciones() {
        $observaciones = $this->observacionModel->obtenerPorEstudiante($_SESSION['user_id']);
        require_once 'views/coordinador/observaciones.php';
    }

    public function registrarObservacion() {
        $id_estudiante = $_POST['id_estudiante'];
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['tipo'];

        // Error: Too many arguments to function __construct(), 3 provided, but 1 accepted.
        // Solución: El constructor de Observacion solo acepta $pdo.
        // Debes usar el método registrar() para guardar la observación.
        $fecha = date('Y-m-d H:i:s'); // Obtener la fecha actual
        $registrado_por = $_SESSION['user_id']; // Asumiendo que tienes la ID del usuario en sesión

        $this->observacionModel->registrar($id_estudiante, $tipo, $descripcion, $fecha, $registrado_por);

        header('Location: /coordinador/convivencia');
    }
}
?>