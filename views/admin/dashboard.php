<?php
require_once '../../includes/auth_check.php';

// Definir los roles permitidos para esta página (Admin)
$allowRole = [6];
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
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <header>
        <h1>Bienvenido, Administrador</h1>
        <nav>
            <a href="/admin/crearUsuario">Crear Usuario</a>
            <a href="/admin/dashboard">Usuarios</a>
            <a href="/admin/reportes">Ver Reportes</a>
        </nav>
    </header>
    <section>
        <h2>Usuarios Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario->nombre_completo; ?></td>
                        <td><?php echo $usuario->email; ?></td>
                        <td><?php echo $usuario->rol_nombre; ?></td>
                        <td><a href="/admin/editarUsuario/<?php echo $usuario->id; ?>">Editar</a> | <a href="/admin/eliminarUsuario/<?php echo $usuario->id; ?>">Eliminar</a></td>
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
