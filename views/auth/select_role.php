<?php
template_header('Seleccionar rol');
?>
<div class="container mt-5">
    <h2 class="mb-4">Seleccionar Rol</h2>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['flash_error']; unset(\$_SESSION['flash_error']); ?></div>
    <?php endif; ?>
    <form action="/auth/select-role" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(\$_SESSION['csrf_token']); ?>">
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select name="role" id="role" class="form-select" required>
                <?php foreach (\$_SESSION['roles'] as \$r): ?>
                    <option value="<?php echo htmlspecialchars(\$r); ?>"><?php echo htmlspecialchars(\$r); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Seleccionar</button>
    </form>
</div>
<?php
template_footer();
?>