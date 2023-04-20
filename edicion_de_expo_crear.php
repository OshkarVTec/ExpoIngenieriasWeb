<?php

	require 'database.php';

  $Error = null;

	if ( !empty($_POST)) {

		$nombre   = $_POST['input-nombre'];
		$fecha_inicio = $_POST['fecha_inicio'];
		$fecha_final = $_POST['fecha_final'];
		$activa = isset($_POST['activa']); 
    //checa si la checkbox está en checked y regresa un 1, si no regresa 0


		/// validate input
		$valid = true;

		if (empty($nombre)) {
			$Error = 'Introduce un nombre válido.';
			$valid = false;
		}

		if (empty($fecha_inicio)) {
			$Error = 'Introduce una fecha de inicio.';
			$valid = false;
		}

    if (empty($fecha_final)) {
			$Error = 'Introduce una fecha de cierre.';
			$valid = false;
		}

		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "INSERT INTO r_ediciones (id_edicion, nombre, fecha_inicio, fecha_final, activa)
      values (NULL, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($nombre ,$fecha_inicio, $fecha_final, $activa));
      echo 'Nueva edición creada exitosamente!';
			Database::disconnect();
			// header("Location: edicion_de_expo_vista.php");
		}
   }
 
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

    <!-- <p>aaaaaa</p> -->
    <!-- <p><br><br><br><br></p> -->

    <div id="forms-editar-edicion-expo" class="container">
      <form action="edicion_de_expo_crear.php" method=POST>
        <div id="nombre">
          <label for="input-nombre">Nombre</label>
          <input
            type="text"
            id="input-nombre"
            name="input-nombre"
            placeholder="Escribe el nombre de la edición..."
            
            value="<?php echo !empty($nombre)?$nombre:''?>"
          />
        </div>

        <div id="fecha-inicio">
          <label for="fecha_inicio">Fecha de inicio de inscripciones</label>
          <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo !empty($fecha_inicio)?$fecha_inicio:'';?>"/>
          
        </div>

        <div id="fecha-fin">
          <label for="fecha_final">Fecha fin de inscripciones</label>
          <input type="date" id="fecha_final" name="fecha_final" value="<?php echo !empty($fecha_final)?$fecha_final:'';?>" />
        </div>

        <div id="estatus-div">
          <label for="activa">Activa</label>
          <input type="checkbox" id="activa" name="activa" />
        </div>

        <div id="opciones">
          <div id="guardar">

            <a href="edicion_de_expo_vista.php">
            <button class="btn" type="submit">Guardar</button>
          </div>
          <div id="cancelar">

            <a href="edicion_de_expo_vista.php">
            <button type="button" class="btn"  id="btn-cancelar">Cancelar</button>
            <?php if (($Error != null)) ?>
				    <div class="Error"><?php echo $Error;?></div>
          </div>
        </div>
      </form>
    </div>

    <footer>
      <div id="footer-seccion-superior">
        <div class="seccion-superior">
          <h3>Tecnológico de Monterrey campus Puebla</h3>
          <h4>Atlixcáyotl 5718</h4>
          <h4>Reserva Territorial Atlixcáyotl, 72453</h4>
        </div>
        <div id="seccion-iconos">
          <img id="telefono" src="IMG/telefono_icon.png" alt="" />
          <img src="../img/email_icon.png" alt="" />
        </div>
        <div id="info-contacto" class="seccion-superior">
          <h4>+52 81 8358 2000</h4>
          <h4>jraguilar@tec.mx</h4>
        </div>
      </div>

      <hr />

      <div id="footer-seccion-inferior">
        <div id="redes-sociales">
          <img
            id="facebook_icon"
            src="../img/facebook_icon.png"
            alt=""
            onclick="redireccionFacebook()"
          />
          <img
            id="insta-icon"
            src="../img/insta_icon.png"
            alt=""
            onclick="redireccionIG()"
          />
        </div>
        <div id="logo-footer">
          <img src="../img/expo_logo.png" alt="" onclick="redireccionLogo()" />
        </div>
      </div>
    </footer>
  </body>
</html>