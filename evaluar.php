
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Evaluar</title>
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
   <h1 class="label">Evaluados</h1>
   <div class = "container">
      <table class="general">  
   <?php
      include 'database.php';
      $pdo = Database::connect();
      $sql = 'SELECT *  FROM r_calificaciones WHERE puntos_rubro1 is not null AND puntos_rubro2 is not null AND puntos_rubro3 is not null AND puntos_rubro4 is not null';
      foreach ($pdo->query($sql) as $row) {
         $sql = 'SELECT * FROM r_proyectos WHERE id_proyecto = ?';
         $q = $pdo->prepare($sql);
         $q->execute(array($row['id_proyecto']));
         $proyecto = $q->fetch(PDO::FETCH_ASSOC);
         $sql = 'SELECT * FROM r_niveles_desarrollo WHERE id_nivel = ?';
         $q = $pdo->prepare($sql);
         $q->execute(array($proyecto['id_nivel']));
         $nivel = $q->fetch(PDO::FETCH_ASSOC);
         echo '<tr>';
         echo '<td>';
         echo '<a class="link" href="proyecto.php?id='.$proyecto['id_proyecto'].'">'. $proyecto['nombre'] .'</a>';
         echo '<p>Nivel de desarrollo: '.$nivel['nombre'].'</p>';
         echo '</td>';
         echo '<td class = "two_objects_column">';
         echo ($row['puntos_rubro1'] + $row['puntos_rubro2'] + $row['puntos_rubro3'] + $row['puntos_rubro4']) / 4;
         echo '<a class="btn" href="actualizar_evaluacion.php?id='.$row['id_calificacion'].'">Editar</a>';
         echo '</td>';
         echo '</tr>';
      }
      Database::disconnect();
   ?>
   </table>
   </div>

   <h1 class="label">Por evaluar</h1>
   <div class = "container">
      <table class="general">  
      <?php
      $pdo = Database::connect();
      $sql = 'SELECT *  FROM r_calificaciones WHERE puntos_rubro1 is null OR puntos_rubro2 is null OR puntos_rubro3 is null OR puntos_rubro4 is null';
      foreach ($pdo->query($sql) as $row) {
         $sql = 'SELECT * FROM r_proyectos WHERE id_proyecto = ?';
         $q = $pdo->prepare($sql);
         $q->execute(array($row['id_proyecto']));
         $proyecto = $q->fetch(PDO::FETCH_ASSOC);
         echo '<tr>';
         echo '<td>';
         echo '<a class="link" href="informativa.html?id_proyecto='.$proyecto['id_proyecto'].'">'. $proyecto['nombre'] .'</a>';
         echo '</td>';
         echo '<td>';
         echo '<a class="btn" href="evaluacion.php?id='.$row['id_calificacion'].'">Evaluar</a>';
         echo '</td>';
         echo '</tr>';
      }
      Database::disconnect();
   ?>
      </table>
   </div>
</body>
</html>