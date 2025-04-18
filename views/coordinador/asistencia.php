<?php
// AsistenciaController.php
$asistenciaController = new AsistenciaController($pdo);
$asistencia = $asistenciaController->obtenerAsistenciaPorCurso($cursoId);
?>
<h2>Asistencia del Curso</h2>
<table>
    <tr>
        <th>Estudiante</th>
        <th>Fecha</th>
        <th>Estado</th>
    </tr>
    <?php foreach ($asistencia as $registro): ?>
    <tr>
        <td><?php echo $registro['estudiante_nombre']; ?></td>
        <td><?php echo $registro['fecha']; ?></td>
        <td><?php echo $registro['estado']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
