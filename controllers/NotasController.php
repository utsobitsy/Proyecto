<?php
require_once __DIR__ . '/../models/Nota.php';
require_once __DIR__ . '/../config/db.php';

class NotasController {
    private $notaModel;

    public function __construct($pdo) {
        $this->notaModel = new Nota($pdo);
    }

    public function obtenerNotasPorEstudiante($estudianteId, $periodo) {
        // Error: Too many arguments to function obtenerPorEstudiantes(), 2 provided, but 1 accepted.
        // Solución: El modelo Nota tiene un método obtenerPorEstudiante($id_estudiante) que acepta un solo ID.
        // Si quieres filtrar por periodo, necesitas modificar el método en el modelo Nota
        // para que acepte también el periodo en la consulta SQL.
        // Por ahora, usando el método existente y omitiendo el periodo:
        return $this->notaModel->obtenerPorEstudiante($estudianteId);
    }

    public function ingresarNota($datos) {
        // Error: Missing argument 2.5 for guardar()
        // Solución: El método guardar() en el modelo Nota espera los argumentos:
        // ($id_estudiante, $materia, $calificacion, $descripcion, $periodo)
        // Debes extraer estos valores del array $datos y pasarlos individualmente.
        if (is_array($datos) && isset($datos['id_estudiante'], $datos['materia'], $datos['calificacion'], $datos['descripcion'], $datos['periodo'])) {
            return $this->notaModel->guardar(
                $datos['id_estudiante'],
                $datos['materia'],
                $datos['calificacion'],
                $datos['descripcion'],
                $datos['periodo']
            );
        }
        return false; // O manejar el error de datos incorrectos
    }

    public function editarNota($idNota, $nuevaNota, $descripcion) {
        // Error: Call to unknown method: Nota::editarNota()
        // Solución: Necesitas agregar un método editarNota() al modelo Nota para actualizar una nota por su ID.
        // Por ahora, devolviendo false ya que no existe el método:
        return false;
    }
}
?>