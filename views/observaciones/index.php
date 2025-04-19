<?php
$pageTitle = 'Gestión de Observaciones';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2>Observaciones</h2>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <div class="mb-3">
        <a href="/observaciones/create" class="btn btn-primary">Nueva Observación</a>
    </div>
    <table class="table table-hover">
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
            <?php if (!empty($observaciones)): ?>
                <?php foreach ($observaciones as $o): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($o['receptor_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($o['tipo']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($o['comentario'])); ?></td>
                        <td><?php echo htmlspecialchars($o['fecha']); ?></td>
                        <td>
                            <form action="/observaciones/destroy" method="post" style="display:inline;">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                                <input type="hidden" name="id" value="<?php echo (int)$o['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta observación?');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">No hay observaciones registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>