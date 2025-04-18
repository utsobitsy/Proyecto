<?php
// EstudianteController.php
require_once '../../controllers/NotasController.php';
$notasController = new NotasController($pdo); // Asegúrate de tener $pdo disponible
$notas = $notasController->obtenerNotasPorEstudiante($usuarioId, $periodoActual);
?>
<h2>Notas del Estudiante</h2>
<table>
    <tr>
        <th>Materia</th>
        <th>Nota</th>
        <th>Descripción</th>
    </tr>
    <?php foreach ($notas as $nota): ?>
    <tr>
        <td><?php echo $nota['materia']; ?></td>
        <td><?php echo $nota['nota']; ?></td>
        <td><?php echo $nota['descripcion']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
