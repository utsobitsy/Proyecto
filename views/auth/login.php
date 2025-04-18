<!-- Vista para ingresar las credenciales -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
    <form action="/auth/login.php" method="POST">
        <h2>Iniciar sesión</h2>
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
