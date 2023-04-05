<?php

	require 'database.php';

		$Error = null;
	if ( !empty($_POST)) {
		$correo = strtolower($_POST['correo']);
		$contrasenia = md5($_POST['contrasenia']);
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
			$sql = "SELECT * FROM r_usuarios WHERE correo=? AND contrasenia=?";
			$query = $pdo->prepare($sql);
			$query->execute(array($correo,$contrasenia));
			$row = $query->rowCount();
			$fetch = $query->fetch();
			if($row > 0) {
				header("location: home.php");
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
                  <td><input type="text" name="correo"></td>
               </tr>
               <tr>
                  <td><label for="constrasenia">Contraseña</label></td>
                  <td><input type="password" name="constrasenia"></td>
               </tr>
            </table>
            <div> 
               <td><input value="Entrar" type="submit" class = "btn" ></td>
            </div>
            <div> 
               <p>¿No tienes cuenta aún?</p>
            </div>
            <div>
               <a href="registro.php">Registrarse</a>
            </div>
            <?php if (($Error != null)) ?>
			   <div class="Error"><?php echo $Error;?></div>
         </form>
      </div>
   </div>
</body>
</html>