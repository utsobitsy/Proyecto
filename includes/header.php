<?php
// includes/header.php (Modificado)

// Este archivo se incluirá al principio de tus vistas (después de los checks de auth y rol)

// Asegurarse de que la sesión esté iniciada (aunque auth_check.php ya lo hace, es buena práctica)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir una variable para el título de la página.
// La vista que incluya este header debería definir $pageTitle ANTES de incluirlo.
$pageTitle = isset($pageTitle) ? $pageTitle : 'Sistema de Notas';

// Obtener el nombre del rol para enlazar estilos CSS dinámicos (necesitas implementar getRoleName)
$roleName = 'guest'; // Rol por defecto si no hay sesión
if (isset($_SESSION['id_rol'])) {
    // Aquí necesitarías una función o método para obtener el nombre del rol a partir del ID.
    // Por ahora, usaremos un placeholder 'rol' y necesitarás reemplazar esto.
    // $roleName = strtolower($this->getRoleName($_SESSION['id_rol'])); // Ejemplo: si getRoleName existe
     $roleName = 'authenticated'; // Ejemplo genérico si no tienes estilos por rol por nombre exacto
     switch ($_SESSION['id_rol']) {
         case 1: $roleName = 'estudiante'; break;
         case 2: $roleName = 'padre'; break;
         case 3: $roleName = 'profesor'; break;
         case 4: $roleName = 'coordinador'; break; // Coordinador Académico
         case 5: $roleName = 'coordinador'; break; // Coordinador de Convivencia (pueden compartir estilos)
         case 6: $roleName = 'admin'; break;
         default: $roleName = 'authenticated'; // Rol desconocido
     }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Sistema de Notas</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css"> <link rel="stylesheet" href="/assets/css/roles/<?php echo $roleName; ?>.css"> {/* Enlace dinámico a estilos por rol */}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body id="page-top"> {/* Añadido id="page-top" comúnmente usado en plantillas */}

    {/* Page Wrapper */}
    <div id="wrapper">

        {/* Sidebar */}
        <?php require_once 'sidebar.php'; ?> {/* Incluir la barra lateral */}
        {/* End of Sidebar */}

        {/* Content Wrapper */}
        <div id="content-wrapper" class="d-flex flex-column">

            {/* Main Content */}
            <div id="content">

                {/* Topbar (Barra de Navegación Superior) */}
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    {/* Sidebar Toggle (Topbar) - Si usas una barra lateral colapsable */}
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    {/* Puedes añadir un formulario de búsqueda si es necesario */}
                    {/* <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar por..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> */}

                    {/* Topbar Navbar (Elementos de navegación a la derecha) */}
                    <ul class="navbar-nav ml-auto">

                        {/* Elementos de navegación comunes (mensajes, notificaciones, perfil de usuario) */}
                         <li class="nav-item dropdown no-arrow d-sm-none"> {/* Botón de búsqueda visible solo en móviles */}
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            {/* Dropdown - Messages */}
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Buscar por..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        {/* Puedes añadir elementos de notificación y mensajes aquí */}
                        {/* <li class="nav-item dropdown no-arrow mx-1"> ... </li> */}
                        {/* <li class="nav-item dropdown no-arrow mx-1"> ... </li> */}


                        {/* Divisor de barra superior */}
                        <div class="topbar-divider d-none d-sm-block"></div>

                        {/* Información del usuario logueado */}
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {/* Mostrar el nombre del usuario logueado */}
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo isset($_SESSION['nombre_completo']) ? htmlspecialchars($_SESSION['nombre_completo']) : 'Usuario'; ?>
                                </span>
                                {/* Puedes mostrar una imagen de perfil pequeña */}
                                {/* <img class="img-profile rounded-circle" src="/assets/img/undraw_profile.svg"> */}
                            </a>
                            {/* Dropdown - User Information (Menú desplegable del usuario) */}
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {/* Opciones de perfil, configuración, etc. */}
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configuración
                                </a>
                                {/* Puedes añadir un enlace a la selección de rol si aplica (para padres) */}
                                <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == 2): ?> {/* Si es rol Padre */}
                                     <a class="dropdown-item" href="/auth/select_role.php"> {/* Ajusta la URL */}
                                        <i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Seleccionar Hijo
                                    </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                {/* Enlace para Logout */}
                                <a class="dropdown-item" href="/auth/logout.php" data-toggle="modal" data-target="#logoutModal"> {/* Ajusta la URL */}
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                {/* End of Topbar */}

                {/* Contenedor fluido para el contenido principal de la página */}
                <div class="container-fluid">

                {/* El contenido específico de la página comienza aquí en la vista que incluye el header */}