<?php
// views/profesor/dashboard.php
require_once __DIR__ . '/../../includes/auth_check.php';
// Solo rol Profesor
$allowRole = ['Profesor'];
require_once __DIR__ . '/../../includes/rol_check.php';

$pageTitle = 'Panel del Profesor';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar.php';
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name'] ?? $_SESSION['user'] ?? 'Profesor'); ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <a href="/notas" class="card shadow h-100 py-2 text-decoration-none">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                    <h5 class="card-title">Gestionar Notas</h5>
                </div>
            </a>
        </div>
        <div class="col-lg-4 mb-4">
            <a href="/asistencia" class="card shadow h-100 py-2 text-decoration-none">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                    <h5 class="card-title">Registrar Asistencia</h5>
                </div>
            </a>
        </div>
        <div class="col-lg-4 mb-4">
            <a href="/observaciones" class="card shadow h-100 py-2 text-decoration-none">
                <div class="card-body text-center">
                    <i class="fas fa-comments fa-2x mb-2"></i>
                    <h5 class="card-title">Agregar Observaciones</h5>
                </div>
            </a>
        </div>
    </div>

</div>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
