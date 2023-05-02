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

