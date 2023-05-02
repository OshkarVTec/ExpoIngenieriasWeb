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






    <h1 class="label">Nivel de desarrollo: Idea</h1>
    <div class="container">
    <table class="general">

    <?php



      include 'database.php';
      $pdo = Database::connect();
      $sql = 'SELECT r_proyectos.nombre , r_categorias.nombre as categoria, 
      r_niveles_desarrollo.nombre as nivel_de_desarrollo 
      FROM r_proyectos 
      LEFT JOIN r_categorias ON r_proyectos.id_proyecto = r_categorias.id_categoria 
      LEFT JOIN r_niveles_desarrollo ON r_proyectos.id_nivel = r_niveles_desarrollo.id_nivel
      WHERE r_niveles_desarrollo.id_nivel = 1;';

      $q = $pdo->prepare($sql);
      $q->execute(array());
      $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);
        foreach ($proyectos as $row) {

          echo '<tr>';
          echo '<td>';
          echo '<a class="link-edicion">'.$row['nombre'].'</a>';
          
          if($row['categoria']  == 'Computacion'){
            echo '<a class="categoria-compu" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else if($row['categoria']  == 'Bio'){
            echo '<a class="categoria-bio" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else if($row['categoria']  == 'Ciencias Naturales'){
            echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else{
            echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">Sin Categoria</a>';
          }
        }

    ?>

    </td>
    </table>
    </div>





    <h1 class="label">Nivel de desarrollo: Inicial</h1>
    <div class="container">
    <table class="general">

    <?php


      $sql = 'SELECT r_proyectos.id_proyecto , r_proyectos.nombre , r_categorias.nombre as categoria, 
      r_niveles_desarrollo.nombre as nivel_de_desarrollo 
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
          echo '<a class="link-edicion">'.$row['nombre'].'</a>';
          

          if($row['categoria']  == 'Computacion'){
            echo '<a class="categoria-compu" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else if($row['categoria']  == 'Bio'){
            echo '<a class="categoria-bio" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else if($row['categoria']  == 'Ciencias Naturales'){
            echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else{
            echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">Sin Categoria</a>';
          }
        }


        echo '<td>';

        // echo '<nav>';
        // echo '<div class="dropdown">';
        echo '<a class="btn"  href="ver_jueces.php?id_proyecto=' . $row['id_proyecto'] . '">Asignar</a>';
        // echo '<h2>Filtrar</h2>';
        // echo '<i class="fa fa-caret-down"></i>';
        // echo '</button>';
        // echo '<div class="dropdown-content">';
        // echo '<a href="?orderby=admin">Mostrar </a>';
        // echo '<a href="?orderby=estudiante">Mostrar </a>';
        // echo '<a href="?orderby=docente">Mostrar docentes</a>';
        // echo '<a href="?orderby=juez">Mostrar </a>';
        // echo '<a href="?orderby=juez-docente">Mostrar -</a>';
        // echo '<a href="?default">Mostrar todos</a>';
        // echo '</div>';
        // echo '</div>';
        // echo '</nav>';

        echo '</td>';

        echo '</tr>';

    ?>

    </td>
    </table>
    </div>





    <h1 class="label">Nivel de desarrollo: Desarrollo Completo</h1>
    <div class="container">
    <table class="general">

    <?php

      $sql = 'SELECT r_proyectos.nombre , r_categorias.nombre as categoria, 
      r_niveles_desarrollo.nombre as nivel_de_desarrollo 
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
          echo '<a class="link-edicion">'.$row['nombre'].'</a>';
          
          if($row['categoria']  == 'Computacion'){
            echo '<a class="categoria-compu" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else if($row['categoria']  == 'Bio'){
            echo '<a class="categoria-bio" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else if($row['categoria']  == 'Ciencias Naturales'){
            echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">'.$row['categoria'].'</a>';
          }
          else{
            echo '<a class="categoria-ciencias-n" href="edicion_de_expo_editar.html">Sin Categoria</a>';
          }
        }
      Database::disconnect();
    ?>

    </td>
    </table>
    </div>




    <!-- <a href="edicion_de_expo_crear.php"
      ><button id="nueva-edicion-btn" class="btn">Nueva edición</button></a
    > -->
  </body>
</html>
