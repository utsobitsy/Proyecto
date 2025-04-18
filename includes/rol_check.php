<?php
function verificarRol($rolPermitido) {
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== $rolPermitido) {
        header("Location: /index.php"); // O a una página de error
        exit();
    }
}
?>