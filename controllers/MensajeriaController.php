<?php

namespace Controllers;

require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../config/db.php';

class MensajeriaController {
    private $mensajeModel;

    public function __construct($pdo) {
        $this->mensajeModel = new Mensaje($pdo);
    }

    public function enviarMensaje($emisorId, $receptorId, $asunto, $contenido) {
        return $this->mensajeModel->enviar($emisorId, $receptorId, $asunto, $contenido);
    }

    public function obtenerMensajesRecibidos($usuarioId) {
        return $this->mensajeModel->listarRecibidos($usuarioId);
    }

    public function obtenerMensajesEnviados($usuarioId) {
        return $this->mensajeModel->listarEnviados($usuarioId);
    }

    public function marcarComoLeido($mensajeId) {
        return $this->mensajeModel->marcarLeido($mensajeId);
    }
}
?>

<?php
// Refactorizacion completa para mensajeria interna entre usuarios

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../models/Usuario.php';

class MensajeriaController {
    private $mensajeModel;
    private $userModel;

    public function __construct(){
        
        // Sólo usuarios autenticados pueden enviar/mirar mensajes
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/denied_access');
            exit;
        }
        $this->mensajeModel = new Mensaje();
        $this->userModel = new Usuario();

        // Mostrar lista de conversaciones activas del usuario
        public function index() {
            $userId = $_SESSION['user_id'];
            // Obtener lista de IDs de usuarios con los que ha conversado
            $convs = $this->mensajeModel->getUserConversations($userId);
            // Para cada conversación, obtener nombre del otro usuario
            $threads = [];
            foreach ($convs as $otherId) {
                $user = $this->userModel->findById($otherId);
                if ($user) {
                    $threads[] = ['id' => $otherId, 'nombre' => $user['nombre']];
                }
            }
            include __DIR__ . '/../views/mensajeria/index.php';
        }

        // Mostrar mensajes de una conversación con otro usuario
        public function conversation() {
            $userId  = $_SESSION['user_id'];
            $otherId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$otherId || $otherId === $userId) {
                header('Location: /mensajes'); exit;
            }
            // Obtener mensajes bidireccionales
            $messages = $this->mensajeModel->getConversation($userId, $otherId);
            $otherUser = $this->userModel->findById($otherId);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            include __DIR__ . '/../views/mensajeria/conversation.php';
        }

        // Enviar un mensaje a otro usuario
        public function send() {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST'
                || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
                die('Acceso inválido');
            }
            $emisor   = $_SESSION['user_id'];
            $receptor = filter_input(INPUT_POST, 'receptor', FILTER_VALIDATE_INT);
            $asunto   = trim($_POST['asunto'] ?? '');
            $contenido= trim($_POST['contenido'] ?? '');
    
            if (!$receptor || !$asunto || !$contenido) {
                $_SESSION['flash_error'] = 'Todos los campos son obligatorios.';
                header("Location: /mensajes/conversacion?id={$receptor}"); exit;
            }
    
            try {
                $this->mensajeModel->send([
                    'id_emisor'   => $emisor,
                    'id_receptor' => $receptor,
                    'asunto'      => $asunto,
                    'contenido'   => $contenido
                ]);
                $_SESSION['flash_success'] = 'Mensaje enviado.';
            } catch (Exception $e) {
                $_SESSION['flash_error'] = 'Error al enviar mensaje.';
            }
    
            header("Location: /mensajes/conversacion?id={$receptor}");
            exit;
        }
    }
}
?>