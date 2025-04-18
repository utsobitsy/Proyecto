<?php
// Incluir aquí la cabecera, barra lateral, etc. si se quiere que la página
// de acceso denegado tenga el mismo diseño que el resto de la aplicación.
// require_once '../includes/header.php';
// require_once '../includes/sidebar.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css"> <style>
        .container {
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: #dc3545; /* Color rojo para indicar error */
        }
        p {
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Color azul para un botón */
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
         .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Acceso Denegado</h1>
        <p>No tienes permisos para acceder a esta página.</p>
        <p>Por favor, contacta al administrador si crees que esto es un error.</p>

        <?php if (isset($_SESSION['id_rol'])): ?>
            <a href="/" class="btn">Ir al Dashboard</a>
             <?php else: ?>
            <a href="/auth/login.php" class="btn">Ir a la página de Login</a>
        <?php endif; ?>

    </div>

    <?php
    // Incluir aquí el pie de página si se usa
    // require_once '../includes/footer.php';
    ?>

</body>
</html>