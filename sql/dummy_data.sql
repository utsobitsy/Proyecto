-- Insertar usuarios de prueba (usuarios de diferentes roles)
INSERT INTO usuarios (email, password, nombre_completo, id_rol)
VALUES
('estudiante1@example.com', 'contraseña1', 'Juan Pérez', 1),  -- Estudiante
('padre1@example.com', 'contraseña2', 'Carlos Pérez', 2),    -- Padre
('profesor1@example.com', 'contraseña3', 'María García', 3),  -- Profesor
('coordinador1@example.com', 'contraseña4', 'Luis López', 4), -- Coordinador Académico
('coordinador2@example.com', 'contraseña5', 'Ana Sánchez', 5), -- Coordinador de Convivencia
('admin@example.com', 'contraseña6', 'Rector', 6);    -- Administrador

-- Insertar materias
INSERT INTO materias (nombre, descripcion)
VALUES
('Matemáticas', 'Estudio de los números, álgebra, geometría y más.'),
('Lengua y Literatura', 'Estudio del lenguaje, la literatura y la gramática.');

-- Insertar notas de prueba
-- Corregido: 'id_usuario' a 'id_estudiante' y 'periodo' se agregó
INSERT INTO notas (id_estudiante, id_materia, periodo, calificacion, descripcion)
VALUES
(1, 1, '2025-1', 8.5, 'Muy buena participación'),
(1, 2, '2025-1', 9.0, 'Excelente redacción de ensayos');

-- Insertar registros de asistencia
-- Corregido: 'id_usuario' a 'id_estudiante' y se agregó 'id_grupo'
INSERT INTO asistencias (id_estudiante, id_grupo, fecha, estado)
VALUES
(1, 1, '2025-04-10', 'Presente'), -- Asumiendo id_estudiante 1 está en grupo 1
(1, 1, '2025-04-10', 'Ausente'); -- Asumiendo id_estudiante 3 (profesor) no debería tener asistencia aquí,
                                  -- se cambió a id_estudiante 1 para ejemplo y se agregó id_grupo.
                                  -- Ajusta los IDs de estudiante y grupo según tus datos de prueba.

-- Insertar observaciones
-- Corregido: 'id_usuario' a 'id_estudiante' y se agregó 'fecha' y 'registrado_por'
INSERT INTO observaciones (id_estudiante, tipo, descripcion, fecha, registrado_por)
VALUES
(1, 'Académica', 'Necesita mejorar en resolución de problemas matemáticos', '2025-04-15', 3), -- Asumiendo registrado_por es el profesor (id 3)
(1, 'Disciplinaria', 'Comportamiento inapropiado durante clases', '2025-04-15', 3); -- Asumiendo registrado_por es el profesor (id 3)
                                                                                   -- Ajusta los IDs según tus datos de prueba.

-- Insertar horarios
-- Corregido: 'id_usuario' a 'id_grupo', 'dia_semana' a 'dia', y se agregó 'tipo'
INSERT INTO horarios (id_grupo, id_materia, dia, hora_inicio, hora_fin, tipo)
VALUES
(1, 1, 'Lunes', '08:00:00', '09:30:00', 'normal'), -- Asumiendo horario para grupo 1
(1, 2, 'Miércoles', '10:00:00', '11:30:00', 'normal'); -- Asumiendo horario para grupo 1
                                                      -- Ajusta los IDs según tus datos de prueba.

-- Falta insertar datos de prueba para 'cursos',