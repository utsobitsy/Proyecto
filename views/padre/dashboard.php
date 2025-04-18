<?php
require_once '../../includes/auth_check.php';

// Definir los roles permitidos para esta página
$allowRole = [2];
require_once '../../includes/rol_check.php';

$pageTitle = "Dashboard";

require_once '../../includes/header.php';    // Incluir la cabecera
require_once '../../includes/sidebar.php';
?>
<!-- HTML del dashboard -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Padre</title>
    <link rel="stylesheet" href="/assets/css/padre.css">
</head>
<body>
    <header>
        <h1>Bienvenido, Padre</h1>
        <nav>
            <a href="/padre/verNotas">Ver Notas</a>
            <a href="/padre/verObservaciones">Ver Observaciones</a>
        </nav>
    </header>
    <section>
        <h2>Hijos</h2>
        <ul>
            <?php foreach ($hijos as $hijo): ?>
                <li><?php echo $hijo->nombre_completo; ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>

<?php
require_once '../../includes/footer.php';    // Incluir el pie de página
?>
