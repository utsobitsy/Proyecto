<?php
require_once '../../includes/auth_check.php';
require_once '../../includes/rol_check.php';
verificarRol('Estudiante');
?>
<!-- HTML del dashboard -->

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel Estudiante</title>
</head>
<body>
    <h1>Bienvenido Estudiante: <?php echo $_SESSION['nombre_completo']; ?></h1>
    <p>Aquí verás tus notas, observaciones y gráficos de progreso.</p>
</body>
</html>
