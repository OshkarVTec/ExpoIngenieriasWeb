<?php
   $id_calificacion = null;
	if ( !empty($_GET['id'])) {
		$id_calificacion = $_REQUEST['id'];
	}
	require 'database.php';

		$Error = null;

	if (!empty($_POST)) {

		$r1 = filter_var($_POST['r1'], FILTER_VALIDATE_INT);
      $r2 = filter_var($_POST['r2'], FILTER_VALIDATE_INT);
      $r3 = filter_var($_POST['r3'], FILTER_VALIDATE_INT);
		$r4 = filter_var($_POST['r4'], FILTER_VALIDATE_INT);
      $comentarios = $_POST['comentarios'];
		

		// validate input
		$valid = true;

		if (empty($r1) or empty($r2) or empty($r3) or empty($r4) 
         or $r1 === false or $r2 === false or $r3 === false or $r4 === false){
            $Error = 'Por favor escribe una calificacion válida';
            $valid = false;
		}
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE r_calificaciones 
                  SET puntos_rubro1 = ?,  puntos_rubro2 = ?, puntos_rubro3 = ?, puntos_rubro4 = ?, comentarios = ?
                  WHERE id_calificacion = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($r1,$r2, $r3, $r4, $comentarios, $id_calificacion));
			Database::disconnect();
			header("Location: evaluar.php");
		}
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Evaluar proyecto</title>
   <link rel="stylesheet" href="CSS/style.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
   <script> 
    $(function(){
      $("#header").load("header.html"); 
    });
    </script> 
</head>
<body>
   <div id="header"></div>
   <?php
      $pdo = Database::connect();
      $sql = 'SELECT *  FROM r_calificaciones WHERE id_calificacion = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($id_calificacion));
      $calificacion = $q->fetch(PDO::FETCH_ASSOC);
      $sql = 'SELECT *  FROM r_proyectos WHERE id_proyecto = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($calificacion['id_proyecto']));
      $proyecto = $q->fetch(PDO::FETCH_ASSOC);
      $sql = 'SELECT *  FROM r_rubrica';
      $q = $pdo->prepare($sql);
      $q->execute();
      $rubrica = $q->fetch(PDO::FETCH_ASSOC);
      echo '<h1 class="label">'.$proyecto['nombre'].'</h1>';
      Database::disconnect();
      ?>

   <form method="post" action="evaluacion.php?id=<?php echo $id_calificacion ?>">
   <div class = "container">
   <table class="general">
   <?php
      echo '<tr>';
      echo '<td>';
      echo '<a class="link" href="">'. $rubrica['nombre1'] .'</a>';
      echo '</td>';
      echo '<td>';
      echo '<input type="number" name="r1" value="';
      echo !empty($r1)?$r1:'';
      echo '">';
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo '<a class="link" href="">'. $rubrica['nombre2'] .'</a>';
      echo '</td>';
      echo '<td>';
      echo '<input type="number" name="r2" value="';
      echo !empty($r2)?$r2:'';
      echo '">';      
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo '<a class="link" href="">'. $rubrica['nombre3'] .'</a>';
      echo '</td>';
      echo '<td>';
      echo '<input type="number" name="r3" value="';
      echo !empty($r3)?$r3:'';
      echo '">';      
      echo '</td>';
      echo '</tr>';
      echo '<tr>';
      echo '<td>';
      echo '<a class="link" href="">'. $rubrica['nombre4'] .'</a>';
      echo '</td>';
      echo '<td>';
      echo '<input type="number" name="r4" value="';
      echo !empty($r4)?$r4:'';
      echo '">';
      echo '</td>';
      echo '</tr>';
      ?>
</table>
</div>
<div id="wrapper">
  <div id="w70"> 
   <p>Comentarios (opcional)</p> 
   <textarea id="comment" name="comentarios" ><?php echo !empty($comentarios)?$comentarios:'';?></textarea>
   <?php if (($Error != null)) ?>
	<div class="Error"><?php echo $Error;?></div>
  </div>
  <div id="w30">  
   <input value="Guardar" type="submit" class = "btn" >
   
  </div>
</div>
</form>


</body>
</html>