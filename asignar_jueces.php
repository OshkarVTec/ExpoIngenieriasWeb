<?php
session_start();
if (!$_SESSION['admin'])
  header("Location:informativa.php");
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

  <h1 class="label">Nivel de desarrollo: Idea</h1>
  <div class="container">
    <table class="general">

      <?php
      include 'database.php';
      $pdo = Database::connect();

      // First query
      $sql = 'SELECT r_proyectos.id_proyecto, r_proyectos.nombre, r_categorias.nombre as categoria, r_niveles_desarrollo.nombre as nivel_de_desarrollo 
  FROM r_proyectos 
  LEFT JOIN r_categorias ON r_proyectos.id_proyecto = r_categorias.id_categoria 
  LEFT JOIN r_niveles_desarrollo ON r_proyectos.id_nivel = r_niveles_desarrollo.id_nivel
  LEFT JOIN r_ediciones ON r_ediciones.id_edicion = r_proyectos.id_edicion
  WHERE r_niveles_desarrollo.id_nivel = 1 AND r_ediciones.activa = 1 AND r_proyectos.estatus = true';

      $q = $pdo->prepare($sql);
      $q->execute(array());

      // Loop through the results
      foreach ($q as $row) {
        echo '<tr >';
        echo '<td class="row-nombre-proyecto">';
        echo '<a >' . $row['nombre'] . '</a>';
        echo '</td>';


        echo '<td class="row-etiqueta">';

        // Second query
        $sql2 = "SELECT r_jueces.nombre, r_jueces.apellidoP ,r_jueces.apellidoM, r_proyectos.id_proyecto  
    FROM r_jueces 
    LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
    LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
    WHERE r_proyectos.id_proyecto = ?";

        $stmt = $pdo->prepare($sql2);
        $stmt->execute([$row['id_proyecto']]); // Bind the parameter with the value
        $rowCount = $stmt->rowCount();


        echo '<p>' . $row['categoria'] . '</p>';
        echo '</td>';


        echo '<td class="row-cantidad-jueces">';
        echo '#Jueces Asignados: ' . $rowCount . '';
        echo '</td>';

        echo '<td >';
        echo "<a class='btn' href='ver_jueces.php?id_proyecto={$row['id_proyecto']}&nombre={$row['nombre']}'>Asignar</a>";
        echo '</td>';
        echo '</tr>';
      }
      ?>


    </table>
  </div>






  <h1 class="label">Nivel de desarrollo: Inicial</h1>
  <div class="container">
    <table class="general">

      <?php


      // First query
      $sql = 'SELECT r_proyectos.id_proyecto, r_proyectos.nombre, r_categorias.nombre as categoria, r_niveles_desarrollo.nombre as nivel_de_desarrollo 
  FROM r_proyectos 
  LEFT JOIN r_categorias ON r_proyectos.id_proyecto = r_categorias.id_categoria 
  LEFT JOIN r_niveles_desarrollo ON r_proyectos.id_nivel = r_niveles_desarrollo.id_nivel
  LEFT JOIN r_ediciones ON r_ediciones.id_edicion = r_proyectos.id_edicion
  WHERE r_niveles_desarrollo.id_nivel = 2 AND r_ediciones.activa = 1 AND r_proyectos.estatus = true;';

      $q = $pdo->prepare($sql);
      $q->execute(array());

      // Loop through the results
      foreach ($q as $row) {
        echo '<tr >';
        echo '<td class="row-nombre-proyecto">';
        echo '<a >' . $row['nombre'] . '</a>';
        echo '</td>';


        echo '<td class="row-etiqueta">';

        // Second query
        $sql2 = "SELECT r_jueces.nombre, r_jueces.apellidoP ,r_jueces.apellidoM, r_proyectos.id_proyecto  
    FROM r_jueces 
    LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
    LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
    WHERE r_proyectos.id_proyecto = ?";

        $stmt = $pdo->prepare($sql2);
        $stmt->execute([$row['id_proyecto']]); // Bind the parameter with the value
        $rowCount = $stmt->rowCount();


        if ($row['categoria'] == 'Computacion') {
          echo '<a class="categoria-compu" href="edicion_de_expo_editar.html">' . $row['categoria'] . '</a>';
        } else if ($row['categoria'] == 'Bio') {
          echo '<a class="categoria-bio" href="edicion_de_expo_editar.html">' . $row['categoria'] . '</a>';
        } else if ($row['categoria'] == 'Ciencias Naturales') {
          echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">' . $row['categoria'] . '</a>';
        } else {
          echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">Sin Categoria</a>';
        }
        echo '</td>';


        echo '<td class="row-cantidad-jueces">';
        echo '#Jueces Asignados: ' . $rowCount . '';
        echo '</td>';

        echo '<td >';
        echo "<a class='btn' href='ver_jueces.php?id_proyecto={$row['id_proyecto']}&nombre={$row['nombre']}'>Asignar</a>";
        echo '</td>';
        echo '</tr>';
      }
      ?>


    </table>
  </div>





  <h1 class="label">Nivel de desarrollo: Desarrollo Completo</h1>
  <div class="container">
    <table class="general">

      <?php


      // First query
      $sql = 'SELECT r_proyectos.id_proyecto, r_proyectos.nombre, r_categorias.nombre as categoria, r_niveles_desarrollo.nombre as nivel_de_desarrollo 
  FROM r_proyectos 
  LEFT JOIN r_categorias ON r_proyectos.id_proyecto = r_categorias.id_categoria 
  LEFT JOIN r_niveles_desarrollo ON r_proyectos.id_nivel = r_niveles_desarrollo.id_nivel
  LEFT JOIN r_ediciones ON r_ediciones.id_edicion = r_proyectos.id_edicion
  WHERE r_niveles_desarrollo.id_nivel = 3 AND r_ediciones.activa = 1 AND r_proyectos.estatus = true';

      $q = $pdo->prepare($sql);
      $q->execute(array());

      // Loop through the results
      foreach ($q as $row) {
        echo '<tr >';
        echo '<td class="row-nombre-proyecto">';
        echo '<a >' . $row['nombre'] . '</a>';
        echo '</td>';


        echo '<td class="row-etiqueta">';

        // Second query
        $sql2 = "SELECT r_jueces.nombre, r_jueces.apellidoP ,r_jueces.apellidoM, r_proyectos.id_proyecto  
    FROM r_jueces 
    LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
    LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
    WHERE r_proyectos.id_proyecto = ?";

        $stmt = $pdo->prepare($sql2);
        $stmt->execute([$row['id_proyecto']]); // Bind the parameter with the value
        $rowCount = $stmt->rowCount();


        if ($row['categoria'] == 'Computacion') {
          echo '<a class="categoria-compu" href="edicion_de_expo_editar.html">' . $row['categoria'] . '</a>';
        } else if ($row['categoria'] == 'Bio') {
          echo '<a class="categoria-bio" href="edicion_de_expo_editar.html">' . $row['categoria'] . '</a>';
        } else if ($row['categoria'] == 'Ciencias Naturales') {
          echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">' . $row['categoria'] . '</a>';
        } else {
          echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">Sin Categoria</a>';
        }
        echo '</td>';


        echo '<td class="row-cantidad-jueces">';
        echo '#Jueces Asignados: ' . $rowCount . '';
        echo '</td>';

        echo '<td >';
        echo "<a class='btn' href='ver_jueces.php?id_proyecto={$row['id_proyecto']}&nombre={$row['nombre']}'>Asignar</a>";
        echo '</td>';
        echo '</tr>';
        Database::disconnect();
      }
      ?>


    </table>
  </div>
  <article></article>
  <div id="footer"></div>

</body>

</html>