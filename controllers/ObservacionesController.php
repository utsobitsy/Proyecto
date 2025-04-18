<?php
require_once __DIR__ . '/../models/Observacion.php';
require_once __DIR__ . '/../config/db.php';

class ObservacionesController {
    private $observacionModel;

    public function __construct($pdo) {
        $this->observacionModel = new Observacion($pdo);
    }

    public function agregarObservacion($datos) {
        return $this->observacionModel->registrar(
            $datos['id_estudiante'],
            $datos['tipo'],
            $datos['descripcion'],
            $datos['fecha'],
            $datos['registrado_por']
        );
    }

    public function obtenerPorEstudiante($estudianteId) {
        return $this->observacionModel->obtenerPorEstudiante($estudianteId);
    }
}
