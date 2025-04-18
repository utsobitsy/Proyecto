<?php
// Este archivo se incluiría después de auth_check.php

// $allowedRoles debe ser un array definido antes de incluir este archivo
// Ejemplo: $allowedRoles = [1, 6]; // Permitir roles de Estudiante y Administrador

if (!isset($allowedRoles) || !is_array($allowedRoles)) {
    // Manejar un error de configuración si no se definen los roles permitidos
    die("Error de configuración: Roles permitidos no especificados.");
}

if (!in_array($_SESSION['id_rol'], $allowedRoles)) {
    // Redirigir si el rol del usuario no está permitido
    // Podrías redirigir a una página de acceso denegado o a su dashboard
    header('Location: /acceso_denegado.php'); // Crea una página de acceso denegado
    exit;
}
?>