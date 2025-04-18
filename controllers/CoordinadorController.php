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

<?php
// Refactorización para funcionalidades Académico y Convivencia
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Observacion.php';

class CoordinadorController {
    private $notaModel;
    private $userModel;
    private $obsModel;

    public function __construct() {
        session_start();
        // Solo Coordinadores pueden acceder
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Coordinador') {
            header('Location: /auth/denied_access');
            exit;
        }
        $this->notaModel = new Nota();
        $this->userModel = new Usuario();
        $this->obsModel  = new Observacion();
    }

    // Vista Académico: supervisión de calificaciones
    public function academico() {
        // Paginación simple
        $page = isset($_GET['page']) ? max(1, (int)\$_GET['page']) : 1;
        \$perPage = 20;
        \$offset = (\$page - 1) * \$perPage;

        // Obtener todas las notas con JOIN para mostrar nombres
        \$grades = \$this->notaModel->getPaginatedWithStudentAndSubject(\$perPage, \$offset);
        \$total  = \$this->notaModel->countAll();
        \$totalPages = ceil(\$total / \$perPage);

        include __DIR__ . '/../views/coordinador/academico.php';
    }

    // Vista Convivencia: gestión de observaciones disciplinarias
    public function convivencia() {
        \$observations = \$this->obsModel->getAllOrdered();
        include __DIR__ . '/../views/coordinador/convivencia.php';
    }

    // Mostrar formulario para agregar observación
    public function createObservation() {
        \$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        // Lista de estudiantes para seleccionar receptor
        \$students = \$this->userModel->getAllByRole('Estudiante');
        include __DIR__ . '/../views/coordinador/observacion_form.php';
    }

    // Guardar nueva observación
    public function storeObservation() {
        if (\$_SERVER['REQUEST_METHOD'] !== 'POST' || 
            !hash_equals(\$_SESSION['csrf_token'] ?? '', \$_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }

        \$idRec = filter_input(INPUT_POST, 'id_receptor', FILTER_VALIDATE_INT);
        \$tipo  = trim(\$_POST['tipo'] ?? '');
        \$comentario = trim(\$_POST['comentario'] ?? '');

        if (!\$idRec || !\$tipo || !\$comentario) {
            \$_SESSION['flash_error'] = 'Todos los campos son obligatorios.';
            header('Location: /coordinador/convivencia/create');
            exit;
        }

        try {
            \$this->obsModel->create([
                'id_emisor'   => \$_SESSION['user_id'],
                'id_receptor' => \$idRec,
                'tipo'        => \$tipo,
                'comentario'  => \$comentario
            ]);
            \$_SESSION['flash_success'] = 'Observación guardada correctamente.';
        } catch (Exception \$e) {
            \$_SESSION['flash_error'] = 'Error al guardar observación.';
        }

        header('Location: /coordinador/convivencia');
        exit;
    }

    // Eliminar observación
    public function destroyObservation() {
        if (\$_SERVER['REQUEST_METHOD'] !== 'POST' || 
            !hash_equals(\$_SESSION['csrf_token'] ?? '', \$_POST['csrf_token'] ?? '')) {
            die('Acceso inválido');
        }
        \$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if (!\$id) {
            \$_SESSION['flash_error'] = 'ID inválido.';
        } else {
            try {
                \$this->obsModel->delete(\$id);
                \$_SESSION['flash_success'] = 'Observación eliminada.';
            } catch (Exception \$e) {
                \$_SESSION['flash_error'] = 'Error al eliminar observación.';
            }
        }
        header('Location: /coordinador/convivencia');
        exit;
    }
}
?>