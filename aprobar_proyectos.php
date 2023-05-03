<?php
session_start();
if ($_SESSION['id_docente'] != null)
   $id_juez = $_SESSION['id_docente'];
else
   header("Location:informativa.php");

require 'database.php';
if (!empty($_POST)) {
   $id_proyecto = $_POST['id'];
   if (isset($_POST['aprobar'])) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE r_proyectos 
                  SET estatus = 1
                  WHERE id_proyecto = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($id_proyecto));
      Database::disconnect();
   } else if (isset($_POST['rechazar'])) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "DELETE FROM r_proyectos 
                  WHERE id_proyecto = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($id_proyecto));
      Database::disconnect();
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Aprobar proyectos</title>
   <link rel="stylesheet" href="CSS/style.css">
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
   <div id="header"></div>
   <h1 class="label">Por aprobar</h1>
   <p class="label">En caso de rechazar un proyecto, este se eliminará. Para pedir cambios al proyecto antes de
      aprobarlos por favor contacte a los estudiantes directamente.</p>
   <div class="container">
      <table class="general">
         <?php
         $pdo = Database::connect();
         $sql = 'SELECT *  FROM r_proyectos WHERE id_docente = ? AND estatus = 0';
         $q = $pdo->prepare($sql);
         $q->execute(array($id_docente));
         $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);
         foreach ($proyectos as $row) {
            echo '<tr>';
            echo '<td>';
            echo '<a class="link" href="proyecto.php?id=' . $row['id_proyecto'] . '">' . $row['nombre'] . '</a>';
            echo '</td>';
            echo '<td class = "two_objects_column">';
            echo '<form method = "POST" action = "aprobar_proyectos.php">';
            echo '<input type="hidden" name="id" value="' . $row['id_proyecto'] . '" />';
            echo '<input value="Aprobar" type="submit" class = "btn" name="aprobar"/>';
            echo '<input value="Rechazar" type="submit" class = "btn" name="rechazar"/>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
         }
         Database::disconnect();
         ?>
      </table>
   </div>

   <h1 class="label">Aprobados</h1>
   <div class="container">
      <table class="general">
         <?php
         $pdo = Database::connect();
         $sql = 'SELECT *  FROM r_proyectos WHERE id_docente = ? AND estatus = 1';
         $q = $pdo->prepare($sql);
         $q->execute(array($id_docente));
         $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);
         foreach ($proyectos as $row) {
            echo '<tr>';
            echo '<td>';
            echo '<a class="link" href="proyecto.php?id=' . $row['id_proyecto'] . '">' . $row['nombre'] . '</a>';
            echo '</td>';
            echo '</tr>';
         }
         Database::disconnect();
         ?>
      </table>
   </div>
</body>

</html>