<?php
session_start();
if (!($_SESSION['juez'] != null || $_SESSION['admin'] != null || $_SESSION['docente'] != null))
   header("Location:informativa.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ver proyectos</title>
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
   $sql = 'SELECT * FROM r_niveles_desarrollo ORDER BY id_nivel';
   foreach ($pdo->query($sql) as $row) {
      echo '<h1 class="label">Nivel de desarrollo: ' . $row['nombre'] . '</h1>';
      $sql = 'SELECT COUNT(id_proyecto) FROM r_proyectos WHERE id_nivel = ? AND id_edicion = ? AND estatus = true';
      $q = $pdo->prepare($sql);
      $q->execute(array($row['id_nivel'], $id_edicion));
      $aprobados = $q->fetchColumn();
      $sql = 'SELECT COUNT(id_proyecto) FROM r_proyectos WHERE id_nivel = ? AND id_edicion = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($row['id_nivel'], $id_edicion));
      $total = $q->fetchColumn();
      echo '<h1 class="label">Número de aprobados: ' . $aprobados . '/' . $total . '</h1>';
      echo '<div class = "container">';
      echo '<table class="general">';
      $sql = 'SELECT * FROM r_proyectos WHERE id_nivel = ? AND id_edicion = ? ORDER BY estatus DESC';
      $q = $pdo->prepare($sql);
      $q->execute(array($row['id_nivel'], $id_edicion));
      $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);
      foreach ($proyectos as $row) {
         echo '<tr>';
         echo '<td class="row-nombre-proyecto">';
         echo '<a class="link" href="proyecto.php?id_proyecto=' . $row['id_proyecto'] . '">' . $row['nombre'] . '</a>';
         echo '</td>';
         echo '<td>';
         echo '<p>' . (($row['estatus'] == true) ? 'Aprobado' : 'No aprobado') . '</p>';
         echo '</td>';
         $sql = 'SELECT * FROM r_categorias WHERE id_categoria = ?';
         $q = $pdo->prepare($sql);
         $q->execute(array($row['id_categoria']));
         $categoria = $q->fetch(PDO::FETCH_ASSOC);
         echo '<td>';
         echo '<p>' . $categoria['nombre'] . '</p>';
         echo '</td>';
         echo '</tr>';
      }
      echo '</table>';
      echo '</div>';
   }
   Database::disconnect();
   ?>
   <article></article>
   <div id="footer"></div>
</body>

</html>