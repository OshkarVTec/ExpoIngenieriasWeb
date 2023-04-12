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
      $("#header").load("header.html"); 
    });
    </script> 
</head>
<body>
   <div id="header"></div>
   <?php
      include 'database.php';
      $pdo = Database::connect();
      $sql = 'SELECT * FROM r_categorias ORDER BY id_categoria';
      foreach ($pdo->query($sql) as $row) {
         echo '<h1 class="label">'.$row['nombre'].'</h1>';
         echo '<div class = "container">';
         echo '<table class="general">';
         $sql = 'SELECT * FROM r_proyectos WHERE id_categoria ='.$row['id_categoria'];
         foreach ($pdo->query($sql) as $row) {
            echo '<tr>';
            echo '<td>';
            echo '<div>'. $row['nombre'] .'</div>';
            echo '<td>';
            echo '<a class="btn" href="proyecto.php?v=<?php echo time(); ?>?id_proyecto='.$row['id_proyecto'].'">Detalles</a>';
            echo '</td>';
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