<?php
   $id_proyecto = null;
	if ( !empty($_GET['id_proyecto'])) {
		$id_proyecto = $_REQUEST['id_proyecto'];
	}
	require 'database.php';

		$Error = null;

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'SELECT * FROM r_proyectos WHERE id_proyecto = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($id_proyecto));
      $row = $q->fetch(PDO::FETCH_ASSOC);
      $name = $row['nombre'];
      $poster = $row['poster'];
      $video   = $row['video'];
      $uf = $row['id_uf'];
      $docente = $row['id_docente'];
      $categoria = $row['id_categoria'];
      $descripcion = $row['description'];
      Database::disconnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Proyecto</title>
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

    <div class="container">
        <div class="firstrow">
            <h1 class="title"><?php echo !empty($name)?$name:'';?></h1>
            <p class ="status"><?php echo !empty($status)?$status:'';?></p>
            <?php 
                    $pdo = Database::connect();
                    $sql = 'SELECT * FROM r_ufs WHERE id_uf = 1';
                    $q = $pdo->prepare($sql);
                    $q->execute($ufs);
                    $ufs = $q->fetch(PDO::FETCH_ASSOC);
                    echo '<p class ="status">'; 
                    echo $ufs['nombre'];
                    echo '</p>';
                    Database::disconnect();
                    ?>
            <a href="actualizar_proyecto.php" class="btnP"><button>Editar</button></a>
        </div>
        <hr color="#1687A7">
        <div class="secondrow">
            <div>
            <p><?php echo !empty($descripcion)?$descripcion:'';?></p>
            <br>
            <h1>Video del Proyecto</h1>
            <iframe src=<?php echo !empty($video)?$video:'';?> width="560" height="315"></iframe>
            </div>  
            <img src=<?php echo !empty($poster)?$poster:'';?> alt="testimage" class="img">
        </div>
        <hr color="#1687A7">
        <div class="thirdrow">
            <div>
                <h1>Integrantes del Equipo</h1>
                <ul>
                    <li>!not done</li>
                    <li>Medio Metro</li>
                    <li>Natanael Cano</li>
                </ul>
            </div>
            <div>
                <h1>Docente Asignado</h1>
                <ul>
                    <?php 
                    $pdo = Database::connect();
                    $sql = 'SELECT * FROM r_docentes WHERE id_docente = 1';
                    $q = $pdo->prepare($sql);
                    $q->execute($docentes);
                    $docentes = $q->fetch(PDO::FETCH_ASSOC);
                    echo '<li>'; 
                    echo $docentes['nombre'] . ' ' . $docentes['apellidoP'] . ' ' . $docentes['apellidoM'];
                    echo '</li>';
                    Database::disconnect();
                    ?>
                </ul>
            </div>
            <div>
                <h1>Calificacion y Retroalimentacion</h1>
                <div class="calbox">
                    <p class="cal">99</p> 
                    <hr color="#FFFFFF">
                    <a href="#" class="caltext">Ver mas +</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>