<?php
// Usuario.php
require_once __DIR__ . '/../config/db.php';

class Usuario {
    private $conn;

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }

        return false;
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerHijos($id_padre) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_padre = :id_padre");
        $stmt->bindParam(':id_padre', $id_padre, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($email, $nombre_completo, $password, $id_rol) {
        $stmt = $this->conn->prepare("
            INSERT INTO usuarios (email, nombre_completo, password, id_rol)
            VALUES (:email, :nombre_completo, :password, :id_rol)
        ");
        return $stmt->execute([
            ':email' => $email,
            ':nombre_completo' => $nombre_completo,
            ':password' => $password,
            ':id_rol' => $id_rol
        ]);
    }

    public function actualizarUsuario($id, $nombre_completo, $email, $id_rol) {
        $stmt = $this->conn->prepare("
            UPDATE usuarios
            SET nombre_completo = :nombre_completo, email = :email, id_rol = :id_rol
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':nombre_completo' => $nombre_completo,
            ':email' => $email,
            ':id_rol' => $id_rol
        ]);
    }

    public function eliminarUsuario($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Obtiene todos los usuarios con un rol específico.
     * @param int $id_rol El ID del rol.
     * @return array Un array de usuarios.
     */
    public function obtenerPorRol($id_rol) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_rol = :id_rol");
        $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los estudiantes (usuarios con rol 1) de un grupo específico.
     * Asume una tabla de unión 'grupos_usuarios' o similar, o que el id_grupo está directamente en la tabla 'usuarios'.
     * Basado en tu schema.sql, no hay una relación directa estudiante-grupo en la tabla usuarios.
     * Si la relación es a través de 'cursos_estudiantes' y 'grupos' (id_curso en grupos), la consulta sería más compleja.
     * Este método asume que tienes una manera de relacionar un estudiante con un grupo.
     * Si los estudiantes están en la tabla 'usuarios' y los grupos están relacionados con cursos,
     * podrías necesitar obtener los estudiantes a través de la tabla 'cursos_estudiantes' y 'grupos'.
     *
     * **Nota: La siguiente implementación es un EJEMPLO basado en una posible relación
     * y puede necesitar ajustarse según tu esquema EXACTO de cómo los estudiantes se asocian a grupos.**
     * Si los estudiantes tienen un 'id_grupo' directamente en la tabla 'usuarios', esta consulta sería mucho más simple.
     *
     * @param int $id_grupo El ID del grupo.
     * @return array Un array de usuarios (estudiantes) en el grupo.
     */
    public function obtenerEstudiantesPorGrupo($id_grupo) {
        // EJEMPLO DE CONSULTA (puede necesitar ajuste)
        // Asumiendo que hay una tabla de unión 'grupos_estudiantes' o que 'usuarios' tiene 'id_grupo'
        // Ya que tu schema.sql no tiene 'id_grupo' en 'usuarios' ni una tabla 'grupos_estudiantes',
        // esta consulta es especulativa. Una forma podría ser si la relación va de usuario -> cursos_estudiantes -> cursos -> grupos.
        // Esto requeriría JOINs.
         $stmt = $this->conn->prepare("
             SELECT u.* FROM usuarios u
             JOIN cursos_estudiantes ce ON u.id = ce.id_estudiante
             JOIN grupos g ON ce.id_curso = g.id_curso -- ASUMIMOS que grupos tiene id_curso y se relaciona así
             WHERE g.id = :id_grupo AND u.id_rol = 1 -- Asumiendo 1 es el ID del rol Estudiante
         ");
        // O si la relación es directa (poco probable según schema.sql)
        /*
         $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id_grupo = :id_grupo AND id_rol = 1");
        */
        $stmt->bindParam(':id_grupo', $id_grupo, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene los profesores (usuarios con rol 3) que imparten una materia específica.
     * Asume una tabla de unión 'profesores_materias' o similar, o que el id_materia está directamente en la tabla 'usuarios'.
     * Basado en tu schema.sql, no hay una relación directa profesor-materia.
     * Necesitas definir cómo se asocian los profesores a las materias. Podría ser a través de una tabla de asignación
     * que relacione profesores (usuarios) con materias y quizás grupos.
     *
     * **Nota: La siguiente implementación es un EJEMPLO basado en una posible relación
     * y puede necesitar ajustarse según tu esquema EXACTO de cómo los profesores se asocian a materias.**
     *
     * @param int $id_materia El ID de la materia.
     * @return array Un array de usuarios (profesores) que imparten la materia.
     */
    public function obtenerProfesoresPorMateria($id_materia) {
         // EJEMPLO DE CONSULTA (puede necesitar ajuste)
        // Asumiendo una tabla de unión 'profesores_materias' (que no está en tu schema.sql)
        /*
         $stmt = $this->conn->prepare("
             SELECT u.* FROM usuarios u
             JOIN profesores_materias pm ON u.id = pm.id_profesor
             WHERE pm.id_materia = :id_materia AND u.id_rol = 3 -- Asumiendo 3 es el ID del rol Profesor
         ");
        */
         // O si la relación es más compleja, como profesor -> asignaciones -> grupos -> materias
         // Necesitas definir la tabla que relaciona profesores con lo que enseñan.

        // Sin una tabla clara que relacione profesores con materias en tu schema.sql,
        // esta implementación es un placeholder.
        // Deberás crear la tabla de relación y ajustar la consulta aquí.
         $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = -1"); // Consulta que devuelve vacío por defecto
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Puedes agregar más métodos según tus necesidades
}
?>