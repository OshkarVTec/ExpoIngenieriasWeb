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
  <title>Edicion de expo vista</title>
  <link rel="stylesheet" href="CSS/style.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script>
    $(function () {
      $("#header").load(<?php
      if ($_SESSION['estudiante'] != null) {
        echo '"header_estudiante.php"';
      } else if ($_SESSION['admin'] != null) {
        echo '"header_admin.php"';
      } else if ($_SESSION['juez'] != null) {
        if ($_SESSION['docente'] != null)
          echo '"header_juez.php"';
        else
          echo '"header_docente_juez.php"';
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
  <header class="header">
    <div class="logo">
      <a href="informativa_presentacion.html">
        <img src="IMG/logo-expo.png" alt="Logo de la pagina" />
      </a>
    </div>
    <a href="#" class="btn"><button>Log In</button></a>
  </header>
  <h1 class="label">Edición de la Expo</h1>
  <div class="container">
    <table class="general">

      <?php
      // echo 'Hola mundoo';
      include 'database.php';
      $pdo = Database::connect();

      // if($pdo){
      //   echo 'Conexion exitosaaa';
      // }
      $sql = 'SELECT * FROM r_ediciones ORDER BY activa, id_edicion';
      foreach ($pdo->query($sql) as $row) {
        if ($row['activa'] == 0) {
          $estado = 'Inactivo';
        } else {
          $estado = 'Activo';
        }
        echo '<tr>';
        echo '<td><a class="link-edicion" href="proyecto.html">' . $row['nombre'] . '</a></td>';
        echo '<td class="two_objects_column">';
        echo '<div>' . $estado . '</div>';
        echo '<a class="btn" href="edicion_de_expo_editar.php?id_edicion=' . $row['id_edicion'] . '">Editar</a>';
        echo '</td>';
        echo '</tr>';

      }

      ?>


      <!-- <button class="btn">AD2023</button> -->
      <!-- <tr>
          <td><a class="link" href="proyecto.html">FJ2023</a></td>
          <td class="two_objects_column">
            <div>Inactivo</div>
            <a class="btn" href="edicion_de_expo_editar.html">Editar</a>
          </td>
        </tr>
        <tr>
          <td><a class="link" href="proyecto.html">AD2023</a></td>
          <td class="two_objects_column">
            <div>Inactivo</div>
            <a class="btn" href="edicion_de_expo_editar.html">Editar</a>
          </td>
        </tr>
        <tr>
          <td><a class="link" href="proyecto.html">FJ2024</a></td>
          <td class="two_objects_column">
            <div>Inactivo</div>
            <a class="btn" href="edicion_de_expo_editar.html">Editar</a>
          </td>
        </tr>
        <tr>
          <td><a class="link" href="proyecto.html">JD2024</a></td>
          <td class="two_objects_column">
            <div>Activo</div>
            <a class="btn" href="edicion_de_expo_editar.html">Editar</a>
          </td>
        </tr> -->
    </table>
  </div>
  <a href="edicion_de_expo_crear.php"><button id="nueva-edicion-btn" class="btn">Nueva edición</button></a>
</body>

</html>