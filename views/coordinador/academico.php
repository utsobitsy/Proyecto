<?php
require_once '../../includes/auth_check.php';

// Definir los roles permitidos para esta página
$allowRole = [4];
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
    <title>Dashboard Coordinador Académico</title>
    <link rel="stylesheet" href="/assets/css/coordinador.css">
</head>
<body>
    <header>
        <h1>Bienvenido, Coordinador Académico</h1>
        <nav>
            <a href="/coordinador/dashboardAcademico">Resumen Académico</a>
            <a href="/coordinador/verObservaciones">Ver Observaciones</a>
        </nav>
    </header>
    <section>
        <h2>Estudiantes y Notas</h2>
        <table>
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Materia</th>
                    <th>Nota</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?php echo $nota->estudiante_nombre; ?></td>
                        <td><?php echo $nota->materia_nombre; ?></td>
                        <td><?php echo $nota->calificacion; ?></td>
                        <td><a href="/coordinador/editarNota/<?php echo $nota->id; ?>">Editar</a></td>
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