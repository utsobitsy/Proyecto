<?php
// ObservacionesController.php
$observacionesController = new ObservacionesController($pdo);
$observaciones = $observacionesController->obtenerPorEstudiante($usuarioId);
?>
<h2>Observaciones del Estudiante</h2>
<table>
    <tr>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Fecha</th>
    </tr>
    <?php foreach ($observaciones as $observacion): ?>
    <tr>
        <td><?php echo $observacion['tipo']; ?></td>
        <td><?php echo $observacion['descripcion']; ?></td>
        <td><?php echo $observacion['fecha']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
