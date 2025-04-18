<?php
session_start(); // Asegúrate de que la sesión esté iniciada

if (!isset($_SESSION['id'])) {
    // Redirigir al usuario a la página de login si no está logueado
    header('Location: /auth/login.php'); // Ajusta la ruta si es necesario
    exit;
}
?>