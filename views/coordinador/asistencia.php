<?php
// Listado de registros de asistencia
$pageTitle = 'Control de Asistencia';
include __DIR__ . '/../../includes/header.php';
?>
<div class="container mt-4">
    <h2>Control de Asistencia</h2>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="/asistencia/create" class="btn btn-primary">Registrar nueva asistencia</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Estudiante</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Presente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($records)): ?>
            <?php foreach ($records as $r): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['id_estudiante']); ?></td>
                    <td><?php echo htmlspecialchars($r['nombre'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($r['fecha']); ?></td>
                    <td><?php echo $r['presente'] ? 'Sí' : 'No'; ?></td>
                    <td>
                        <form action="/asistencia/destroy" method="post" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
                            <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este registro?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">No hay registros de asistencia.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>