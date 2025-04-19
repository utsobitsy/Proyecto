<?php
$pageTitle = 'Gestión de Notas';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2>Listado de Notas</h2>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <div class="mb-3">
        <a href="/notas/create" class="btn btn-primary">Nueva Nota</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Materia</th>
                <th>Calificación</th>
                <th>Periodo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($grades)): ?>
                <?php foreach ($grades as $g): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($g['estudiante_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($g['materia_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($g['calificacion']); ?></td>
                        <td><?php echo htmlspecialchars($g['periodo']); ?></td>
                        <td>
                            <a href="/notas/edit?id=<?php echo (int)$g['id']; ?>" class="btn btn-sm btn-secondary">Editar</a>
                            <form action="/notas/destroy" method="post" style="display:inline;">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(\$_SESSION['csrf_token'] ?? ''); ?>">
                                <input type="hidden" name="id" value="<?php echo (int)\$g['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta nota?');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="text-center">No hay notas registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>