<?php
require_once __DIR__ . '/../../includes/auth_check.php';
$allowRole = [2];
require_once __DIR__ . '/../../includes/rol_check.php';

$pageTitle = 'Asistencia del Hijo';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2>Asistencia</h2>
    <!-- Selector de hijo -->
    <form method="GET" class="mb-3">
        <select name="id_estudiante" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
            <?php foreach ($hijos as $hijo): ?>
                <option value="<?php echo $hijo['id']; ?>" <?php echo ($hijo['id'] == $_SESSION['id_estudiante_activo']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hijo['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <!-- Tabla de asistencia -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Presente</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($asistencias)): ?>
                <?php foreach ($asistencias as $a): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($a['fecha']); ?></td>
                        <td><?php echo $a['presente'] ? 'Sí' : 'No'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2" class="text-center">No hay registros de asistencia para este hijo.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>