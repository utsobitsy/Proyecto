<?php
require_once __DIR__ . '/../models/Asistencia.php';
require_once __DIR__ . '/../config/db.php';

class AsistenciaController {
    private $asistenciaModel;

    public function __construct($pdo) {
        $this->asistenciaModel = new Asistencia($pdo);
    }

    public function registrarAsistencia($datos) {
        // Error: Call to unknown method: Asistencia::registrar()
        // Solución: El modelo Asistencia tiene un método registrarAsistencia($id_estudiante, $fecha, $estado).
        // Necesitas extraer los datos del array $datos y pasarlos al método correcto.
        if (is_array($datos) && isset($datos['id_estudiante'], $datos['fecha'], $datos['estado'])) {
            return $this->asistenciaModel->registrarAsistencia(
                $datos['id_estudiante'],
                $datos['fecha'],
                $datos['estado']
            );
        }
        return false; // O manejar el error de datos incorrectos
    }

    public function obtenerAsistenciaPorCurso($cursoId, $fecha = null) {
        // Error: Call to unknown method: Asistencia::porCurso()
        // Solución: El modelo Asistencia no tiene un método porCurso().
        // Tienes un método obtenerPorEstudiante($id_estudiante).
        // Necesitas implementar un método porCurso() en el modelo Asistencia
        // o usar el método existente si la lógica lo permite (quizás filtrando por curso en la consulta).
        // Por ahora, devolviendo un array vacío ya que no existe el método:
        return [];
    }

    public function obtenerResumenPorEstudiante($estudianteId) {
        // Error: Call to unknown method: Asistencia::resumenPorEstudiante()
        // Solución: El modelo Asistencia solo tiene obtenerPorEstudiante($id_estudiante).
        // Necesitas implementar un método resumenPorEstudiante() en el modelo Asistencia
        // que realice la lógica para obtener el resumen.
        // Por ahora, usando el método existente:
        return $this->asistenciaModel->obtenerPorEstudiante($estudianteId);
    }
}
?>