<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar usuarios</title>
    <link rel="stylesheet" href="CSS/style.css" />
  </head>
  <body>
    <header class="header">
      <a href="#" class="btn"><button>Log In</button></a>
    </header>

    <div id="instrucciones-editar-usuario">
      <h1 class="label">Usuarios aprobados</h1>
      <h5 id="texto-instruciones">
        Selecciona para aprobar y da clic en Guardar para registrar los cambios
      </h5>




    <nav class="pruebaZ">
      <div class="dropdown">
        <button class="dropbtn">
          <h2>Filtrar</h2>
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="?orderby=docente">Ordenar por docente</a>
          <a href="?orderby=estudiante">Ordenar por alumno</a>
          <a href="?orderby=admin">Ordenar por admin</a>
          <a href="?orderby=juez">Ordenar por juez</a>
          <a href="?default">Ordenar default</a>
        </div>
    </nav>
    </div>




    <div class="container">
      <table class="general">



        <?php
        // echo 'Hola mundoo';
        include 'database.php';
        $pdo = Database::connect();


          // Check if orderby parameter is set
        if (isset($_GET['orderby'])) {
          // Determine column to order by based on value of orderby
          switch ($_GET['orderby']) {
            case 'docente':
              
              $orderby = 'r_docentes.id_docente';
              break;
            case 'estudiante':
              $orderby = 'r_estudiantes.id_usuario';
              break;
            case 'admin':
              $tabla = 'r_administradores';
              $orderby = 'id_usuario';
              break;
            case 'juez':
              $orderby = 'r_jueces.id_usuario';
              break;
            default:
              $orderby = 'id_usuario';
          }

          // $sql = "SELECT * FROM r_usuarios
          //         LEFT JOIN r_docentes ON r_usuarios.id_usuario = r_docentes.id_usuario
          //         LEFT JOIN r_estudiantes ON r_usuarios.id_usuario = r_estudiantes.id_usuario
          //         LEFT JOIN r_jueces ON r_usuarios.id_usuario = r_jueces.id_usuario
          //         LEFT JOIN r_administradores ON r_usuarios.id_usuario = r_administradores.id_usuario
          //         ORDER BY $orderby";
          $sql = 'SELECT * FROM $tabla ORDER BY $orderby';
        } else {
          // If orderby parameter is not set, order by id_usuario by default
          $sql = 'SELECT * FROM r_usuarios ORDER BY id_usuario';
        }


        // $sql = 'SELECT * FROM r_usuarios ORDER BY id_usuario';



        foreach ($pdo->query($sql) as $row) {
          $id_usuario = $row['id_usuario'];



          // $sql = 'SELECT r_usuarios.id_usuario, r_usuarios.correo, r_docentes.id_usuario AS docente_id, r_estudiantes.id_usuario AS estudiante_id, r_jueces.id_usuario AS juez_id, r_administradores.id_usuario AS admin_id FROM r_usuarios 
          //         LEFT JOIN r_docentes ON r_usuarios.id_usuario = r_docentes.id_usuario 
          //         LEFT JOIN r_estudiantes ON r_usuarios.id_usuario = r_estudiantes.id_usuario 
          //         LEFT JOIN r_jueces ON r_usuarios.id_usuario = r_jueces.id_usuario 
          //         LEFT JOIN r_administradores ON r_usuarios.id_usuario = r_administradores.id_usuario 
          //         ORDER BY r_usuarios.id_usuario';

            // Check if the user is a Maestro
            $sql_maestro = "SELECT * FROM r_docentes WHERE id_usuario = ?";
            $stmt_maestro = $pdo->prepare($sql_maestro);
            $stmt_maestro->execute([$id_usuario]);
            $row_maestro = $stmt_maestro->fetch(PDO::FETCH_ASSOC);
            $checked_maestro = $row_maestro ? 'checked' : '';

            // Check if the user is a Juez
            $sql_juez = "SELECT * FROM r_jueces WHERE id_usuario = ?";
            $stmt_juez = $pdo->prepare($sql_juez);
            $stmt_juez->execute([$id_usuario]);
            $row_juez = $stmt_juez->fetch(PDO::FETCH_ASSOC);
            $checked_juez = $row_juez ? 'checked' : '';

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



            echo '<tr>';


            echo '<td class="id-column">';
            echo $id_usuario;
            echo '</td>';

            echo '<td class="email-column"><a class="link-edicion">'.$row['correo'].'</a></td>';
            echo '<td>';
            echo '<input type="checkbox" id="Maestro" name="Maestro"'.$checked_maestro.' />';
            echo '<label for="Maestro">Maestro</label>';
            echo '</td>';
            

            echo '<td>';
            echo '<input type="checkbox" id="Juez" name="Juez"'.$checked_juez.' />';
            echo '<label for="Juez">Juez</label>';
            echo '</td>';

            echo '<td>';
            echo '<input type="checkbox" id="Administrador" name="Administrador"'.$checked_administrador.' />';
            echo '<label for="Administrador">Administrador</label>';
            echo '</td>';

            echo '<td>';
            echo '<input type="checkbox" id="Estudiante" name="Estudiante"'.$checked_estudiante.' />';
            echo '<label for="Estudiante">Estudiante</label>';
            echo '</td>';

            echo '</tr>';

        }

      ?>



      </table>
    </div>
    <button id="nueva-edicion-btn" class="btn">Guardar</button>

    <!-- <h1 class="label">Administradores</h1>

    <div class="container">
      <table></table>
    </div>

    <h1 class="label">Alumnos</h1>

    <div class="container">
      <table></table>
    </div>

    <h1 class="label">Docentes</h1>

    <div class="container">
      <table></table>
    </div>

    <h1 class="label">Jueces</h1>

    <div class="container">
      <table></table>
    </div> -->


    
  </body>
</html>
