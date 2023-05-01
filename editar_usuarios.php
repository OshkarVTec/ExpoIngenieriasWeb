<?php

	// require 'database.php';

//   // $activa = 1;

// 	$id_edicion = null;
// 	if ( !empty($_GET['id_edicion'])) {
// 		$id_edicion = $_REQUEST['id_edicion'];
// 	}


// 	if ( $id_edicion == null ) {
// 		header("Location: ver_usuarios.php");
// 	}

// 	if ( !empty($_POST)) {

// 		$nombre   = $_POST['input-nombre'];
// 		$fecha_inicio = $_POST['fecha_inicio'];
// 		$fecha_final = $_POST['fecha_final'];
// 		$activa = isset($_POST['activa']); 
//     //checa si la checkbox está en checked y regresa un 1, si no regresa 0


// 		/// validate input
// 		$valid = true;

// 		if (empty($nombre)) {
// 			$submError = 'Introduce un nombre válido.';
// 			$valid = false;
// 		}

// 		if (empty($fecha_inicio)) {
// 			$marcError = 'Introduce una fecha de inicio.';
// 			$valid = false;
// 		}

//     if (empty($fecha_final)) {
// 			$marcError = 'Introduce una fecha de cierre.';
// 			$valid = false;
// 		}

// 		// insert data
// 		if ($valid) {
// 			$pdo = Database::connect();
// 			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 			$sql = "UPDATE r_ediciones 
//                   SET nombre = ?,  fecha_inicio = ?, fecha_final = ?, activa = ?
//                   WHERE id_edicion = ?";
// 			$q = $pdo->prepare($sql);
// 			$q->execute(array($nombre, $fecha_inicio, $fecha_final, $activa , $id_edicion, ));
// 			Database::disconnect();
// 			// header("Location: edicion_de_expo_vista.php");
// 		}
//    }
//    else{
//       $pdo = Database::connect();
//       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//       $sql = 'SELECT * FROM r_ediciones WHERE id_edicion = ?';
//       $q = $pdo->prepare($sql);
//       $q->execute(array($id_edicion));
//       $row = $q->fetch(PDO::FETCH_ASSOC);
//       $nombre = $row['nombre'];
//       $fecha_inicio = $row['fecha_inicio'];
//       $fecha_final   = $row['fecha_final'];
//       Database::disconnect();
//    }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edición de expo editar</title>
    <link rel="stylesheet" href="CSS/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <a href="informativa_presentacion.html">
          <img src="IMG/logo-expo.png" alt="Logo de la pagina" />
        </a>
      </div>
      <a href="#" class="btn"><button>Log In</button></a>
    </header>




    <?php
        include 'database.php';
        $pdo = Database::connect();

        // Get the ID from the query string
        $id_usuario = $_GET['id_usuario'];

        //Get Rol
        $rol = $_GET['rol'];


        // Query the database for the user's details
        $sql = "SELECT * FROM r_usuarios WHERE id_usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display the user's details
        // echo '<h1>Editar usuario</h1>';
        // echo '<p>ID de usuario: ' . $row['id_usuario'] . '</p>';
        // echo '<p>Correo: ' . $row['correo'] . '</p>';
        // echo $rol;

        if($rol == 'Juez-Docente'){
            $checked_maestro = 'checked';
            $checked_juez = 'checked';
            $checked_administrador = ($rol == 'Administrador') ? 'checked' : '';
            $checked_estudiante = ($rol == 'Estudiante') ? 'checked' : '';
        }else{
            $checked_maestro = ($rol == 'Docente') ? 'checked' : '';
            $checked_juez = ($rol == 'Juez') ? 'checked' : '';
            $checked_administrador = ($rol == 'Administrador') ? 'checked' : '';
            $checked_estudiante = ($rol == 'Estudiante') ? 'checked' : '';
        }
        

        
        echo '<div id="instrucciones-editar-usuario">';
        echo '<h1 class="label">Editar '.$rol.'</h1>';
        echo '</div>';
 


        echo '<div class="container">';
        echo '<table class="general">';


        echo '<td class="id-column">';
        echo $id_usuario;
        echo '</td>';



        echo '<td class="email-column"><a class="link-edicion">'.$row['correo'].'</a></td>';

        // echo '<td class="row-botones">';
        // echo '<a class="btn" href="editar_usuarios.php?id_usuario=' . $id_usuario . '&rol=' . $rol . '">Editar</a>';

        // echo '</td>';
        if($rol != 'Administrador'){
            echo '<td class="row-botones">';
            echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario='.$id_usuario.'" onclick="return confirm(\'¿Estás seguro que deseas eliminar a este usuario?\')">Eliminar</a>';
    
            echo '</td>';   
        }



        echo '<td class="rol">';
        echo '<input type="checkbox" id="Maestro" name="Maestro"'.$checked_maestro.' />';
        echo '<label for="Maestro">Docente</label>';
        echo '</td>';


        

        echo '<td class="rol">';
        echo '<input type="checkbox" id="Juez" name="Juez"'.$checked_juez.' />';
        echo '<label for="Juez">Juez</label>';
        echo '</td>';

        echo '<td class="rol">';
        echo '<input type="checkbox" id="Administrador" name="Administrador"'.$checked_administrador.' />';
        echo '<label for="Administrador">Administrador</label>';
        echo '</td>';

        echo '<td class="rol">';
        echo '<input type="checkbox" id="Estudiante" name="Estudiante"'.$checked_estudiante.' />';
        echo '<label for="Estudiante">Estudiante</label>';
        echo '</td>';



        echo '</tr>';

        echo '</table>';
        echo '</div>';

        echo '</div>';
        if($rol == 'Juez-Docente' || $rol == 'Juez' || $rol == 'Docente'){
            echo '<button id="nueva-edicion-btn" class="btn">Guardar</button>';
        }
        
    ?>



  </body>
</html>
