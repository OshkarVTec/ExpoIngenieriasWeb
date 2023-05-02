<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Asignar jueces</title>
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



    <!-- SELECT r_jueces.nombre, r_jueces.apellidoP ,r_jueces.apellidoM, r_proyectos.id_proyecto , r_proyectos.nombre 
    FROM r_jueces 
    LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
    LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
    WHERE r_proyectos.id_proyecto = 3; -->  <!--  INCLUIR ESTA QUERY Y BORRAR LA TABLA QUE HICE AYER -->


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
    WHERE r_niveles_desarrollo.id_nivel = 1;';

  $q = $pdo->prepare($sql);
  $q->execute(array());

  // Loop through the results
  foreach ($q as $row) {
    echo '<tr>';
    echo '<td>';
    echo '<a class="link-edicion">' . $row['nombre'] . '</a>';

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
    echo '#Jueces Asignados: '.$rowCount.'';
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

      $sql = 'SELECT r_proyectos.id_proyecto, r_proyectos.nombre, r_categorias.nombre as categoria, r_niveles_desarrollo.nombre as nivel_de_desarrollo 
      FROM r_proyectos 
      LEFT JOIN r_categorias ON r_proyectos.id_proyecto = r_categorias.id_categoria 
      LEFT JOIN r_niveles_desarrollo ON r_proyectos.id_nivel = r_niveles_desarrollo.id_nivel
      WHERE r_niveles_desarrollo.id_nivel = 2;';

      $q = $pdo->prepare($sql);
      $q->execute(array());
      $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);

      foreach ($proyectos as $row) {
      echo '<tr>';
      echo '<td>';
      echo '<a class="link-edicion">' . $row['nombre'] . '</a>';

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

      echo '<td class="row-cantidad-jueces">';
      echo '#Jueces Asignados: '.$rowCount.'';
      echo '</td>';

      echo '</td>';
      echo '<td >';
      echo "<a class='btn' href='ver_jueces.php?id_proyecto={$row['id_proyecto']}&nombre={$row['nombre']}'>Asignar</a>";
      echo '</td>';
      echo '</tr>';
      }
    ?>

    </table>
    </div>





    <h1 class="label">Nivel de desarrollo: Desarrollo completo</h1>
    <div class="container">
    <table class="general">

    <?php

      $sql = 'SELECT r_proyectos.id_proyecto, r_proyectos.nombre, r_categorias.nombre as categoria, r_niveles_desarrollo.nombre as nivel_de_desarrollo 
      FROM r_proyectos 
      LEFT JOIN r_categorias ON r_proyectos.id_proyecto = r_categorias.id_categoria 
      LEFT JOIN r_niveles_desarrollo ON r_proyectos.id_nivel = r_niveles_desarrollo.id_nivel
      WHERE r_niveles_desarrollo.id_nivel = 3;';

      $q = $pdo->prepare($sql);
      $q->execute(array());
      $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);

      foreach ($proyectos as $row) {
      echo '<tr>';
      echo '<td>';
      echo '<a class="link-edicion">' . $row['nombre'] . '</a>';


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

      echo '<td class="row-cantidad-jueces">';
      echo '#Jueces Asignados: '.$rowCount.'';
      echo '</td>';

      echo '</td>';
      echo '<td>';
      echo "<a class='btn' href='ver_jueces.php?id_proyecto={$row['id_proyecto']}&nombre={$row['nombre']}'>Asignar</a>";
      echo '</td>';
      echo '</tr>';
      }
      Database::disconnect();
    ?>

    </table>
    </div>





    <!-- <a href="edicion_de_expo_crear.php"
      ><button id="nueva-edicion-btn" class="btn">Nueva edición</button></a
    > -->
  </body>
</html>
