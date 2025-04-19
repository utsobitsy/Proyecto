<?php
$pageTitle = 'Crear Observación';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2><?php echo $pageTitle; ?></h2>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <form action="/observaciones/store" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="mb-3">
            <label for="id_receptor" class="form-label">Estudiante</label>
            <select name="id_receptor" id="id_receptor" class="form-select" required>
                <option value="">-- Seleccionar estudiante --</option>
                <?php foreach ($students as $s): ?>
                    <option value="<?php echo (int)$s['id']; ?>"><?php echo htmlspecialchars($s['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Observación</label>
            <input type="text" name="tipo" id="tipo" class="form-control" placeholder="Ej: Disciplinaria, Académica" required>
        </div>
        <div class="mb-3">
            <label for="comentario" class="form-label">Comentario</label>
            <textarea name="comentario" id="comentario" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="/observaciones" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
