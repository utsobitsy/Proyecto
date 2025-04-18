<!-- Vista para que el padre- madre elija su rol -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Rol</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
    <h2>Selecciona el rol</h2>
    <form action="/auth/select_role.php" method="POST">
        <label for="role_id">Rol:</label>
        <select name="role_id" id="role_id">
            <option value="1">Estudiante</option>
            <option value="2">Padre</option>
        </select>
        <button type="submit">Seleccionar</button>
    </form>
</body>
</html>
