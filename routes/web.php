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
$router = new AltoRouter();

// Ajustar base path a la subcarpeta del proyecto en XAMPP
try {
    $router->setBasePath('/proyecto/Proyecto');
} catch (\Exception $e) {
    // Ignorar si no coincide
}

// Ruta por defecto: redirigir la raíz al login
$router->map('GET', '/', [AuthController::class, 'showLoginForm']);

// Auth
$router->map('GET',  '/auth/login',        [AuthController::class, 'showLoginForm']);
$router->map('POST', '/auth/login',        [AuthController::class, 'login']);
$router->map('GET',  '/auth/select-role',  [AuthController::class, 'showSelectRole']);
$router->map('POST', '/auth/select-role',  [AuthController::class, 'selectRole']);
$router->map('GET',  '/auth/logout',       [AuthController::class, 'logout']);

// Admin
$router->map('GET',  '/admin/usuarios',         [AdminController::class, 'index']);
$router->map('GET',  '/admin/usuarios/create',  [AdminController::class, 'create']);
$router->map('POST', '/admin/usuarios/store',   [AdminController::class, 'store']);
$router->map('GET',  '/admin/usuarios/edit',    [AdminController::class, 'edit']);
$router->map('POST', '/admin/usuarios/update',  [AdminController::class, 'update']);
$router->map('POST', '/admin/usuarios/destroy', [AdminController::class, 'destroy']);
$router->map('GET',  '/admin/usuarios/report',  [AdminController::class, 'report']);

// Asistencia
$router->map('GET',  '/asistencia',         [AsistenciaController::class, 'index']);
$router->map('GET',  '/asistencia/create',  [AsistenciaController::class, 'create']);
$router->map('POST', '/asistencia/store',   [AsistenciaController::class, 'store']);
$router->map('POST', '/asistencia/destroy', [AsistenciaController::class, 'destroy']);

// Coordinador
$router->map('GET', '/coordinador/academico',   [CoordinadorController::class, 'academico']);
$router->map('GET', '/coordinador/convivencia', [CoordinadorController::class, 'convivencia']);

// Estudiante
$router->map('GET', '/estudiante/dashboard', [EstudianteController::class, 'dashboard']);
$router->map('GET', '/estudiante/notas',     [EstudianteController::class, 'notas']);
$router->map('GET', '/estudiante/horario',   [EstudianteController::class, 'horario']);

// Horario
$router->map('GET',  '/horario',         [HorarioController::class, 'index']);
$router->map('GET',  '/horario/create',  [HorarioController::class, 'create']);
$router->map('POST', '/horario/store',   [HorarioController::class, 'store']);

// Mensajería
$router->map('GET',  '/mensajes',               [MensajeriaController::class, 'index']);
$router->map('POST', '/mensajes/send',          [MensajeriaController::class, 'send']);
$router->map('GET',  '/mensajes/conversacion',  [MensajeriaController::class, 'conversation']);

// Notas
$router->map('GET',  '/notas',         [NotasController::class, 'index']);
$router->map('GET',  '/notas/create',  [NotasController::class, 'create']);
$router->map('POST', '/notas/store',   [NotasController::class, 'store']);
$router->map('GET',  '/notas/edit',    [NotasController::class, 'edit']);
$router->map('POST', '/notas/update',  [NotasController::class, 'update']);
$router->map('POST', '/notas/destroy', [NotasController::class, 'destroy']);

// Observaciones
$router->map('GET',  '/observaciones',         [ObservacionesController::class, 'index']);
$router->map('GET',  '/observaciones/create',  [ObservacionesController::class, 'create']);
$router->map('POST', '/observaciones/store',   [ObservacionesController::class, 'store']);
$router->map('POST', '/observaciones/destroy', [ObservacionesController::class, 'destroy']);

// Padre
$router->map('GET', '/padre/dashboard',   [PadreController::class, 'dashboard']);
$router->map('GET', '/padre/notas',       [PadreController::class, 'notas']);
$router->map('GET', '/padre/asistencia',  [PadreController::class, 'asistencia']);

// Profesor
$router->map('GET', '/profesor/dashboard',  [ProfesorController::class, 'dashboard']);
$router->map('GET', '/profesor/notas',      [ProfesorController::class, 'notas']);
$router->map('GET', '/profesor/asistencia', [ProfesorController::class, 'asistencia']);

// Ejecutar ruta actual
$match = $router->match();
if ($match && is_array($match['target'])) {
    list($controller, $method) = $match['target'];
    call_user_func_array([new $controller, $method], [$match['params']]);
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Página no encontrada";
}