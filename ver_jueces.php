<?php
session_start();
if (!$_SESSION['admin'])
  header("Location:informativa.php");
if (isset($_GET['id_proyecto']))
  $id_proyecto = $_GET['id_proyecto'];
else
  header("Location: asignar_jueces.php");

include 'database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Asignar jueces</title>
  <link rel="stylesheet" href="CSS/style.css" />
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
  $pdo = Database::connect();
  $sql = 'SELECT * FROM r_proyectos WHERE id_proyecto = ?';
  $q = $pdo->prepare($sql);
  $q->execute(array($id_proyecto));
  $nombre = $q->fetch(PDO::FETCH_ASSOC)['nombre'];
  Database::disconnect();
  echo '<div><a class="link" href="asignar_jueces.php">Regresar</a></div>';
  echo '<div id="instrucciones-editar-usuario">';

  echo '<h1 class="label">Nombre del proyecto: ' . $nombre . '</h1>';

  echo '<h5 id="texto-instruciones">';
  echo 'Selecciona para asignar o deseleccionar a los jueces de este proyecto.';
  echo '</h5>';
  echo '</div>';

  echo '<div id="instrucciones-editar-usuario">';
  echo '<h1 class="label">Jueces asignados a este proyecto: </h1>';
  echo '<!-- <h5 id="texto-instruciones">';

  echo '</h5> -->';
  echo '</div>';


  ?>


  <!-- INSERT INTO `r_calificaciones`(`puntos_rubro1`, `puntos_rubro2`, 
  `puntos_rubro3`, `puntos_rubro4`, `comentarios`, `fecha`, `id_proyecto`, `id_juez`) 
  VALUES (0,0,0,0,'',?,?,?) -->


  <div class="container">
    <table class="general">




      <?php


      //form para quitar jueces
      echo '<form method="POST" action="asignar_juez.php" onsubmit="return true;">';

      $pdo = Database::connect();

      $sql = "SELECT r_jueces.nombre, r_jueces.apellidoP ,r_jueces.apellidoM, r_proyectos.id_proyecto, r_jueces.id_juez
        FROM r_jueces 
        LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
        LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
        WHERE r_proyectos.id_proyecto = ?";

      $stmt = $pdo->prepare($sql);
      $stmt->execute([$id_proyecto]);



      $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($proyectos as $row) {


        //cuenta los jueces que han sido asignados al proyecto actual
        $sql2 = "SELECT COUNT(*) AS num_rows 
          FROM ( 
          SELECT r_jueces.nombre, r_jueces.apellidoP, r_jueces.apellidoM, r_proyectos.id_proyecto, 		r_jueces.id_juez 
          FROM r_jueces 
          LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
          LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
          LEFT JOIN r_ediciones  ON r_proyectos.id_edicion = r_ediciones.id_edicion
          WHERE r_jueces.id_juez = ? AND r_ediciones.activa = 1
          ) AS subquery";

        $stmt = $pdo->prepare($sql2);
        $stmt->execute([$row['id_juez']]);
        $result = $stmt->fetch();
        $num_rows = $result['num_rows'];

        // echo "Number of rows: " . $num_rows;
      
        echo '<tr>';

        echo '<td id="nombre-juez"><a class="link-edicion">' . $row['nombre'] . ' ' . $row['apellidoP'] . ' ' . $row['apellidoM'] . '</a></td>';

        //checkbox
      
        echo '<td id="agregar-quitar-juez"><input type="checkbox" name="judge_id[]" value="' . $row['id_juez'] . '"></td>';
        echo '<td> #Proyectos asignados: ' . $num_rows . ' </td>';
        echo '</tr>';

      }

      ?>

    </table>
  </div>

  <div>
    <button id="nueva-edicion-btn" class="btn" type="submit" name="deasignar">Quitar</button>
  </div>


  <?php
  echo '<input id="input-hidden" type="hidden" name="id_proyecto" value="' . $id_proyecto . '" ?>';
  ?>

  </form>









  <div id="separador" id="instrucciones-editar-usuario">
    <h1 class="label">Jueces sin asignar a este proyecto: </h1>
    <!-- <h5 id="texto-instruciones">
    
    </h5> -->
  </div>


  <div class="container">
    <table class="general">



      <?php

      $id_proyecto = $_GET['id_proyecto'];

      echo '<form method="POST" action="asignar_juez.php" onsubmit="return true;">';


      //Te dice los jueces que forman parte de la edicion activa y que no forman parte del proyecto actual
      $sql = "SELECT *
        FROM r_jueces
        WHERE id_edicion = (
          SELECT id_edicion
          FROM r_ediciones
          WHERE activa = 1
        )
        AND id_juez NOT IN (
          SELECT id_juez
          FROM r_calificaciones
          WHERE id_proyecto = ?
        )";

      $q = $pdo->prepare($sql);
      $q->execute([$id_proyecto]); // Bind the parameter with the value
      // $rowCount = $stmt->rowCount();
      



      // $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($q as $row) {


        echo '<tr>';
        echo '<td id="nombre-juez"><a class="link-edicion">' . $row['nombre'] . ' ' . $row['apellidoP'] . ' ' . $row['apellidoM'] . '</a></td>';

        //checkbox
        // echo '<td id="agregar-quitar-juez"><input type="checkbox" id="activa" name="activa"   /></td>';
        echo '<td id="agregar-quitar-juez"><input type="checkbox" name="judge_id[]" value="' . $row['id_juez'] . '"></td>';





        $sql2 = "SELECT COUNT(DISTINCT r_calificaciones.id_proyecto)
        FROM r_calificaciones 
        JOIN r_proyectos ON r_calificaciones.id_proyecto = r_proyectos.id_proyecto
        JOIN r_ediciones  ON r_proyectos.id_edicion = r_ediciones.id_edicion
        WHERE r_calificaciones.id_juez = ? AND r_ediciones.activa = 1";

        $stmt = $pdo->prepare($sql2);
        $stmt->execute([$row['id_juez']]);
        $num_rows = $stmt->fetchColumn();

        echo '<td>#Proyectos asignados: ' . $num_rows . ' </td>';


        echo '</tr>';

      }



      Database::disconnect();
      ?>

    </table>

  </div>

  <div>
    <button id="nueva-edicion-btn" class="btn" type="submit" name="asignar">Asignar</button>
  </div>

  <?php
  echo '<input  type="hidden" name="id_proyecto" value="' . $id_proyecto . ' "?>';
  ?>



  </form>


  <article></article>
  <div id="footer"></div>
</body>

</html>