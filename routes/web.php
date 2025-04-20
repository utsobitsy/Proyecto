<?php
// routes/web.php

use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\AsistenciaController;
use Controllers\CoordinadorController;
use Controllers\EstudianteController;
use Controllers\HorarioController;
use Controllers\MensajeriaController;
use Controllers\NotasController;
use Controllers\ObservacionesController;
use Controllers\PadreController;
use Controllers\ProfesorController;

// Inicializar router (ejemplo con AltoRouter o similar)
$router = new \AltoRouter();

// Ajustar base path a la subcarpeta del proyecto en XAMPP
try {
    $router->setBasePath('/proyecto/Proyecto');
} catch (\Exception $e) {
    // Ignorar si no coincide
}

// Ruta por defecto: redirigir la raíz al login
$router->get('', [AuthController::class, 'showLoginForm']);
$router->get('/', [AuthController::class, 'showLoginForm']);

// Auth
$router->get ('/auth/login',            [AuthController::class, 'showLoginForm']);
$router->post('/auth/login',            [AuthController::class, 'login']);
$router->get ('/auth/select-role',      [AuthController::class, 'showSelectRole']);
$router->post('/auth/select-role',      [AuthController::class, 'selectRole']);
$router->get ('/auth/logout',           [AuthController::class, 'logout']);

// Admin
$router->get ('/admin/usuarios',        [AdminController::class, 'index']);
$router->get ('/admin/usuarios/create', [AdminController::class, 'create']);
$router->post('/admin/usuarios/store',  [AdminController::class, 'store']);
$router->get ('/admin/usuarios/edit',   [AdminController::class, 'edit']);
$router->post('/admin/usuarios/update', [AdminController::class, 'update']);
$router->post('/admin/usuarios/destroy',[AdminController::class, 'destroy']);
$router->get ('/admin/usuarios/report', [AdminController::class, 'report']);

// Asistencia
$router->get ('/asistencia',            [AsistenciaController::class, 'index']);
$router->get ('/asistencia/create',     [AsistenciaController::class, 'create']);
$router->post('/asistencia/store',      [AsistenciaController::class, 'store']);
$router->post('/asistencia/destroy',    [AsistenciaController::class, 'destroy']);

// Coordinador
$router->get ('/coordinador/academico', [CoordinadorController::class, 'academico']);
$router->get ('/coordinador/convivencia',[CoordinadorController::class, 'convivencia']);

// Estudiante
$router->get ('/estudiante/dashboard',  [EstudianteController::class, 'dashboard']);
$router->get ('/estudiante/notas',      [EstudianteController::class, 'notas']);
$router->get ('/estudiante/horario',    [EstudianteController::class, 'horario']);

// Horario
$router->get ('/horario',               [HorarioController::class, 'index']);
$router->get ('/horario/create',        [HorarioController::class, 'create']);
$router->post('/horario/store',         [HorarioController::class, 'store']);

// Mensajería
$router->get ('/mensajes',              [MensajeriaController::class, 'index']);
$router->post('/mensajes/send',         [MensajeriaController::class, 'send']);
$router->get ('/mensajes/conversacion', [MensajeriaController::class, 'conversation']);

// Notas
$router->get ('/notas',                 [NotasController::class, 'index']);
$router->get ('/notas/create',          [NotasController::class, 'create']);
$router->post('/notas/store',           [NotasController::class, 'store']);
$router->get ('/notas/edit',            [NotasController::class, 'edit']);
$router->post('/notas/update',          [NotasController::class, 'update']);
$router->post('/notas/destroy',         [NotasController::class, 'destroy']);

// Observaciones
$router->get ('/observaciones',         [ObservacionesController::class, 'index']);
$router->get ('/observaciones/create',  [ObservacionesController::class, 'create']);
$router->post('/observaciones/store',   [ObservacionesController::class, 'store']);
$router->post('/observaciones/destroy', [ObservacionesController::class, 'destroy']);

// Padre
$router->get ('/padre/dashboard',       [PadreController::class, 'dashboard']);
$router->get ('/padre/notas',           [PadreController::class, 'notas']);
$router->get ('/padre/asistencia',      [PadreController::class, 'asistencia']);

// Profesor
$router->get ('/profesor/dashboard',    [ProfesorController::class, 'dashboard']);
$router->get ('/profesor/notas',        [ProfesorController::class, 'notas']);
$router->get ('/profesor/asistencia',   [ProfesorController::class, 'asistencia']);

// Disparar el despacho de la ruta actual
$match = $router->match();
if ($match && is_array($match['target'])) {
    list($controller, $method) = $match['target'];
    call_user_func_array([new $controller, $method], [$match['params']]);
} else {
    // 404
    header("HTTP/1.0 404 Not Found");
    echo "Página no encontrada";
}