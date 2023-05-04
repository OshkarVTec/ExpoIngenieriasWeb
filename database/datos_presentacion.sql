INSERT INTO r_usuarios (correo, contrasenia) VALUES
('user1@example.com', '1234'),
('diegovilla@tec.mx', '1234'),
('leovilla@tec.mx', '1234'),
('juez1@gmail.com', '1234'),
('juez2@gmail.com', '1234'),
('a01275287@tec.mx', '1234'),
('user7@example.com', '1234'),
('user8@example.com', '1243'),
('user9@example.com', '1234'),
('user10@example.com', '1234');

INSERT INTO r_ufs (id_uf, nombre) 
VALUES 
    ('UF001', 'Física II'),
    ('UF002', 'Construcción de software');

INSERT INTO r_categorias (nombre) VALUES
   ('Computacion'),
   ('Bio'),
   ('Ciencias Naturales');

INSERT INTO r_niveles_desarrollo (nombre) VALUES
   ('Idea'),
   ('Inicial'),
   ('Desarrollo completo');

INSERT INTO r_rubrica (nombre1, nombre2, nombre3, nombre4, descripcion1, descripcion2, descripcion3, descripcion4)
VALUES ('Presentación', 'Impacto', 'Validez', 'Proyección', 'El proyecto se presenta de manera correcta, con un diseño atractivo y lenguaje entendible para espectadores', 'El proyecto tiene un impacto significativo en su entorno', 'La experimentación planteada o llevada a cabo tiene una base científica sólida', 'El alcanze del proyecto es realista y toma en cuenta los recursos necesarios para su implementación');

INSERT INTO r_carreras VALUES (NULL, 'ITC'),
(NULL, 'IIS'),
(NULL, 'IMT'),
(NULL, 'IMC');

INSERT INTO r_administradores VALUES (NULL, 'Rafael', 'Aguilar', 'Mejía', 1);

INSERT INTO r_docentes (nombre, apellidoP, apellidoM, id_usuario)
VALUES
   ('Diego', 'Villa', 'González', 2),
   ('Leo', 'Villa', 'López', 3);

INSERT INTO r_estudiantes VALUES ('a01275287', 'Oskar', 'Villa', 'Lopez', 6, 1),
('a01271234', 'Erwin', 'Porras', 'Guerra', 7,1),
('a01731234', 'David', 'Martínez', 'González', 8,1),
('a01731235', 'Raymundo', 'Diaz', 'Alejandre', 9,1);


INSERT INTO r_ediciones (nombre, fecha_inicio, fecha_final, activa) VALUES
('Febrero Junio 2023', '2022-01-01', '2022-12-31', 1);

INSERT INTO r_jueces (nombre, apellidoP, apellidoM, id_usuario, id_edicion)
VALUES
   ('Juez', 'Gonzalez', 'González', 4, 1),
   ('Juez', 'Lopez', 'López', 5, 1);

   INSERT INTO r_proyectos (poster, description, estatus, nombre, video, fecha_registro, id_uf, id_docente, id_edicion, id_categoria, id_nivel, premio)
VALUES ('https://drive.google.com/file/d/1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q/view?usp=share_link', 'This is a project about machine learning', true, 'Machine Learning Project', 'https://www.youtube.com/watch?v=v9WBUqUvGvs', NOW(), 'UF001', 2, 1, 1,1,0),
       ('https://drive.google.com/file/d/1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q/view?usp=share_link', 'This is another project about machine learning', true, 'Another Machine Learning Project', 'https://www.youtube.com/watch?v=v9WBUqUvGvs', NOW(), 'UF002', 1, 1, 1,1,0),
       ('https://drive.google.com/file/d/1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q/view?usp=share_link', 'This is a third project about machine learning', true, 'Creación de nanomateriales', 'https://www.youtube.com/watch?v=v9WBUqUvGvs', NOW(), 'UF001', 2, 1, 1,2,0),
       ('https://drive.google.com/file/d/1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q/view?usp=share_link', 'This is a fourth project about machine learning', true, 'Mezcal sin azúcar', 'https://www.youtube.com/watch?v=v9WBUqUvGvs', NOW(), 'UF002', 2, 1, 1,2,0),
       ('https://drive.google.com/file/d/1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q/view?usp=share_link', 'This is a fifth project about machine learning', false, 'Prueba de caída libre', 'https://www.youtube.com/watch?v=v9WBUqUvGvs', NOW(), 'UF002', 2, 1, 1,2,0);