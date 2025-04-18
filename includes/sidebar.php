<?php
// includes/sidebar.php (Dinámico)

// Este archivo se incluirá en tus vistas, probablemente dentro del #wrapper en header.php

// Asegurarse de que la sesión esté iniciada y el id_rol esté disponible
// (Esto debería estar garantizado si se incluye después de auth_check.php)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_role_id = isset($_SESSION['id_rol']) ? $_SESSION['id_rol'] : null;

?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {/* Marca del Sidebar - Enlace a la página principal (generalmente el dashboard del rol) */}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i> {/* Ícono de ejemplo */}
        </div>
        <div class="sidebar-brand-text mx-3">Sistema de Notas</div>
    </a>

    {/* Divisor */}
    <hr class="sidebar-divider my-0">

    {/* Elemento de navegación - Dashboard (Común a todos los roles, redirige según el rol) */}
    <li class="nav-item active">
        <a class="nav-link" href="/"> {/* Enlace a la raíz, tu enrutador debe dirigir al dashboard correcto */}
            <i class="fas fa-fw fa-tachometer-alt"></i> {/* Ícono de ejemplo */}
            <span>Dashboard</span>
        </a>
    </li>

    {/* Divisor */}
    <hr class="sidebar-divider">

    {/* Sección de menú específica para cada rol */}

    <?php if ($user_role_id === 6): // Menú para Administrador ?>
        <div class="sidebar-heading">
            Administración
        </div>

        <li class="nav-item">
            <a class="nav-link" href="/admin/usuarios.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-users"></i> {/* Ícono de ejemplo */}
                <span>Gestión de Usuarios</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/reportes.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-chart-area"></i> {/* Ícono de ejemplo */}
                <span>Reportes Globales</span>
            </a>
        </li>

        {/* Puedes añadir más opciones específicas para Admin aquí */}

    <?php elseif ($user_role_id === 4 || $user_role_id === 5): // Menú para Coordinadores (Académico o Convivencia) ?>
         <div class="sidebar-heading">
            Coordinación
        </div>

        <?php if ($user_role_id === 4): // Opciones específicas para Coordinador Académico ?>
             <li class="nav-item">
                <a class="nav-link" href="/coordinador/academicos.php"> {/* Ajusta la URL */}
                    <i class="fas fa-fw fa-book"></i> {/* Ícono de ejemplo */}
                    <span>Gestión Académica</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($user_role_id === 5): // Opciones específicas para Coordinador de Convivencia ?>
             <li class="nav-item">
                <a class="nav-link" href="/coordinador/convivencia.php"> {/* Ajusta la URL */}
                    <i class="fas fa-fw fa-handshake"></i> {/* Ícono de ejemplo */}
                    <span>Gestión de Convivencia</span>
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item">
            <a class="nav-link" href="/coordinador/asistencia.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-clipboard-check"></i> {/* Ícono de ejemplo */}
                <span>Asistencia (Coordinador)</span>
            </a>
        </li>

        {/* Puedes añadir más opciones específicas para Coordinadores aquí */}

    <?php elseif ($user_role_id === 3): // Menú para Profesor ?>
        <div class="sidebar-heading">
            Profesor
        </div>

        <li class="nav-item">
            <a class="nav-link" href="/profesor/cursos.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-chalkboard"></i> {/* Ícono de ejemplo */}
                <span>Mis Cursos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/profesor/notas.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-edit"></i> {/* Ícono de ejemplo */}
                <span>Ingresar/Editar Notas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/profesor/asistencia.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-check-circle"></i> {/* Ícono de ejemplo */}
                <span>Registrar Asistencia</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/profesor/mensajeria.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-envelope"></i> {/* Ícono de ejemplo */}
                <span>Mensajería</span>
            </a>
        </li>

        {/* Puedes añadir más opciones específicas para Profesor aquí */}

     <?php elseif ($user_role_id === 1): // Menú para Estudiante ?>
        <div class="sidebar-heading">
            Estudiante
        </div>

        <li class="nav-item">
            <a class="nav-link" href="/estudiante/notas.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-book-open"></i> {/* Ícono de ejemplo */}
                <span>Mis Notas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/estudiante/observaciones.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-eye"></i> {/* Ícono de ejemplo */}
                <span>Mis Observaciones</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/estudiante/horario.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-calendar-alt"></i> {/* Ícono de ejemplo */}
                <span>Mi Horario</span>
            </a>
        </li>

         {/* Puedes añadir más opciones específicas para Estudiante aquí */}

    <?php elseif ($user_role_id === 2): // Menú para Padre ?>
         <div class="sidebar-heading">
            Padre
        </div>

        {/* Las opciones para el Padre podrían ser similares a las del estudiante,
            pero quizás con un selector de hijo */}

         <li class="nav-item">
            <a class="nav-link" href="/padre/dashboard.php"> {/* Ajusta la URL */}
                 <i class="fas fa-fw fa-child"></i> {/* Ícono de ejemplo */}
                <span>Seguimiento de Hijo</span> {/* Este podría ser el enlace principal para ver info de un hijo */}
            </a>
        </li>

         <li class="nav-item">
            <a class="nav-link" href="/padre/mensajeria.php"> {/* Ajusta la URL */}
                <i class="fas fa-fw fa-envelope"></i> {/* Ícono de ejemplo */}
                <span>Mensajes del Colegio</span>
            </a>
        </li>

        <?php
        // Si tienes una selección de hijo implementada, podrías mostrar un menú
        // con opciones para ver notas, asistencia, etc., del hijo seleccionado.
        ?>

        {/* Puedes añadir más opciones específicas para Padre aquí */}

    <?php else: // Rol desconocido o no logueado (aunque auth_check debería manejar no logueados) ?>
        {/* Puedes mostrar un menú mínimo o ningún menú aquí */}
         <div class="sidebar-heading">
            Menú
        </div>
         <li class="nav-item">
            <a class="nav-link" href="/"> {/* Enlace a la raíz o login */}
                <i class="fas fa-fw fa-home"></i>
                <span>Inicio</span>
            </a>
        </li>
    <?php endif; ?>

    {/* Divisor (común) */}
    <hr class="sidebar-divider d-none d-md-block">

    {/* Botón para ocultar Sidebar (si usas funcionalidad de colapsar) */}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>