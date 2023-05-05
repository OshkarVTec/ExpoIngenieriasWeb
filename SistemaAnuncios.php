<?php
session_start();
if ($_SESSION['admin'] != null)
   $id_admin = $_SESSION['admin'];
else
   header("Location:informativa.php");
require 'database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="CSS/style.css">
   <title>Anuncios</title>
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
   <h1 class="label">Anuncios</h1>

   <div class="container">
      <table class="general">
         <?php
         $sql = "SELECT r_anuncios.id_anuncio, r_anuncios.contenido FROM r_anuncios";
         $pdo = Database::connect();


         foreach ($pdo->query($sql) as $row) {
            $rol = 'Administrador';
            $id_anuncio = $row['id_anuncio'];
            $contenido = $row['contenido'];
            echo '<tr>';
            echo '<td><p>' . 'Anuncio ' . $row['id_anuncio'] . '</p></td>';
            echo '<td class="tabla">';
            //echo '<td><input type="checkbox" id="Activar"> <label for="Activar">Activar</label>';
            echo '<a class="btn" href="actualizar_anuncio.php?id_anuncio=' . $id_anuncio . '&contenido=' . $contenido . '">Editar</a>';
            echo '<a class="btn-eliminar" href="borrar_anuncio.php?id_anuncio=' . $id_anuncio . '" 
            onclick="return confirm(\'¿Desea eliminar este elemento?\')">Eliminar</a>';
            echo '</td>';

            echo '</tr>';
         }



         ?>
         <tr>
            <td><a class="btn" href="crearAnuncio.php">Nuevo</a></td>
         </tr>
      </table>
   </div>
   <article></article>
   <div id="footer"></div>
</body>

</html>