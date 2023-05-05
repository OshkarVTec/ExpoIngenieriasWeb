CREATE TABLE r_ediciones(
	id_edicion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30),
	fecha_inicio DATE,
	fecha_final DATE, 
   activa TINYINT(1)
);

CREATE TABLE r_carreras(
	id_carrera INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30)
);


CREATE TABLE r_usuarios(
   id_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   correo VARCHAR(30),
   contrasenia VARCHAR(100)
);

CREATE TABLE r_estudiantes(
	matricula VARCHAR(10) NOT NULL PRIMARY KEY,
	nombre VARCHAR(30),
	apellidoP VARCHAR(30),
   apellidoM VARCHAR(30),
   id_usuario INT,
   id_carrera INT,
   FOREIGN KEY (id_usuario)
	REFERENCES r_usuarios(id_usuario)
	ON DELETE CASCADE
   ON UPDATE CASCADE,
   FOREIGN KEY (id_carrera)
	REFERENCES r_carreras(id_carrera)
	ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TABLE r_docentes(
	id_docente INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30),
	apellidoP VARCHAR(30),
   apellidoM VARCHAR(30),
   id_usuario INT,
   FOREIGN KEY (id_usuario)
	REFERENCES r_usuarios(id_usuario)
	ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TABLE r_jueces(
	id_juez INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30),
	apellidoP VARCHAR(30),
   apellidoM VARCHAR(30),
	id_edicion INT,
   id_usuario INT,
	FOREIGN KEY (id_edicion)
	REFERENCES r_ediciones(id_edicion)
	ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (id_usuario)
	REFERENCES r_usuarios(id_usuario)
	ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TABLE r_anuncios(
	id_anuncio INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   contenido TEXT,
   multimedia VARCHAR(100),
   vigente BOOL
);

CREATE TABLE r_administradores(
	id_administrador INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(30),
   apellidoP VARCHAR(30),
   apellidoM VARCHAR(30),
   id_usuario INT,
   FOREIGN KEY (id_usuario)
	REFERENCES r_usuarios(id_usuario)
	ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TABLE r_usuarios_sin_asignar(
	id_usuario_sin_asignar INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(30),
   apellidoP VARCHAR(30),
   apellidoM VARCHAR(30),
   id_usuario INT,
   FOREIGN KEY (id_usuario)
	REFERENCES r_usuarios(id_usuario)
	ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TABLE r_rubrica(
	id_rubrica INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   nombre1 VARCHAR(30),
   nombre2 VARCHAR(30),
   nombre3 VARCHAR(30),
   nombre4 VARCHAR(30),
   descripcion1 TEXT,
   descripcion2 TEXT,
   descripcion3 TEXT,
   descripcion4 TEXT
);



CREATE TABLE r_ufs(
	id_uf VARCHAR(10) NOT NULL PRIMARY KEY,
   nombre VARCHAR(50)
);

CREATE TABLE r_categorias(
	id_categoria INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(50)
);

CREATE TABLE r_niveles_desarrollo(
	id_nivel INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(50)
);

CREATE TABLE r_proyectos(
   id_proyecto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,	
   poster VARCHAR(100),
   description TEXT,
   estatus BOOL,
   nombre VARCHAR(100),
   video VARCHAR(100),
   fecha_registro DATETIME,
   id_uf VARCHAR(10),
   id_docente INT,
   id_edicion INT,
   id_categoria INT,
   id_nivel INT,
   premio INT, #1-3 para ganadores, 0 para No ganador
   FOREIGN KEY (id_uf)
   REFERENCES r_ufs(id_uf)
   ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (id_docente)
   REFERENCES r_docentes(id_docente)
   ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (id_edicion)
   REFERENCES r_ediciones(id_edicion)
   ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (id_categoria)
   REFERENCES r_categorias(id_categoria)
   ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (id_nivel)
   REFERENCES r_niveles_desarrollo(id_nivel)
   ON DELETE RESTRICT
   ON UPDATE CASCADE
);

CREATE TABLE r_proyecto_estudiantes(
   id_registro INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   matricula VARCHAR(30),
   id_proyecto INT,
   FOREIGN KEY (matricula)
	REFERENCES r_estudiantes(matricula)
   ON DELETE CASCADE
   ON UPDATE CASCADE,
   FOREIGN KEY (id_proyecto)
	REFERENCES r_proyectos(id_proyecto)
   ON DELETE CASCADE
   ON UPDATE CASCADE
);


CREATE TABLE r_calificaciones(
	id_calificacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	puntos_rubro1 INT,
   puntos_rubro2 INT,
   puntos_rubro3 INT,
   puntos_rubro4 INT,
   comentarios TEXT,
   fecha DATETIME,
   id_proyecto INT,
   id_juez INT,
   FOREIGN KEY (id_proyecto)
   REFERENCES r_proyectos(id_proyecto)
   ON DELETE CASCADE
   ON UPDATE CASCADE,
   FOREIGN KEY (id_juez)
   REFERENCES r_jueces(id_juez)
   ON DELETE RESTRICT
   ON UPDATE CASCADE
);

INSERT INTO r_usuarios (correo, contrasenia) VALUES
('user1@example.com', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO'),
('diegovilla@tec.mx', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO'),
('leovilla@tec.mx', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO'),
('juez1@gmail.com', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO'),
('juez2@gmail.com', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO'),
('a01275287@tec.mx', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO'),
('user7@example.com', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO'),
('user8@example.com', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO'),
('user9@example.com', '$2y$10$hE5CX91wVSHqXUrE9BdPxudyY6miqEpUP3A6x70WuLacAGvtGKqrO');

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
VALUES ('https://drive.google.com/uc?export=view&id=1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q', 'This is a project about machine learning', true, 'Machine Learning Project', '//www.youtube.com/embed/pF-3S-HTJSg', NOW(), 'UF001', 2, 1, 1,1,0),
       ('https://drive.google.com/uc?export=view&id=1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q', 'This is another project about machine learning', true, 'Another Machine Learning Project', '//www.youtube.com/embed/pF-3S-HTJSg', NOW(), 'UF002', 1, 1, 1,1,0),
       ('https://drive.google.com/uc?export=view&id=1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q', 'This is a third project about machine learning', true, 'Creación de nanomateriales', '//www.youtube.com/embed/pF-3S-HTJSg', NOW(), 'UF001', 2, 1, 1,2,0),
       ('https://drive.google.com/uc?export=view&id=1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q', 'This is a fourth project about machine learning', true, 'Mezcal sin azúcar', '//www.youtube.com/embed/pF-3S-HTJSg', NOW(), 'UF002', 2, 1, 1,2,0),
       ('https://drive.google.com/uc?export=view&id=1-zdvbP7_yWGQJL67LA7Ctx7JnxVCQM5q', 'This is a fifth project about machine learning', false, 'Prueba de caída libre', '//www.youtube.com/embed/pF-3S-HTJSg', NOW(), 'UF002', 2, 1, 1,2,0);

INSERT INTO r_proyecto_estudiantes (id_registro, matricula, id_proyecto)
VALUES   (NULL, 'a01271234', 1),
         (NULL, 'a01731235', 2),
         (NULL, 'a01271234', 3),
         (NULL, 'a01731235', 4),
         (NULL, 'a01271234', 5);
         