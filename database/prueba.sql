INSERT INTO r_ediciones (nombre, fecha_inicio, fecha_final, activa) VALUES
('Edicion 1', '2022-01-01', '2022-12-31', 1),
('Edicion 2', '2023-01-01', '2023-12-31', 0);

INSERT INTO r_usuarios (correo, contrasenia) VALUES
('user1@example.com', 'password1'),
('user2@example.com', 'password2'),
('user3@example.com', 'password3'),
('user4@example.com', 'password4'),
('user5@example.com', 'password5'),
('user6@example.com', 'password6'),
('user7@example.com', 'password7'),
('user8@example.com', 'password8'),
('user9@example.com', 'password9'),
('user10@example.com', 'password10');

INSERT INTO r_docentes (nombre, apellidoP, apellidoM, id_usuario)
VALUES
   ('Juan', 'Pérez', 'González', 1),
   ('María', 'García', 'López', 2);

INSERT INTO r_jueces (nombre, apellidoP, apellidoM, id_edicion, id_usuario)
VALUES
('Maria', 'Garcia', 'Perez', 2, 6),
('Pedro', 'Lopez', 'Hernandez', 2, 7);

INSERT INTO r_estudiantes (matricula, nombre, apellidoP, apellidoM, id_usuario)
VALUES ('1234567890', 'John', 'Doe', 'Smith', 3),
       ('0987654321', 'Jane', 'Doe', 'Johnson', 4);

INSERT INTO r_ufs (id_uf, nombre) 
VALUES 
    ('UF001', 'Ciencias Naturales'),
    ('UF002', 'Ciencias Sociales');

INSERT INTO r_categorias (nombre) VALUES
   ('Computacion'),
   ('Bio'),
   ('Ciencias Naturales');

INSERT INTO r_niveles_desarrollo (nombre) VALUES
   ('Idea'),
   ('Inicial'),
   ('Desarrollo completo');

INSERT INTO r_rubrica (nombre1, nombre2, nombre3, nombre4, descripcion1, descripcion2, descripcion3, descripcion4)
VALUES ('Rubric Item 1', 'Rubric Item 2', 'Rubric Item 3', 'Rubric Item 4', 'Description for Rubric Item 1', 'Description for Rubric Item 2', 'Description for Rubric Item 3', 'Description for Rubric Item 4');


INSERT INTO r_proyectos (poster, description, estatus, nombre, video, fecha_registro, id_uf, id_docente, id_edicion, id_categoria, id_nivel, premio)
VALUES ('https://example.com/poster.png', 'This is a project about machine learning', true, 'Machine Learning Project', 'https://example.com/video.mp4', NOW(), 'UF001', 2, 1, 2,1,0),
       ('https://example.com/another-poster.png', 'This is another project about machine learning', true, 'Another Machine Learning Project', 'https://example.com/another-video.mp4', NOW(), 'UF002', 1, 2, 3,1,0),
       ('https://example.com/project1.png', 'This is a third project about machine learning', true, 'Third Learning Project', 'https://example.com/project1.mp4', NOW(), 'UF001', 2, 1, 3,2,0),
       ('https://example.com/project2.png', 'This is a fourth project about machine learning', true, 'Fourth Learning Project', 'https://example.com/project1.mp4', NOW(), 'UF002', 2, 1, 3,3,0),
       ('https://example.com/project2.png', 'This is a fifth project about machine learning', false, 'Fifth Learning Project', 'https://example.com/project1.mp4', NOW(), 'UF002', 2, 1, 3,3,0);

INSERT INTO r_calificaciones (puntos_rubro1, puntos_rubro2, puntos_rubro3, puntos_rubro4, comentarios, fecha, id_proyecto, id_juez) 
VALUES (8, 9, 7, 8, 'Buen trabajo, pero hay que mejorar en algunas áreas', '2022-05-01 10:30:00', 1, 1),
       (6, 7, 9, 8, 'Excelente trabajo, pero la presentación podría mejorar', '2022-05-02 11:45:00', 2, 2),
       (null, null, null, null, '', '2022-05-02 11:45:00', 3, 2);
