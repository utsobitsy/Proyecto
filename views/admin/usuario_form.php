<?php
// Formulario para crear usuario
$pageTitle = 'Crear Usuario';
include __DIR__ . '/../../includes/header.php';
?>
<div class="container mt-4">
    <h2>Crear Usuario</h2>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <form action="/admin/usuarios/store" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="correo">Email:</label>
            <input type="email" name="correo" id="correo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="rol">Rol:</label>
            <select name="rol" id="rol" class="form-control" required>
                <?php foreach (['Estudiante','Padre','Profesor','Coordinador','Administrador'] as $r): ?>
                    <option value="<?php echo $r; ?>"><?php echo $r; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
        <a href="/admin/usuarios" class="btn btn-secondary mt-2">Cancelar</a>
    </form>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>