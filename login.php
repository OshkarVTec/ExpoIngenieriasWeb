<?php
   session_start(); // Start the session
	require 'database.php';

		$Error = null;
	if ( !empty($_POST)) {
		$correo = strtolower($_POST['correo']);
		$contrasenia = $_POST['contrasenia'];
		// validate input
		$valid = true;
      
		if (empty($correo)) {
			$Error = 'Por favor escribe un correo';
			$valid = false;
		}
		if (empty($contrasenia)) {
			$Error = 'Por favor escribe una contraseña';
			$valid = false;
		}

		// read data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         // $sql = "SELECT r_usuarios.*, r_administradores.id_administrador 
         // FROM r_usuarios 
         // LEFT JOIN r_administradores ON r_usuarios.id_usuario = r_administradores.id_usuario
         // WHERE correo=? AND contrasenia=?";

         $sql = "SELECT
         r_usuarios.id_usuario,
         r_administradores.id_administrador,
         r_jueces.id_juez,
         r_docentes.id_docente,
         r_estudiantes.matricula,
         r_usuarios.contrasenia
         FROM r_usuarios 
         LEFT JOIN r_administradores ON r_usuarios.id_usuario = r_administradores.id_usuario
         LEFT JOIN r_jueces ON r_usuarios.id_usuario = r_jueces.id_usuario
         LEFT JOIN r_docentes ON r_usuarios.id_usuario = r_docentes.id_usuario
         LEFT JOIN r_estudiantes ON r_usuarios.id_usuario = r_estudiantes.id_usuario
         WHERE correo=?";

			$query = $pdo->prepare($sql);
			$query->execute(array($correo));
         $row = $query->rowCount();
			$fetch = $query->fetch();
         if($row > 0 && password_verify($contrasenia, $fetch['contrasenia'])) {
            print_r($fetch);
            //checa si es admin
            if ($fetch['id_administrador'] != null) {
               $_SESSION['admin'] = $fetch['id_administrador'];
               header("location: informativa.php");
            //checa si es juez
           } if ($fetch['id_juez'] != null) {
               $_SESSION['juez'] = $fetch['id_juez'];
               header("location: informativa.php");
            //checa si es profesor
           } if ($fetch['id_docente'] != null) {
               $_SESSION['docente'] = $fetch['id_docente'];
               header("location: informativa.php");
            //checa si es estudiante
           } if ($fetch['matricula'] != null) {
               $_SESSION['matricula'] = $fetch['matricula'];
               header("location: informativa.php");
           }
           $_SESSION['id_usuario'] = $fetch['id_usuario'];
        } else{
            $Error = 'Contraseña o correo incorrecto';
        }
         Database::disconnect();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Log In</title>
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
      <h1 class="label">Log in</h1>
      <div class="container">
         <form class="login" action="login.php" method=POST>
            <table class="general">  
               <tr>
                  <td><label for="correo">Correo electrónico</label></td>
                  <td><input type="text" name="correo" value="<?php echo !empty($correo)?$correo:'';?>"></td>
               </tr>
               <tr>
                  <td><label for="contrasenia">Contraseña</label></td>
                  <td><input type="password" name="contrasenia"></td>
               </tr>
            </table>
            <div> 
               <td><input value="Entrar" type="submit" class = "btn" ></td>
            </div>
            <div> 
               <p>¿No tienes cuenta aún?</p>
            </div>
            <div>
               <a class = "link" href="registro.php">Registrarse</a>
            </div>
            <?php if (($Error != null)) ?>
			   <div class="Error"><?php echo $Error;?></div>
         </form>
      </div>
   </div>
</body>
</html>