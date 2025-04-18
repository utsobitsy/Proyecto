<?php
require_once '../../includes/auth_check.php';

// Definir los roles permitidos para esta página
$allowRole = [5];
require_once '../../includes/rol_check.php';

$pageTitle = "Dashboard";

require_once '../../includes/header.php';    // Incluir la cabecera
require_once '../../includes/sidebar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Coordinador de Convivencia</title>
    <link rel="stylesheet" href="/assets/css/coordinador.css">
</head>
<body>
    <header>
        <h1>Bienvenido, Coordinador de Convivencia</h1>
        <nav>
            <a href="/coordinador/dashboardConvivencia">Resumen Disciplinario</a>
            <a href="/coordinador/verAsistencia">Ver Asistencia</a>
        </nav>
    </header>
    <section>
        <h2>Observaciones Disciplinarias</h2>
        <table>
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($observaciones as $observacion): ?>
                    <tr>
                        <td><?php echo $observacion->estudiante_nombre; ?></td>
                        <td><?php echo $observacion->tipo; ?></td>
                        <td><?php echo $observacion->descripcion; ?></td>
                        <td><?php echo $observacion->fecha; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>
<?php
require_once '../../includes/footer.php';    // Incluir el pie de página
?>
