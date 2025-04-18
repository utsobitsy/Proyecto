<?php
$pageTitle = 'Supervisión Académica';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2>Supervisión Académica</h2>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
    <?php endif; ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Materia</th>
                <th>Nota</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grades as $g): ?>
                <tr>
                    <td><?php echo htmlspecialchars($g['estudiante_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($g['materia_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($g['calificacion']); ?></td>
                    <td>
                        <a href="/notas/edit?id=<?php echo (int)$g['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Paginación">
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