<?php


	require 'database.php';

		$Error = null;

	if ( !empty($_POST)) {

		$nombre = $_POST['nombre'];
		$primer_apellido = $_POST['primer_apellido'];
		$segundo_apellido   = $_POST['segundo_apellido'];
		$correo = strtolower($_POST['correo']);
		$contrasenia = ($_POST['contrasenia']);
		$confirmar_contrasenia = ($_POST['confirmar_contrasenia']);
		$tipo_usuario = $_POST['tipo_usuario'];
		

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
					list($matricula, $dominio) = explode('@', $correo);
					$sql = "INSERT INTO r_estudiantes (matricula,nombre,apellidoP, apellidoM,id_usuario) values(?, ?, ?, ?, ?)";
					$q = $pdo->prepare($sql);
					$q->execute(array($matricula,$nombre,$primer_apellido,$segundo_apellido,$id_usuario));
					break;
				case "Docente":
					$sql = "INSERT INTO r_docentes (id_docente,nombre,apellidoP, apellidoM,id_usuario) values(null, ?, ?, ?, ?)";
					$q = $pdo->prepare($sql);
					$q->execute(array($nombre,$primer_apellido,$segundo_apellido,$id_usuario));
					break;
				case "Externo":
					$sql = "INSERT INTO r_usuarios_sin_asignar (id_usuario_sin_asignar,nombre,apellidoP, apellidoM,id_usuario) values(null, ?, ?, ?, ?)";
					$q = $pdo->prepare($sql);
					$q->execute(array($nombre,$primer_apellido,$segundo_apellido,$id_usuario));
					break;
			}
			echo "hola";
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
      <a href="#" class="btn"><button>Log In</button></a>
   </header>
   <div class = "small_window">
      <h1 class="label">Registro</h1>
      <div class="container">
         <form  class="login" action="registro.php" method=POST>
            <table>  
               <tr>
                  <td><label for="nombre">Nombre (s)</label></td>
                  <td><input type="text" name="nombre" value="<?php echo !empty($nombre)?$nombre:'';?>"></td>
               </tr>
               <tr>
                  <td><label for="primer_apellido">Primer apellido</label></td>
                  <td><input type="text" name="primer_apellido" value="<?php echo !empty($primer_apellido)?$primer_apellido:'';?>"></td>
               </tr>
               <tr>
                  <td><label for="segundo_apellido">Segundo apellido</label></td>
                  <td><input type="text" name="segundo_apellido" value="<?php echo !empty($segundo_apellido)?$segundo_apellido:'';?>"></td>
               </tr>
               <tr>
                  <td><label for="correo">Correo electrónico</label></td>
                  <td><input type="text" name="correo" value="<?php echo !empty($correo)?$correo:'';?>"></td>
               </tr>
               <tr>
                  <td><label for="contrasenia">Contraseña</label></td>
                  <td><input type="password" name="contrasenia" value="<?php echo !empty($contrasenia)?$contrasenia:'';?>"></td>
               </tr>
               <tr>
                  <td><label for="confirmar_contrasenia">Confirmar contraseña</label></td>
                  <td><input type="password" name="confirmar_contrasenia" value="<?php echo !empty($confirmar_contrasenia)?$confirmar_contrasenia:'';?>"></td>
               </tr>
               <tr>
                  <td>
                     <label for="tipo_usuario">Tipo de usuario</label>
                  </td>
                  <td>
                     <select name="tipo_usuario" id="tipo_usuario">
                        <option value="Estudiante">Estudiante</option>
                        <option value="Juez">Docente</option>
                        <option value="Externo">Externo</option>
                     </select> 
                  </td>
               </tr>
            </table>
            <div> 
               <td><input value="Registrarse" type="submit" class = "btn"></td>
            </div>
				<?php if (($Error != null)) ?>
				<div class="Error"><?php echo $Error;?></div>
         </form>
      </div>
   </div>
</body>
</html>
