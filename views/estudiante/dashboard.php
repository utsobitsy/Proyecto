<?php
require_once '../../includes/auth_check.php';

// Definir los roles permitidos para esta página (Estudiante, Admin)
$allowRole = [1];
require_once '../../includes/rol_check.php';

$pageTitle = "Dashboard";

require_once '../../includes/header.php';    // Incluir la cabecera
require_once '../../includes/sidebar.php';
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

<?php
require_once '../../includes/footer.php';    // Incluir el pie de página
?>
