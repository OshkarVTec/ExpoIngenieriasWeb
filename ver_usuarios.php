<?php
session_start();
if (!($_SESSION['admin'] != null))
  header("Location:informativa.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ver usuarios</title>
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

  <div id="instrucciones-editar-usuario">
    <h1 class="label">Ver Usuarios </h1>
    <h5 id="texto-instruciones">
      Selecciona para eliminar o editar el rol de un usuario.
    </h5>


    <nav class="pruebaZ">
      <div class="dropdown">
        <button class="dropbtn">
          <h2>Filtrar &#9660;</h2>
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="?orderby=admin">Mostrar administradores</a>
          <a href="?orderby=estudiante">Mostrar estudiantes</a>
          <a href="?orderby=docente">Mostrar docentes</a>
          <a href="?orderby=juez">Mostrar jueces</a>
          <a href="?orderby=juez-docente">Mostrar jueces-docentes</a>
          <a href="?default">Mostrar todos</a>
        </div>
      </div>
    </nav>
  </div>


  <div class="container">
    <table class="general">

      <tr>
        <th class="id-column">ID usuario</th>
        <th class="email-column">Correo</th>
        <th class="rol-column">Rol</th>
        <th class="row-editar"></th>
        <th class="row-eliminar"></th>
      </tr>



      <?php
      // echo 'Hola mundoo';
      include 'database.php';
      $pdo = Database::connect();


      // Check if orderby parameter is set
      if (isset($_GET['orderby'])) {
        // Determine column to order by based on value of orderby
        switch ($_GET['orderby']) {
          case 'docente':
            $sql = "SELECT r_usuarios.id_usuario, r_usuarios.correo FROM r_usuarios
                      LEFT JOIN r_docentes ON r_usuarios.id_usuario = r_docentes.id_usuario
                      LEFT JOIN r_jueces ON r_usuarios.id_usuario = r_jueces.id_usuario
                      WHERE r_docentes.id_usuario IS NOT NULL AND r_jueces.id_usuario IS NULL
                      ORDER BY r_docentes.id_usuario";

            break;
          case 'estudiante':
            $sql = "SELECT r_usuarios.id_usuario, r_usuarios.correo FROM r_usuarios
                      LEFT JOIN r_estudiantes ON r_usuarios.id_usuario = r_estudiantes.id_usuario
                      WHERE r_estudiantes.id_usuario IS NOT NULL
                      ORDER BY r_estudiantes.id_usuario";

            break;
          case 'admin':
            $sql = "SELECT  r_usuarios.id_usuario, r_usuarios.correo FROM r_usuarios
                      LEFT JOIN r_administradores ON r_usuarios.id_usuario = r_administradores.id_usuario
                      WHERE r_administradores.id_usuario IS NOT NULL
                      ORDER BY r_administradores.id_usuario";
            break;
          case 'juez':
            $sql = "SELECT r_usuarios.id_usuario, r_usuarios.correo, r_jueces.id_juez FROM r_usuarios
                      LEFT JOIN r_docentes ON r_usuarios.id_usuario = r_docentes.id_usuario
                      LEFT JOIN r_jueces ON r_usuarios.id_usuario = r_jueces.id_usuario
                      WHERE r_jueces.id_usuario IS NOT NULL AND r_docentes.id_usuario IS NULL
                      ORDER BY r_jueces.id_usuario";
            break;
          case 'juez-docente':
            $sql = 'SELECT r_usuarios.id_usuario, r_usuarios.correo 
                FROM r_usuarios
                LEFT JOIN r_docentes ON r_usuarios.id_usuario = r_docentes.id_usuario
                LEFT JOIN r_jueces ON r_usuarios.id_usuario = r_jueces.id_usuario
                WHERE r_docentes.id_usuario IS NOT NULL AND r_jueces.id_usuario IS NOT NULL
                ORDER BY r_usuarios.id_usuario';

            break;
          default:
            $sql = 'SELECT * FROM r_usuarios ORDER BY id_usuario';
        }

      } else {
        $sql = 'SELECT * FROM r_usuarios ORDER BY id_usuario';
      }


      foreach ($pdo->query($sql) as $row) {
        $id_usuario = $row['id_usuario'];

        // echo 'hola';
        // echo $id_usuario;
      

        // Check if the user is a Maestro
        $sql_maestro = "SELECT * FROM r_docentes WHERE id_usuario = ?";
        $stmt_maestro = $pdo->prepare($sql_maestro);
        $stmt_maestro->execute([$id_usuario]);
        $row_maestro = $stmt_maestro->fetch(PDO::FETCH_ASSOC);
        // echo $row_maestro;
        $checked_maestro = $row_maestro ? 'checked' : '';

        // Check if the user is a Juez
        $sql_juez = "SELECT * FROM r_jueces WHERE id_usuario = ?";
        $stmt_juez = $pdo->prepare($sql_juez);
        $stmt_juez->execute([$id_usuario]);
        $row_juez = $stmt_juez->fetch(PDO::FETCH_ASSOC);
        $checked_juez = $row_juez ? 'checked' : '';

        // if(isset($row_juez)){
        //   $isJuez = true;
        // }else{
        //   $isJuez = false;
        // }
      
        // Check if the user is an Administrador
        $sql_administrador = "SELECT * FROM r_administradores WHERE id_usuario = ?";
        $stmt_administrador = $pdo->prepare($sql_administrador);
        $stmt_administrador->execute([$id_usuario]);
        $row_administrador = $stmt_administrador->fetch(PDO::FETCH_ASSOC);
        $checked_administrador = $row_administrador ? 'checked' : '';

        // Check if the user is an Estudiante
        $sql_estudiante = "SELECT * FROM r_estudiantes WHERE id_usuario = ?";
        $stmt_estudiante = $pdo->prepare($sql_estudiante);
        $stmt_estudiante->execute([$id_usuario]);
        $row_estudiante = $stmt_estudiante->fetch(PDO::FETCH_ASSOC);
        $checked_estudiante = $row_estudiante ? 'checked' : '';

        if ($row_maestro && $row_juez) {

          $rol = 'Juez-Docente';

        } elseif ($row_maestro) {
          $rol = 'Docente';
        } elseif ($row_juez) {
          $rol = 'Juez';
        } elseif ($row_administrador) {
          $rol = 'Administrador';
        } elseif ($row_estudiante) {
          $rol = 'Estudiante';
        } else {
          $rol = 'Sin Asignar';
        }




        // echo 'Hola';
        if (isset($row['id_juez'])) {
          echo $row['id_juez'];
        }





        echo '<tr>';


        echo '<td class="id-column">';
        echo $id_usuario;
        echo '</td>';





        // echo '<td class="email-column"><a class="link-edicion">'.$row['correo'].'</a></td>';
      

        echo '<td class="email-column">';
        echo '<pre><a class="rol-edicion">' . $row['correo'] . '  </a></pre>';
        echo '</td>';

        echo '<td class="rol-column">';
        echo '<pre>' . $rol . ' </pre>';
        echo '</td>';


        // if($rol != 'Administrador'){
        //   echo '<td class="row-eliminar">';
        //   echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario='.$id_usuario.'" 
        //   onclick="return confirm(\'¿Estás seguro que deseas eliminar a este usuario?\')">Eliminar</a>';
        //   echo '</td>';   
        // }
      
        if ($rol == 'Juez' || $rol == 'Juez-Docente') {

          // First query to retrieve 'id_juez'
          $sql_informacion_juez = "SELECT r_jueces.id_juez 
              FROM r_jueces
              WHERE r_jueces.id_usuario = ?";

          $stmt = $pdo->prepare($sql_informacion_juez);
          $stmt->execute([$row['id_usuario']]); // Bind the parameter with the value
          $row_juez = $stmt->fetch(PDO::FETCH_ASSOC);

          //Contar cantidad de proyectos que un juez en particular ha calificado
          $sql_cantidad_calificaciones = "SELECT r_jueces.nombre, r_jueces.apellidoP, r_jueces.apellidoM, r_jueces.id_juez 
              FROM r_jueces 
              LEFT JOIN r_calificaciones ON r_jueces.id_juez = r_calificaciones.id_juez 
              WHERE r_calificaciones.id_juez = ?";


          $stmt = $pdo->prepare($sql_cantidad_calificaciones);
          $stmt->execute([$row_juez['id_juez']]); // Bind the parameter with the value
          $rowCount = $stmt->rowCount();


          // echo $rowCount;
      
          if ($rowCount > 0) {
            echo '<td class="row-eliminar">';
            echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario=' . $id_usuario . '" 
                onclick="return confirm(\'Este juez ha calificado ' . $rowCount . ' proyecto(s), si lo eliminas borrarás sus calificaciones asignadas a otros proyectos. ¿Deseas continuar?\')">Eliminar**</a>';
            echo '</td>';
          } else {
            echo '<td class="row-eliminar">';
            echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario=' . $id_usuario . '" 
                onclick="return confirm(\'¿Esta acción es irreversible, deseas continuar?\')">Eliminar</a>';
            echo '</td>';
          }



        }


        if ($rol == 'Docente') {

          // First query to retrieve 'id_docente'
          $sql_informacion_juez = "SELECT r_docentes.id_docente 
              FROM r_docentes
              WHERE r_docentes.id_usuario = ?";

          $stmt = $pdo->prepare($sql_informacion_juez);
          $stmt->execute([$row['id_usuario']]); // Bind the parameter with the value
          $row_juez = $stmt->fetch(PDO::FETCH_ASSOC);

          //Contar cantidad de proyectos a los que un docente esta vinculado
          $sql_cantidad_calificaciones = "SELECT r_docentes.nombre, r_docentes.apellidoP, r_docentes.apellidoM, r_docentes.id_docente 
              FROM r_docentes 
              LEFT JOIN r_proyectos ON r_docentes.id_docente = r_proyectos.id_docente 
              WHERE r_proyectos.id_docente = ?";

          $stmt = $pdo->prepare($sql_cantidad_calificaciones);
          $stmt->execute([$row_juez['id_docente']]); // Bind the parameter with the value
          $rowCount = $stmt->rowCount();

          // echo $rowCount;
      
          if ($rowCount > 0) {
            echo '<td class="row-eliminar">';
            echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario=' . $id_usuario . '" 
                onclick="return confirm(\'Este docente ha sido asignado a ' . $rowCount . ' proyecto(s), si lo eliminas borrarás todos los proyectos vinculados así como las calificaciones de los mismos. ¿Deseas continuar?\')">Eliminar**</a>';
            echo '</td>';
          } else {
            echo '<td class="row-eliminar">';
            echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario=' . $id_usuario . '" 
                onclick="return confirm(\'¿Esta acción es irreversible, deseas continuar?\')">Eliminar</a>';
            echo '</td>';
          }
        }


        if ($rol == 'Estudiante') {

          // First query to retrieve 'matricula'
          $sql_informacion_juez = "SELECT r_estudiantes.matricula 
              FROM r_estudiantes
              WHERE r_estudiantes.id_usuario = ?";

          $stmt = $pdo->prepare($sql_informacion_juez);
          $stmt->execute([$row['id_usuario']]); // Bind the parameter with the value
          $row_juez = $stmt->fetch(PDO::FETCH_ASSOC);

          //Contar cantidad de proyectos a los que un estudiante esta vinculado
          $sql_cantidad_calificaciones = "SELECT  r_estudiantes.matricula 
              FROM r_estudiantes LEFT JOIN r_proyecto_estudiantes ON r_estudiantes.matricula = r_proyecto_estudiantes.matricula 
              WHERE r_proyecto_estudiantes.matricula = ?";


          $stmt = $pdo->prepare($sql_cantidad_calificaciones);
          $stmt->execute([$row_juez['matricula']]); // Bind the parameter with the value
          $rowCount = $stmt->rowCount();

          // echo $rowCount;
      
          if ($rowCount > 0) {
            echo '<td class="row-eliminar">';
            echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario=' . $id_usuario . '" 
                onclick="return confirm(\'Este alumno ha sido asignado a ' . $rowCount . ' proyecto(s), eliminarlo resulta en una acción muy disruptiva ¿Estás completamente seguro de que deseas continuar?\')">Eliminar**</a>';
            echo '</td>';
          } else {
            echo '<td class="row-eliminar">';
            echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario=' . $id_usuario . '" 
                onclick="return confirm(\'¿Esta acción es irreversible, deseas continuar?\')">Eliminar</a>';
            echo '</td>';
          }
        }


        if ($rol == 'Sin Asignar') {
          echo '<td class="row-eliminar">';
          echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario=' . $id_usuario . '" 
              onclick="return confirm(\'¿Esta acción es irreversible, deseas continuar?\')">Eliminar</a>';
          echo '</td>';
        }


        if ($rol != 'Administrador' && $rol != 'Estudiante' && $rol != 'Juez' && $rol != 'Juez-Docente') {
          echo '<td class="row-editar">';
          echo '<a class="btn" href="editar_usuarios.php?id_usuario=' . $id_usuario . '&rol=' . $rol . '">Editar Rol</a>';
          echo '</td>';

        }

        if ($rol == 'Administrador' || $rol == 'Estudiante' || $rol == 'Juez' || $rol == 'Juez-Docente') {
          echo '<td class="row-editar">';
          // echo '<a   class="btn-vacio"></a>';
          echo '</td>';

        }

        if ($rol == 'Administrador') {
          echo '<td class="row-eliminar">';
          // echo '<a   class="btn-vacio"></a>';
          echo '</td>';

        }




        echo '</tr>';

      }

      ?>


    </table>
  </div>
  <article></article>
  <div id="footer"></div>

</body>

</html>s