<?php
// Incluir configuración de base de datos y el controlador
require_once '../config/db.php';
require_once '../controllers/AuthController.php';

// Crear instancia del controlador con la conexión PDO
$authController = new AuthController($pdo);

// Rutas de autenticación
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri == '/auth/login.php' && $requestMethod == 'GET') {
    $authController->showLogin();
} elseif ($requestUri == '/auth/login.php' && $requestMethod == 'POST') {
    $authController->login();
} elseif ($requestUri == '/auth/select_role.php' && $requestMethod == 'GET') {
    $authController->showRoleSelection();
} elseif ($requestUri == '/auth/select_role.php' && $requestMethod == 'POST') {
    $authController->selectRole();
} elseif ($requestUri == '/auth/logout.php') {
    $authController->logout();
}
?>
