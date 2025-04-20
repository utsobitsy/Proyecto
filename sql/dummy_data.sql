-- Insertar roles
INSERT INTO roles (id, nombre, descripcion) VALUES
(1, 'Estudiante', 'Alumno regular'),
(2, 'Padre', 'Representante legal'),
(3, 'Profesor', 'Docente asignado'),
(4, 'Coordinador Académico', 'Gestión académica'),
(5, 'Coordinador de Convivencia', 'Gestión de disciplina'),
(6, 'Administrador', 'Acceso total');

-- Insertar usuarios (con contraseñas hasheadas)
INSERT INTO usuarios (email, password, nombre_completo, id_rol) VALUES
('estudiante1@example.com', '$2y$10$uE/5.FVL9nSmJ8OrOVZZ1OmguJZgJIb9s8AOeSkdNEJEsuxRfDG2G', 'Juan Pérez', 1),
('padre1@example.com',     '$2y$10$Qr1H8CIz6JCTJxkm9g9NOeBk.4PweIMzNC5MrKrbWw8YDO8u8kq5u', 'Carlos Pérez', 2),
('profesor1@example.com',  '$2y$10$pNk5SSkn8wfb25MvGwVnXOxWCBmEWxGglHxlWzyJydHyhf4C7PPc2', 'María García', 3),
('coordinador1@example.com','$2y$10$9AZo.L3FFClv16Ly1RxX9uknOdvthxfNGro5mCkDXYllW7kzv6fp6', 'Luis López', 4),
('coordinador2@example.com','$2y$10$P5HlCWLP5v5fx7fgknULkObAPMpXcpL1L5FMWRrDsZdpnP2M2CZJe', 'Ana Sánchez', 5),
('admin@example.com',      '$2y$10$sZGB4cWQ9RgBQwUIYq7CxOS1eIK0U7v2R3EjEvPQ1WZbPU.Qb30My', 'Rector', 6);

-- Contraseñas originales:
-- contraseña1: estudiante1
-- contraseña2: padre1
-- contraseña3: profesor1
-- contraseña4: coordinador1
-- contraseña5: coordinador2
-- contraseña6: admin

-- Insertar curso y grupo
INSERT INTO cursos (nombre, descripcion) VALUES
('Curso de prueba', 'Curso para pruebas de funcionalidades');

INSERT INTO grupos (id_curso, nombre, anio) VALUES
(1, 'Grupo A', 2025);

-- Insertar materias
INSERT INTO materias (nombre, descripcion) VALUES
('Matemáticas', 'Estudio de los números, álgebra, geometría y más.'),
('Lengua y Literatura', 'Estudio del lenguaje, la literatura y la gramática.');

-- Insertar relación curso-estudiante
INSERT INTO cursos_estudiantes (id_curso, id_estudiante) VALUES
(1, 1); -- estudiante1

-- Insertar notas
INSERT INTO notas (id_estudiante, id_materia, periodo, calificacion, descripcion) VALUES
(1, 1, '2025-1', 8.5, 'Muy buena participación'),
(1, 2, '2025-1', 9.0, 'Excelente redacción de ensayos');

-- Insertar asistencias
INSERT INTO asistencias (id_estudiante, id_grupo, fecha, estado) VALUES
(1, 1, '2025-04-10', 'Presente'),
(1, 1, '2025-04-11', 'Ausente');

-- Insertar observaciones
INSERT INTO observaciones (id_estudiante, tipo, descripcion, fecha, registrado_por) VALUES
(1, 'Académica', 'Necesita mejorar en resolución de problemas matemáticos', '2025-04-15', 3),
(1, 'Disciplinaria', 'Comportamiento inapropiado durante clases', '2025-04-15', 3);

-- Insertar horarios
INSERT INTO horarios (id_grupo, id_materia, dia, hora_inicio, hora_fin, tipo) VALUES
(1, 1, 'Lunes', '08:00:00', '09:30:00', 'normal'),
(1, 2, 'Miércoles', '10:00:00', '11:30:00', 'normal');
