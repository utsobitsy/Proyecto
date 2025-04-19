<?php
// Detectar si es edición o creación
$isEdit = isset(\$note);
$pageTitle = \$isEdit ? 'Editar Nota' : 'Nueva Nota';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>
<div class="container mt-4">
    <h2><?php echo \$pageTitle; ?></h2>
    <?php if (!empty(\$_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars(\$_SESSION['flash_error']); unset(\$_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <form action="<?php echo \$isEdit ? '/notas/update' : '/notas/store'; ?>" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(\$_SESSION['csrf_token']); ?>">
        <?php if (\$isEdit): ?>
            <input type="hidden" name="id" value="<?php echo (int)\$note['id']; ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label for="id_estudiante" class="form-label">Estudiante</label>
            <select name="id_estudiante" id="id_estudiante" class="form-select" required <?php echo \$isEdit ? 'disabled' : ''; ?>>
                <option value="">-- Seleccionar estudiante --</option>
                <?php foreach (\$students as \$s): ?>
                    <option value="<?php echo (int)\$s['id']; ?>" <?php echo \$isEdit && \$s['id']==\$note['id_estudiante'] ? 'selected' : ''; ?>><?php echo htmlspecialchars(\$s['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_materia" class="form-label">Materia</label>
            <select name="id_materia" id="id_materia" class="form-select" required <?php echo \$isEdit ? 'disabled' : ''; ?>>
                <option value="">-- Seleccionar materia --</option>
                <?php foreach (\$subjects as \$m): ?>
                    <option value="<?php echo (int)\$m['id']; ?>" <?php echo \$isEdit && \$m['id']==\$note['id_materia'] ? 'selected' : ''; ?>><?php echo htmlspecialchars(\$m['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="calificacion" class="form-label">Calificación</label>
            <input type="number" name="calificacion" id="calificacion" class="form-control" step="0.01" min="0" max="100" value="<?php echo \$isEdit ? htmlspecialchars(\$note['calificacion']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="periodo" class="form-label">Periodo</label>
            <input type="text" name="periodo" id="periodo" class="form-control" value="<?php echo \$isEdit ? htmlspecialchars(\$note['periodo']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"><?php echo \$isEdit ? htmlspecialchars(\$note['descripcion']) : ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo \$isEdit ? 'Actualizar' : 'Crear'; ?></button>
        <a href="/notas" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>