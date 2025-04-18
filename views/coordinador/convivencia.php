<?php
$pageTitle = 'Supervisión Convivencia';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2>Observaciones Disciplinarias</h2>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
    <?php endif; ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Tipo</th>
                <th>Comentario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($observations as $o): ?>
                <tr>
                    <td><?php echo htmlspecialchars($o['receptor_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($o['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($o['comentario']); ?></td>
                    <td><?php echo htmlspecialchars($o['fecha']); ?></td>
                    <td>
                        <form action="/coordinador/convivencia/destroyObservation" method="post" onsubmit="return confirm('¿Eliminar observación?');">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="<?php echo (int)$o['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>