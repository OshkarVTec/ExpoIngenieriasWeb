<?php
  echo 'Hola mundoo';
  include 'database.php';
  $pdo = Database::connect();

  if($pdo){
    echo 'Conexion exitosaaa';
  }
  $sql = 'SELECT * FROM r_ediciones ORDER BY id_edicion';
  foreach ($pdo->query($sql) as $row) {
    
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edicion de expo vista</title>
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
    <h1 class="label">Edición de la Expo</h1>
    <div class="container">
      <table class="general">
        <!-- <button class="btn">AD2023</button> -->
        <tr>
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
        </tr>
      </table>
    </div>
    <a href="edicion_de_expo_editar.html"
      ><button id="nueva-edicion-btn" class="btn">Nueva edición</button></a
    >
  </body>
</html>
