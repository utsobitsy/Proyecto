-- Insertar usuarios de prueba (usuarios de diferentes roles)
INSERT INTO usuarios (email, contraseña, nombre_completo, id_rol) 
VALUES 
('estudiante1@example.com', 'contraseña1', 'Juan Pérez', 1),  -- Estudiante
('padre1@example.com', 'contraseña2', 'Carlos Pérez', 2),     -- Padre
('profesor1@example.com', 'contraseña3', 'María García', 3),  -- Profesor
('coordinador1@example.com', 'contraseña4', 'Luis López', 4), -- Coordinador Académico
('coordinador2@example.com', 'contraseña5', 'Ana Sánchez', 5), -- Coordinador de Convivencia
('admin@example.com', 'contraseña6', 'Rector', 6);  -- Administrador

-- Insertar materias
INSERT INTO materias (nombre, descripcion)
VALUES 
('Matemáticas', 'Estudio de los números, álgebra, geometría y más.'),
('Lengua y Literatura', 'Estudio del lenguaje, la literatura y la gramática.');

-- Insertar notas de prueba
INSERT INTO notas (id_usuario, id_materia, periodo, calificacion, descripcion)
VALUES 
(1, 1, '2025-1', 8.5, 'Muy buena participación'),
(1, 2, '2025-1', 9.0, 'Excelente redacción de ensayos');

-- Insertar registros de asistencia
INSERT INTO asistencia (id_usuario, fecha, estado)
VALUES 
(1, '2025-04-10', 'Presente'),
(3, '2025-04-10', 'Ausente');

-- Insertar observaciones
INSERT INTO observaciones (id_usuario, tipo, descripcion)
VALUES 
(1, 'Académica', 'Necesita mejorar en resolución de problemas matemáticos'),
(1, 'Disciplinaria', 'Comportamiento inapropiado durante clases');

-- Insertar horarios
INSERT INTO horarios (id_usuario, dia_semana, hora_inicio, hora_fin, id_materia)
VALUES 
(1, 'Lunes', '08:00:00', '09:30:00', 1),
(1, 'Miércoles', '10:00:00', '11:30:00', 2);
