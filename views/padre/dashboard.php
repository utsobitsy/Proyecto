<?php
require_once '../../includes/auth_check.php';
require_once '../../includes/rol_check.php';
verificarRol('Padre');
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
