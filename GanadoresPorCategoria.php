<?php 
session_start();
if ($_SESSION['admin'] != null)
   $id_juez = $_SESSION['admin'];
else
   header("Location:informativa.php");

 //  if(!empty($_POST)){
 //     $premio = $_POST['premio'];
 //     $pdo = Database::connect();
 //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 //     $sql = "INSERT INTO r_proyectos (premio) where id_ values (?)";
//
 //     $q = $pdo->prepare($sql);
 //     $q->execute(array($premio));
 //     Database::disconnect();
 //     header("Location: informativa.php");
 //  }
?>
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
    $(function () {
      $("#header").load(<?php
      if ($_SESSION['matricula'] != null) {
        echo '"header_estudiante.php"';
      } else if ($_SESSION['admin'] != null) {
        echo '"header_admin.php"';
      } else if ($_SESSION['juez'] != null) {
        if ($_SESSION['docente'] != null)
          echo '"header_docente_juez.php"';
        else
          echo '"header_juez.php"';
      } else if ($_SESSION['docente'] != null) {
        echo '"header_docente.php"';
      }
      ?>);
    });
    $(function () {
      $("#footer").load("footer.html");
    })
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
    echo '<h1 class="label">' . $row['nombre'] . '</h1>';
    echo '<div class = "container">';
    echo '<table class="general">';
    $sql = 'SELECT * FROM r_proyectos WHERE id_categoria = ? AND id_edicion = ?';
    $q = $pdo->prepare($sql);
    $q->execute(array($row['id_categoria'], $id_edicion));
    $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);


    $postvalues = array();
    $idps = array();
    $i=0;
    foreach ($proyectos as $row) {
      echo '<tr>';
      echo '<td>';
      echo '<a class="link" href="proyecto.php?id_proyecto=' . $row['id_proyecto'] . '">' . $row['nombre'] . '</a>';
      echo '<td class = "column">';
      $promedios = 0;
      $i = 1;
      $id_proyecto = $row['id_proyecto'];
      $sql = 'SELECT * FROM r_calificaciones WHERE id_proyecto = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($row['id_proyecto']));
      $calificaciones = $q->fetchAll(PDO::FETCH_ASSOC);
      foreach ($calificaciones as $row1) {
          $promedio = ($row1['puntos_rubro1'] + $row1['puntos_rubro2'] + $row1['puntos_rubro3'] + $row1['puntos_rubro4']) / 4;
          $promedios = ($promedios + $promedio) / $i;
          $i = $i + 1;
      }
      echo '<form action="GanadoresPorCategoria.php" method="POST">';
      echo $promedios;
      echo '<select name="premio">
              <option value="1" >Primer lugar</option>
              <option value="2">Segundo lugar</option>
              <option value="3" selected=true>Tercer lugar</option>
              <option value="4" >No ganador</option>
              
            </select>';

      echo '</td>';
      echo '</td>';
      echo '</tr>';

      array_push($postvalues, $_POST['premio']);
      array_push($idps, $id_proyecto);      
    }
    echo '</table>';
    echo '</div>';
    
  }


  if (isset($_POST['submit'])) {
    foreach($idps as $row){
    $sql = "UPDATE r_proyectos SET premio=? WHERE id_proyecto=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($postvalues[$i], $row[$i]));
    $i = $i+1;
    }
  Database::disconnect();
  header("Location: informativa.php");
}


  Database::disconnect();
  ?>


  <div class='cornerbtn'>
    <div></div>
  <button class="btnguardar" name="submit">Guardar</button>
</div>
  <br>

  <div id="footer"></div>


</body>
</html>