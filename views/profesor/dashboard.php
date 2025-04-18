<?php
require_once '../../includes/auth_check.php';

$pageTitle = "Dashboard";

require_once '../../includes/header.php';    // Incluir la cabecera
require_once '../../includes/sidebar.php';

// Definir los roles permitidos para esta página
$allowRole = [3];
require_once '../../includes/rol_check.php';

// Cargar datos del usuario desde la sesión
$usuario = (object)[
    'nombre_completo' => $_SESSION['nombre_completo']
];

// Simulación de datos para la sección de materias
$materias = [
    (object)['nombre' => 'Matemáticas', 'descripcion' => 'Álgebra y geometría'],
    (object)['nombre' => 'Física', 'descripcion' => 'Leyes del movimiento']
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Profesor</title>
    <link rel="stylesheet" href="/assets/css/profesor.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario->nombre_completo); ?></h1>
        <nav>
            <a href="/profesor/editarNotas">Editar Notas</a>
            <a href="/profesor/registrarAsistencia">Registrar Asistencia</a>
            <a href="/profesor/verAsistencia">Ver Asistencia</a>
        </nav>
    </header>
    <section>
        <h2>Mis Materias</h2>
        <ul>
            <?php foreach ($materias as $materia): ?>
                <li><?php echo htmlspecialchars($materia->nombre); ?> - <?php echo htmlspecialchars($materia->descripcion); ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
</body>
</html>
<?php
require_once '../../includes/footer.php';    // Incluir el pie de página
?>