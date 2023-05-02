<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ver proyectos</title>
   <link rel="stylesheet" href="CSS/style.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
   <script> 
    $(function(){
      $("#header").load(<?php 
        if($_SESSION['estudiante'] != null){
            echo '"header_estudiante.php"';
        } else if($_SESSION['admin'] != null){
            echo '"header_admin.php"';
        } else if($_SESSION['juez'] != null){
            echo '"header_juez.php"';
        } else if($_SESSION['docente'] != null){
            echo '"header_docente.php"';
        }
        ?>); 
    });
    </script> 
</head>
<body>
   <div id="header"></div>
   <?php
      include 'database.php';
      $pdo = Database::connect();
      $sql = 'SELECT *  FROM r_ediciones WHERE activa = 1';
      $q = $pdo->prepare($sql);
      $q->execute();
      $id_edicion = $q->fetch(PDO::FETCH_ASSOC)['id_edicion'];
      $sql = 'SELECT * FROM r_categorias ORDER BY id_categoria';
      foreach ($pdo->query($sql) as $row) {
         echo '<h1 class="label">'.$row['nombre'].'</h1>';
         echo '<div class = "container">';
         echo '<table class="general">';
         $sql = 'SELECT * FROM r_proyectos WHERE id_categoria = ? AND id_edicion = ?';
         $q = $pdo->prepare($sql);
         $q->execute(array($row['id_categoria'], $id_edicion));
         $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);
         foreach ($proyectos as $row) {
            echo '<tr>';
            echo '<td>';
            echo '<a class="link" href="proyecto.php?id_proyecto='.$row['id_proyecto'].'">'. $row['nombre'] .'</a>';
            echo '</td>';
            echo '</tr>';
         }
         echo '</table>';
         echo '</div>';
      }
      Database::disconnect();
   ?>
</body>
</html>