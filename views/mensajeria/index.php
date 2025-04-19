<?php
$pageTitle = 'Mensajería';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2>Conversaciones</h2>
    <?php if (empty($threads)): ?>
        <p>No tienes conversaciones iniciadas.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($threads as $t): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($t['nombre']); ?>
                    <a href="/mensajes/conversacion?id=<?php echo (int)$t['id']; ?>" class="btn btn-sm btn-primary">Abrir</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
