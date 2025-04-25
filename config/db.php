<?php
namespace Config;

use PDO;
use PDOException;

class Database {
    public static function getConnection() {
        try {
            // Reemplaza con tus datos reales de conexión
            $host = 'localhost';
            $dbname = 'sistema'; // Insertar nombre de db en Workbench
            $username = 'root';
            $password = '';

            $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
