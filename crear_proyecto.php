<?php

	require 'database.php';

		$Error = null;

	if ( !empty($_POST)) {

		$name = $_POST['name'];
		$poster = $_POST['poster'];
		$video   = $_POST['video'];
		$uf = $_POST['uf'];
		$docente = $_POST['docente'];
		$categoria = $_POST['categoria'];
		$descripcion = $_POST['descripcion'];
		

		// validate input
		$valid = true;

		if (empty($name)) {
			$Error = 'Por favor escribe un nombre';
			$valid = false;
		}
		if (empty($poster)) {
			$Error = 'Por favor proporcione un link al poster';
			$valid = false;
		}
		if (empty($video)) {
			$Error = 'Por favor proporcione un link al video';
			$valid = false;
		}
		if (empty($uf)) {
			$Error = 'Por favor seleccione una UF';
			$valid = false;
		}
		if (empty($docente)) {
			$Error = 'Por favor seleccione un docente';
			$valid = false;
		}
		if (empty($categoria)) {
			$Error = 'Por favor seleccione una categoria';
			$valid = false;
		}
      if (empty($descripcion)) {
			$Error = 'Por favor proporcione una descripcion';
			$valid = false;
		}

		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO r_proyectos (id_proyecto, poster, description, estatus, nombre, video, 
                                fecha_registro, id_uf,  id_docente, id_edicion, id_categoria) 
                                values (NULL, ?, ?, false, ?,?, current_timestamp(), ?, ?, 1, ?)";
                                
			$q = $pdo->prepare($sql);
			$q->execute(array($poster,$descripcion, $name, $video, $uf, $docente, $categoria, ));
			Database::disconnect();
			header("Location: informativa.html");
		}
	}
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Nuevos Anuncios</title>
      <link rel="stylesheet" href="CSS/style.css">
   </head>
   <body>
      <header class="header">
      <div class="logo">
         <img src="IMG/logo-expo.png" alt="Logo de la pagina">
      </div>
      <h1>Announcement Form</h1>
      </header>
      <div class = "ventana">
         <h1 class="label"></h1>
         <div class="container">
      <form class = "login" action="crear_proyecto.php" method=POST>
      <table>
         
         <tr>
            <td><label for="name">Nombre del Proyecto:</label></td>
            <td><input type="text" id="title" name="name" value="<?php echo !empty($name)?$name:'';?>"></td>
            <td><input value="Agregar compañeros" type="submit" class = "btn" ></td> 
         </tr>

         <tr>
            <td><label for="poster">Link al poster:</label></td>
            <td><input type="text" id="link" name="poster" value="<?php echo !empty($poster)?$poster:'';?>"></td>
         </tr>
         <tr>
            <td><label for="video">Link al video:</label></td>
            <td><input type="text" id="link" name="video" value="<?php echo !empty($video)?$video:'';?>"></td>
            </tr>

         <tr>
            <td><label for="link">Seleccionar UF:</label></td>
            <td>     
            <select name = "uf">
               <?php
                  $pdo = Database::connect();
                  $query = 'SELECT * FROM r_ufs';
                  foreach ($pdo->query($query) as $row) {
                     echo "<option value='" . $row['id_uf'] . "'>" . $row['nombre'] . "</option>";
                  }
                  Database::disconnect();
               ?>
            </select>
            </td>
            </tr>

            <tr>
            <td><label for="docente">Seleccionar docente:</label></td>
            <td>    
            <select name = "docente">
               <?php
                  $pdo = Database::connect();
                  $query = 'SELECT * FROM r_docentes';
                  foreach ($pdo->query($query) as $row) {
                     echo "<option value='" . $row['id_docente'] . "'>" . $row['nombre'] . " " . $row['apellidoP'] . "</option>";
                  }
                  Database::disconnect();
               ?>
            </select>
            </td>
            </tr>

            <tr>
            <td><label for="categoria">Seleccionar categoría:</label></td>
            <td>    
            <select name = "categoria">
               <?php
                  $pdo = Database::connect();
                  $query = 'SELECT * FROM r_categorias';
                  foreach ($pdo->query($query) as $row) {
                     echo "<option value='" . $row['id_categoria'] . "'>" . $row['nombre'] . "</option>";
                  }
                  Database::disconnect();
               ?>
            </select>
            </td>
            </tr>

            <tr>
            <td><label for="descripcion">Descripcion:</label></td>
            <td><textarea id="comment" name="descripcion" value="<?php echo !empty($descripcion)?$descripcion:'';?>"></textarea></td>
            </tr>

         </table>
         <td><input value="Registrar Proyecto" type="submit" class = "btn" ></td> 
         <button type="button" id="cancel">Cancelar</button>
         <?php if (($Error != null)) ?>
				<div class="Error"><?php echo $Error;?></div>
      </form>
   </body>
</html>
 