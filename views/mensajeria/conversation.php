<?php
$pageTitle = 'Conversación';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2>Chat con <?php echo htmlspecialchars($otherUser['nombre']); ?></h2>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['flash_error']); unset(\$_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <div class="mb-3 p-3 border" style="height: 400px; overflow-y: scroll;">
        <?php foreach ($messages as $msg): ?>
            <div class="mb-2 <?php echo \$msg['id_emisor'] === \$_SESSION['user_id'] ? 'text-end' : 'text-start'; ?>">
                <strong><?php echo \$msg['emisor_nombre']; ?>:</strong>
                <p><?php echo nl2br(htmlspecialchars(\$msg['contenido'])); ?></p>
                <small class="text-muted"><?php echo \$msg['creado_en']; ?></small>
            </div>
        <?php endforeach; ?>
    </div>
    <form action="/mensajes/send" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(\$_SESSION['csrf_token']); ?>">
        <input type="hidden" name="receptor" value="<?php echo (int)\$otherId; ?>">
        <div class="mb-2">
            <input type="text" name="asunto" class="form-control" placeholder="Asunto" required>
        </div>
        <div class="mb-2">
            <textarea name="contenido" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
        <a href="/mensajes" class="btn btn-secondary ms-2">Volver</a>
    </form>
</div>
<?php
template_footer();
?>