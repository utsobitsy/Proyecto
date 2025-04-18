<?php 
// db.php - Configuración de la conexión a la base de datos

// Definir los parametros de conexión
$host = 'localhost';
$dbname = 'nombre';
$username = 'root';
$password = '1234';

// Crear una conexión PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Establecer el modo de error de PDO para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Opción para manejar consultas preparadas
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Si la conexión falla, mostrar el error
    die("Conexión fallida: " . $e->getMessage());
}
?>