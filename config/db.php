<?php
// Clase singleton para la conexión a la base de datos mediante PDO

class Database {
    
    // Intancia unica de la clase Database
    private static $instance = null;

    // Objeto PDO

    private $pdo;

    // Contructor privado para evitar instanción directa 
    private function __construct(){
        // Leer variables de entorno o usar valores por defecto
        $host = getenv('DB_HOST') ?: 'localhost';
        $db = getenv('DB_NAME') ?: 'nombre'; // Insertar nombre de BD de Workbench
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '1234'; // Contraseña BD en workbench
        $charset = 'utf8mt4';

        $dns = "mysql:host={$host};dbname={$db};charset={$charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e){
            // Manejo de error: mostrar o registrar en log
            throw new \Exception('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    // Retornar la instancia Singleton de Database
    Public static function getIntance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    // Retornar la conexión PDO
    public function getConnection(): PDO {
        return $this->pdo;
    }
}
    // Uso en otros archivos:
    // require_once __DIR__ . '/../config/db.php';
    // $pdo = Database::getInstance()->getConnection();
?>