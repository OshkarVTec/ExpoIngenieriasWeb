CREATE TABLE r_ediciones(
	id_edicion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30),
	fecha_inicio DATE,
	fecha_final DATE
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

CREATE TABLE r_docentes(
	id_docente INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
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
   multimedia VARCHAR(50),
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
   apellidoM VARCHAR(30)
);

CREATE TABLE r_rubrica(
	id_rubro INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(30),
   descripcion1 TEXT,
   descripcion2 TEXT,
   descripcion3 TEXT,
   descripcion4 TEXT
);

CREATE TABLE r_puntos_rubro(
	id_puntos_rubro INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   id_rubro INT,
   puntos INT,
   FOREIGN KEY (id_rubro)
   REFERENCES r_rubrica(id_rubro)
   ON DELETE RESTRICT
   ON UPDATE CASCADE
);



CREATE TABLE r_ufs(
	id_uf VARCHAR(10) NOT NULL PRIMARY KEY,
   nombre VARCHAR(50)
);

CREATE TABLE r_categorias(
	id_categoria INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   nombre VARCHAR(50)
);


CREATE TABLE r_proyectos(
   id_proyecto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,	
   poster VARCHAR(100),
   description TEXT,
   estatus BOOL,
   nombre VARCHAR(50),
   video VARCHAR(100),
   fecha_registro DATETIME,
   id_uf VARCHAR(10),
   id_docente INT,
   id_edicion INT,
   id_categoria INT,
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
   ON UPDATE CASCADE
);

CREATE TABLE r_asignacion_jueces(
	id_asignacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	id_juez INT,
	id_proyecto INT,
	FOREIGN KEY (id_juez)
	REFERENCES r_jueces(id_juez)
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
   id_asignacion INT,
   FOREIGN KEY (id_asignacion)
   REFERENCES r_asignacion_jueces(id_asignacion)
   ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (puntos_rubro1)
   REFERENCES r_puntos_rubro(id_puntos_rubro)
   ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (puntos_rubro2)
   REFERENCES r_puntos_rubro(id_puntos_rubro)
   ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (puntos_rubro3)
   REFERENCES r_puntos_rubro(id_puntos_rubro)
   ON DELETE RESTRICT
   ON UPDATE CASCADE,
   FOREIGN KEY (puntos_rubro4)
   REFERENCES r_puntos_rubro(id_puntos_rubro)
   ON DELETE RESTRICT
   ON UPDATE CASCADE
);
