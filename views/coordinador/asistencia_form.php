<?php
// Formulario para registrar asistencia
$pageTitle = 'Registrar Asistencia';
include __DIR__ . '/../../includes/header.php';
?>
<div class="container mt-4">
    <h2>Registrar Asistencia</h2>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <form action="/asistencia/store" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="form-group">
            <label for="id_estudiante">Estudiante:</label>
            <select name="id_estudiante" id="id_estudiante" class="form-control" required>
                <option value="">Selecciona un estudiante</option>
                <?php foreach ($students as $s): ?>
                    <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>
        <div class="form-check mt-2">
            <input type="checkbox" name="presente" id="presente" value="1" class="form-check-input" checked>
            <label for="presente" class="form-check-label">Presente</label>
        </div>
        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="/asistencia" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>