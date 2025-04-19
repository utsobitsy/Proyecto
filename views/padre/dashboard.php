<?php
require_once __DIR__ . '/../includes/auth_check.php';

// Definir los roles permitidos para esta página
$allowRole = [2];
require_once '../../includes/rol_check.php';

$pageTitle = "Dashboard";
require_once '../../includes/header.php'; // Incluir header
require_once '../../includes/sidebar.php';
?>
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
            <a href="/padre/notas">Ver Notas</a>
            <a href="/padre/asistencia">Ver Asistencia</a>
        </nav>
    </header>
    <section>
        <h2>Seleccionar hijo</h2>
        <form action="" method="GET" class="mb-3">
            <select name="id_estudiante" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                <?php foreach ($hijos as $hijo): ?>
                    <option value="<?php echo $hijo['id']; ?>" <?php echo ($hijo['id'] == $_SESSION['id_estudiante_activo'] ?? null) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($hijo['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
        <hr>
        <h3>Resumen del hijo seleccionado</h3>
        <h4>Últimas Calificaciones</h4>
        <ul>
            <?php foreach ($notas as $nota): ?>
                <li><?php echo $nota['materia']; ?>: <?php echo $nota['calificacion']; ?> (<?php echo $nota['periodo']; ?>)</li>
            <?php endforeach; ?>
        </ul>

        <h4>Historial de Asistencia</h4>
        <ul>
            <?php foreach ($asistencias as $asis): ?>
                <li><?php echo $asis['fecha']; ?>: <?php echo $asis['estado']; ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>

<?php
require_once '../../includes/footer.php';    // Incluir el pie de página
?>
