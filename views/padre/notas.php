<?php
require_once __DIR__ . '/../../includes/auth_check.php';
$allowRole = [2];
require_once __DIR__ . '/../../includes/rol_check.php';

$pageTitle = 'Notas del Hijo';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2>Notas</h2>
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
    <!-- Tabla de notas -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Materia</th>
                <th>Calificación</th>
                <th>Periodo</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($notas)): ?>
                <?php foreach ($notas as $n): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($n['materia']); ?></td>
                        <td><?php echo htmlspecialchars($n['calificacion']); ?></td>
                        <td><?php echo htmlspecialchars($n['periodo']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($n['descripcion'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">No hay notas registradas para este hijo.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>