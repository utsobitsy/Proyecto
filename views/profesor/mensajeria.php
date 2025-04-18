<?php
// MensajeriaController.php
$mensajesController = new MensajeriaController($pdo);
$mensajesRecibidos = $mensajesController->obtenerMensajesRecibidos($usuarioId);
?>
<h2>Mensajes Recibidos</h2>
<table>
    <tr>
        <th>Asunto</th>
        <th>Emisor</th>
        <th>Fecha</th>
        <th>Acción</th>
    </tr>
    <?php foreach ($mensajesRecibidos as $mensaje): ?>
    <tr>
        <td><?php echo $mensaje['asunto']; ?></td>
        <td><?php echo $mensaje['emisor_id']; ?></td>
        <td><?php echo $mensaje['fecha_envio']; ?></td>
        <td><a href="ver_mensaje.php?id=<?php echo $mensaje['id']; ?>">Ver</a></td>
    </tr>
    <?php endforeach; ?>
</table>
