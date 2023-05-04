<?php
session_start();
if ($_SESSION['admin'] != null)
  $id_admin = $_SESSION['admin'];
else
  header("Location:informativa.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edición de expo editar</title>
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
  include 'database.php';
  $pdo = Database::connect();
  $sql = 'SELECT *  FROM r_ediciones WHERE activa = 1';
  $q = $pdo->prepare($sql);
  $q->execute();
  $id_edicion = $q->fetch(PDO::FETCH_ASSOC)['id_edicion'];

  // Get the ID from the query string
  $id_usuario = $_GET['id_usuario'];

  //Get Rol
  $rol = $_GET['rol'];


  // Query the database for the user's details
  $sql = "SELECT * FROM r_usuarios WHERE id_usuario = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id_usuario]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Display the user's details
  // echo '<h1>Editar usuario</h1>';
  // echo '<p>ID de usuario: ' . $row['id_usuario'] . '</p>';
  // echo '<p>Correo: ' . $row['correo'] . '</p>';
  // echo $rol;
  
  if ($rol == 'Juez-Docente') {
    $checked_maestro = 'checked';
    $checked_juez = 'checked';
    $checked_administrador = ($rol == 'Administrador') ? 'checked' : '';
    $checked_estudiante = ($rol == 'Estudiante') ? 'checked' : '';
  } else {
    $checked_maestro = ($rol == 'Docente') ? 'checked' : '';
    $checked_juez = ($rol == 'Juez') ? 'checked' : '';
    $checked_administrador = ($rol == 'Administrador') ? 'checked' : '';
    $checked_estudiante = ($rol == 'Estudiante') ? 'checked' : '';
  }

  // Handle form submission
  if (isset($_POST['submit'])) {
    // Get the selected roles
    $roles = isset($_POST['roles']) ? $_POST['roles'] : array();

    // Update the user's roles in the database
    $pdo->beginTransaction();
    try {

      // Add the user to the selected role tables
      foreach ($roles as $role) {
        switch ($role) {
          case 'Administrador':
            $sql = "SELECT * FROM r_administradores WHERE id_usuario = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario]);
            if ($stmt->rowCount() > 0)
              break;
            $pdo->query("INSERT INTO r_administradores (id_usuario) VALUES ($id_usuario)");
            break;
          case 'Docente':
            $sql = "SELECT * FROM r_docentes WHERE id_usuario = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario]);
            if ($stmt->rowCount() > 0)
              break;
            $pdo->query("INSERT INTO r_docentes (id_usuario) VALUES ($id_usuario)");
            break;
          case 'Estudiante':
            $sql = "SELECT * FROM r_estudiantes WHERE id_usuario = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario]);
            if ($stmt->rowCount() > 0)
              break;
            $pdo->query("INSERT INTO r_estudiantes (id_usuario) VALUES ($id_usuario)");
            break;
          case 'Juez':
            $sql = "SELECT * FROM r_jueces WHERE id_usuario = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_usuario]);
            if ($stmt->rowCount() > 0)
              break;
            $pdo->query("INSERT INTO r_jueces (id_usuario, id_edicion) VALUES ($id_usuario,$id_edicion)");
            break;
        }
      }

      // Commit the changes
      $pdo->commit();

      // Redirect to the page that shows the user's details
      header("Location: ver_usuarios.php?");
      exit();
    } catch (Exception $e) {
      // Roll back the transaction and show an error message
      $pdo->rollBack();
      echo "An error occurred while updating the user's roles: " . $e->getMessage();
    }
  }




  echo '<form method="post" action="editar_usuarios.php?id_usuario=' . $id_usuario . '&rol=' . $rol . '">';

  echo '<div id="instrucciones-editar-usuario">';
  echo '<h1 class="label">Editar ' . $rol . '</h1>';
  echo '</div>';



  echo '<div class="container">';
  echo '<table class="general">';


  echo '<td class="id-column">';
  echo $id_usuario;
  echo '</td>';



  echo '<td class="email-column"><a class="link-edicion">' . $row['correo'] . '</a></td>';

  // echo '<td class="row-botones">';
  // echo '<a class="btn" href="editar_usuarios.php?id_usuario=' . $id_usuario . '&rol=' . $rol . '">Editar</a>';
  
  // echo '</td>';
  // if($rol != 'Administrador'){
  //     echo '<td class="row-botones">';
  //     echo '<a class="btn-eliminar" href="borrar_usuario.php?id_usuario='.$id_usuario.'" onclick="return confirm(\'¿Estás seguro que deseas eliminar a este usuario?\')">Eliminar</a>';
  
  //     echo '</td>';   
  // }
  

  if ($rol == 'Docente') {
    echo '<td class="rol" >';
    echo '<input  type="checkbox" value="Docente" name="roles[]"' . $checked_maestro . ' />';
    echo '<label  for="Docente">Docente</label>';
    echo '</td>';




    echo '<td class="rol">';
    echo '<input type="checkbox" value="Juez" name="roles[]"' . $checked_juez . ' />';
    echo '<label for="Juez">Juez</label>';
    echo '</td>';
  }

  if ($rol == 'Sin Asignar') {
    echo '<td class="rol">';
    echo '<input type="checkbox" value="Docente" name="roles[]"' . $checked_maestro . ' />';
    echo '<label for="Docente">Docente</label>';
    echo '</td>';




    echo '<td class="rol">';
    echo '<input type="checkbox" value="Juez" name="roles[]"' . $checked_juez . ' />';
    echo '<label for="Juez">Juez</label>';
    echo '</td>';

    echo '<td class="rol">';
    echo '<input type="checkbox" value="Administrador" name="roles[]"' . $checked_administrador . ' />';
    echo '<label for="Administrador">Administrador</label>';
    echo '</td>';

    echo '<td class="rol">';
    echo '<input type="checkbox" value="Estudiante" name="roles[]"' . $checked_estudiante . ' />';
    echo '<label for="Estudiante">Estudiante</label>';
    echo '</td>';
  }



  // echo '<td class="rol">';
  // echo '<input type="checkbox" id="Docente" name="Docente"'.$checked_maestro.' />';
  // echo '<label for="Docente">Docente</label>';
  // echo '</td>';
  



  // echo '<td class="rol">';
  // echo '<input type="checkbox" id="Juez" name="Juez"'.$checked_juez.' />';
  // echo '<label for="Juez">Juez</label>';
  // echo '</td>';
  
  // echo '<td class="rol">';
  // echo '<input type="checkbox" id="Administrador" name="Administrador"'.$checked_administrador.' />';
  // echo '<label for="Administrador">Administrador</label>';
  // echo '</td>';
  
  // echo '<td class="rol">';
  // echo '<input type="checkbox" id="Estudiante" name="Estudiante"'.$checked_estudiante.' />';
  // echo '<label for="Estudiante">Estudiante</label>';
  // echo '</td>';
  


  echo '</tr>';

  echo '</table>';
  echo '</div>';

  echo '</div>';
  if ($rol == 'Docente' || $rol == 'Sin Asignar') {
    echo '<button id="nueva-edicion-btn" class="btn" type="submit" name="submit">Guardar</button>';
  }


  echo ' </form>';
  ?>


  <article></article>
  <div id="footer"></div>
</body>

</html>