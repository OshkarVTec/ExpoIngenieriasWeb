

<?php
   $id_anuncio = null;
	if ( !empty($_GET['id_anuncio'])) {
		$id_proyecto = $_REQUEST['id_anuncio'];
	}
	require 'database.php';

		$Error = null;

	if (!empty($_POST)) {

		$contenido = $_POST['contenido'];
		$multimedia = $_POST['multimedia'];
		$vigencia   = $_POST['vigencia'];
		

		// validate input
		$valid = true;

		if (empty($contenido)) {
			$Error = 'Escriba el contenido del anuncio';
			$valid = false;
		}
		if (empty($multimedia)) {
			$Error = 'Inserte Link de multimedia';
			$valid = false;
		}

        
		

		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE r_anuncios 
                  SET contenido = ?,  multimedia = ?
                  WHERE id_proyecto = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($contenido,$multimedia));
			Database::disconnect();
			header("Location: informativa_estudiante.html");
		}
   }
   else{
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'SELECT * FROM r_anuncios WHERE id_anuncio = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($id_anuncio));
      $row = $q->fetch(PDO::FETCH_ASSOC);
      $contenido = $row['contenido'];
      $multimedia = $row['multimedia'];
      Database::disconnect();
   }

   
?>

<p name = "anuncios">
               <?php
                  $pdo = Database::connect();



   //if(isset($_GET['id_anuncio'])) {
   //$id_anuncio = $_GET['id_anuncio'];
               
                  
                 
                    echo '<td class="email-column"><a class="link-edicion">'.$row['contenido'].'</a><br><br></td>';

            
                    echo '<td class="email-column"><a class="link-edicion">'.$row['multimedia'].'</a></td>';
                  Database::disconnect();
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
         <a href="informativa_presentacion.html"><img src="IMG/logo-expo.png" alt="Logo de la pagina"></a>
      </div>
      <h1>Announcement Form</h1>
      </header>
      <div class = "ventana">
         <h1 class="label"></h1>
         <div class="container">
      <form class = "login" action="actualizar_anuncio.php?id_proyecto=<?php echo $id_anuncio?>" method=POST>
      <table>

      <tr>
            <td><label for="descripcion">Anuncio:</label></td>
            <td><textarea id="comment" name="descripcion"><?php echo !empty($contenido)?$contenido:'';?></textarea></td>
            </tr>


         <tr>
            <td><label for="poster">Link de multimedia: </label></td>
            <td><input type="text" id="link" name="poster" value="<?php echo !empty($multimedia)?$multimedia:'';?>"></td>
         </tr>
         <tr>
        

      

         </table>
         <div>
            <button class="cancel" onclick="history.go(-1);">Cancelar</button>
            <?php
            session_start();
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM r_anuncios WHERE id_anuncio = ?';
            $q = $pdo->prepare($sql);
            $q->execute(array($_SESSION['estudiante']));
            $p_estudiantes = $q->fetch(PDO::FETCH_ASSOC);
            $proyecto = $p_estudiantes['id_anuncio'];

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM r_anuncios WHERE id_anuncio = ?';
            $q = $pdo->prepare($sql);
            $q->execute(array($proyecto));
            $row = $q->fetch(PDO::FETCH_ASSOC);
            $status = $row['estatus'];
            if($status == 0){
               echo '<input value="Actualizar Proyecto" type="submit" class = "btn" >';
            }
            
            ?>
         </div>
         <?php if (($Error != null)) ?>
				<div class="Error"><?php echo $Error;?></div>
      </form>
   </body>
</html>
 