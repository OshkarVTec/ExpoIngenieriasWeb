<?php


require 'database.php';

$Error = null;

if (!empty($_POST)) {

	$nombre = $_POST['nombre'];
	$primer_apellido = $_POST['primer_apellido'];
	$segundo_apellido = $_POST['segundo_apellido'];
	$correo = strtolower($_POST['correo']);
	$contrasenia = ($_POST['contrasenia']);
	$confirmar_contrasenia = ($_POST['confirmar_contrasenia']);
	$tipo_usuario = $_POST['tipo_usuario'];
	$carrera = $_POST['id_carrera'];


	// validate input
	$valid = true;

	if (empty($nombre)) {
		$Error = 'Por favor escribe un nombre';
		$valid = false;
	}
	if (empty($primer_apellido)) {
		$Error = 'Por favor escribe un apellido paterno';
		$valid = false;
	}
	if (empty($segundo_apellido)) {
		$Error = 'Por favor escribe un apellido materno';
		$valid = false;
	}
	if (empty($correo)) {
		$Error = 'Por favor escribe un correo';
		$valid = false;
	} else {
		list($matricula, $dominio) = explode('@', $correo);
	}
	if (empty($contrasenia)) {
		$Error = 'Por favor escribe una contraseña';
		$valid = false;
	}
	if (empty($confirmar_contrasenia)) {
		$Error = 'Por favor confirma tu contraseña';
		$valid = false;
	}
	if ($contrasenia != $confirmar_contrasenia) {
		$Error = 'Las contraseñas no coinciden';
		$valid = false;
	}
	if ($tipo_usuario == "Estudiante" && strlen($matricula) != 9) {
		$Error = 'Por favor introduce un correo institucional';
		$valid = false;
	}
	if (($tipo_usuario == "Estudiante" || $tipo_usuario == "Docente") && $dominio != "tec.mx") {
		$Error = 'Por favor introduce un correo institucional';
		$valid = false;
	}

	// insert data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO r_usuarios values(null,?,?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($correo, $contrasenia));
		$id_usuario = $pdo->lastInsertId();
		switch ($tipo_usuario) {
			case "Estudiante":
				$sql = "INSERT INTO r_estudiantes (matricula,nombre,apellidoP, apellidoM,id_usuario, id_carrera) values(?, ?, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($matricula, $nombre, $primer_apellido, $segundo_apellido, $id_usuario, $carrera));
				break;
			case "Docente":
				$sql = "INSERT INTO r_docentes (id_docente,nombre,apellidoP, apellidoM,id_usuario) values(null, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($nombre, $primer_apellido, $segundo_apellido, $id_usuario));
				break;
			case "Externo":
				$sql = "INSERT INTO r_usuarios_sin_asignar (id_usuario_sin_asignar,nombre,apellidoP, apellidoM,id_usuario) values(null, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($nombre, $primer_apellido, $segundo_apellido, $id_usuario));
				break;
		}
		Database::disconnect();
		header("Location: login.php");
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro</title>
	<link rel="stylesheet" href="CSS/style.css">
</head>

<body>
	<header class="header">
		<div class="logo">
			<img src="IMG/logo-expo.png" alt="Logo de la pagina">
		</div>
		<a href="login.php" class="btn"><button>Log In</button></a>
	</header>
	<div class="small_window">
		<h1 class="label">Registro</h1>
		<div class="container">
			<form class="login" action="registro.php" method=POST>
				<table>
					<tr>
						<td>
							<label for="tipo_usuario">Tipo de usuario</label>
						</td>
						<?php
						$rol = null;
						if (!empty($_GET['rol'])) {
							$rol = $_REQUEST['rol'];
						}
						?>
						<td>
							<select name="tipo_usuario" id="tipo_usuario" onchange="reloadPage(this.value)">
								<option value="Externo" <?php if ($rol == 'Externo' || $tipo_usuario == 'Externo') {
									echo 'selected=true';
								} ?>>Externo</option>
								<option value="Estudiante" <?php if ($rol == 'Estudiante' || $tipo_usuario == 'Estudiante') {
									echo 'selected=true';
								} ?>>Estudiante
								</option>
								<option value="Docente" <?php if ($rol == 'Docente' || $tipo_usuario == 'Docente') {
									echo 'selected=true';
								} ?>>Docente</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<?php
							if ($rol == 'Estudiante' || $tipo_usuario == 'Estudiante') {
								echo '<label for="Carrera">Carrera</label>';
								echo '</td>';
								echo '<td>';
								echo '<select name= "id_carrera" id="id_carrera">';

								$pdo = Database::connect();
								$query = 'SELECT * FROM r_carreras';

								foreach ($pdo->query($query) as $row) {
									echo "<option  value=" . $row['id_carrera'] . ">" . $row['nombre'] . "</option>";
								}
								Database::disconnect();
							}
							?>
							</select>
						</td>
					</tr>
					<tr id="materia">
					</tr>
					<tr>
						<td><label for="nombre">Nombre (s)</label></td>
						<td><input type="text" name="nombre" value="<?php echo !empty($nombre) ? $nombre : ''; ?>"></td>
					</tr>
					<tr>
						<td><label for="primer_apellido">Primer apellido</label></td>
						<td><input type="text" name="primer_apellido"
								value="<?php echo !empty($primer_apellido) ? $primer_apellido : ''; ?>"></td>
					</tr>
					<tr>
						<td><label for="segundo_apellido">Segundo apellido</label></td>
						<td><input type="text" name="segundo_apellido"
								value="<?php echo !empty($segundo_apellido) ? $segundo_apellido : ''; ?>"></td>
					</tr>
					<tr>
						<td><label for="correo">Correo electrónico</label></td>
						<td><input type="text" name="correo" value="<?php echo !empty($correo) ? $correo : ''; ?>"></td>
					</tr>
					<tr>
						<td><label for="contrasenia">Contraseña</label></td>
						<td><input type="password" name="contrasenia"
								value="<?php echo !empty($contrasenia) ? $contrasenia : ''; ?>"></td>
					</tr>
					<tr>
						<td><label for="confirmar_contrasenia">Confirmar contraseña</label></td>
						<td><input type="password" name="confirmar_contrasenia"
								value="<?php echo !empty($confirmar_contrasenia) ? $confirmar_contrasenia : ''; ?>"></td>
					</tr>
					<script>
						function reloadPage(value) {
							window.location.href = "registro.php?rol=" + value;
						}
					</script>

				</table>
				<div>
					<td><input value="Registrarse" type="submit" class="btn"></td>
				</div>
				<?php if (($Error != null)) ?>
				<div class="Error">
					<?php echo $Error; ?>
				</div>
			</form>
		</div>
	</div>
</body>

</html>