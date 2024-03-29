<?php
session_start();
if (!$_SESSION['admin'])
  header("Location:informativa.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Asignar jueces</title>
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
  $sql = 'SELECT * FROM r_niveles_desarrollo ORDER BY id_nivel';
  foreach ($pdo->query($sql) as $row) {
    echo '<h1 class="label">Nivel de desarrollo: ' . $row['nombre'] . '</h1>';
    echo '<div class = "container">';
    echo '<table class="general">';
    $sql = 'SELECT * FROM r_proyectos WHERE id_nivel = ? AND id_edicion = ? AND r_proyectos.estatus = true';
    $q = $pdo->prepare($sql);
    $q->execute(array($row['id_nivel'], $id_edicion));
    $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);
    foreach ($proyectos as $row) {
      echo '<tr>';
      echo '<td class="row-nombre-proyecto">';
      echo '<a class="link" href="proyecto.php?id_proyecto=' . $row['id_proyecto'] . '">' . $row['nombre'] . '</a>';
      echo '</td>';
      $sql = 'SELECT * FROM r_categorias WHERE id_categoria = ?';
      $q = $pdo->prepare($sql);
      $q->execute(array($row['id_categoria']));
      $categoria = $q->fetch(PDO::FETCH_ASSOC);
      echo '<td>';
      echo '<p>' . $categoria['nombre'] . '</p>';
      echo '</td>';
      $sql2 = "SELECT r_jueces.nombre, r_jueces.apellidoP ,r_jueces.apellidoM, r_proyectos.id_proyecto  
    FROM r_jueces 
    LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
    LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
    WHERE r_proyectos.id_proyecto = ?";

      $stmt = $pdo->prepare($sql2);
      $stmt->execute([$row['id_proyecto']]); // Bind the parameter with the value
      $rowCount = $stmt->rowCount();

      echo '<td class="row-cantidad-jueces">';
      echo '#Jueces Asignados: ' . $rowCount . '';
      echo '</td>';
      echo '<td >';
      echo "<a class='btn' href='ver_jueces.php?id_proyecto={$row['id_proyecto']}&nombre={$row['nombre']}'>Asignar</a>";
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