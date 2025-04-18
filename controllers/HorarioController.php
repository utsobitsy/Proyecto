<?php
require_once __DIR__ . '/../models/Horario.php';
require_once __DIR__ . '/../config/db.php';

class HorarioController {
    private $horarioModel;

    public function __construct($pdo) {
        $this->horarioModel = new Horario($pdo);
    }

    public function obtenerHorarioPorCurso($cursoId, $tipo = 'normal') {
        if (!$cursoId) return [];
        // Error: Call to unknown method: Horario::porCurso()
        // Solución: El modelo Horario tiene obtenerHorarioNormal y obtenerHorarioExamen.
        // Debes usar el parámetro $tipo para decidir cuál método llamar.
        if ($tipo === 'normal') {
            return $this->horarioModel->obtenerHorarioNormal($cursoId);
        } elseif ($tipo === 'examen') {
            return $this->horarioModel->obtenerHorarioExamen($cursoId);
        } else {
            return []; // O manejar el caso de tipo desconocido
        }
    }

    public function agregarHorario($datos) {
        // Error: Call to unknown method: Horario::agregar()
        // Solución: Necesitas agregar un método agregar() al modelo Horario para insertar datos.
        // Por ahora, devolviendo false ya que no existe el método:
        return false;
    }
}
?>