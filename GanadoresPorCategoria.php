<?php
session_start();
if ($_SESSION['admin'] != null)
  $id_juez = $_SESSION['admin'];
else
  header("Location:informativa.php");
include 'database.php';
if (isset($_POST['submit'])) {
  $pdo = Database::connect();
  $id_proyectos = $_POST['id_proyectos'];
  $premio = $_POST['premio'];
  foreach ($premio as $index => $value) {
    echo $premio[$index];
    echo $id_proyectos[$index];
    $sql = "UPDATE r_proyectos SET premio=? WHERE id_proyecto=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($premio[$index], $id_proyectos[$index]));
  }
  Database::disconnect();
  header("Location: GanadoresPorCategoria.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ganadores</title>
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
  <form method="POST" action="GanadoresPorCategoria.php">
    <?php
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
      
      $sql = 'SELECT r_proyectos.*, ROUND(AVG((puntos_rubro1 + puntos_rubro2 + puntos_rubro3 + puntos_rubro4) / 4),1) AS mean_score
FROM r_proyectos
JOIN r_calificaciones ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto WHERE id_nivel = ? AND id_edicion = ?
GROUP BY r_proyectos.id_proyecto
ORDER BY mean_score DESC';
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
        $promedios = 0;
        $i = 1;
        $id_proyecto = $row['id_proyecto'];
        echo '<td class="columna">';
        echo $row['mean_score'];
        echo '<select name="premio[]">';
        echo '<option value="1"' . (($row['premio'] == 1) ? 'selected' : '') . '>Primer lugar</option>';
        echo '<option value="2"' . (($row['premio'] == 2) ? 'selected' : '') . '>Segundo lugar</option>';
        echo '<option value="3"' . (($row['premio'] == 3) ? 'selected' : '') . '>Tecer lugar</option>';
        echo '<option value="0"' . (($row['premio'] != 1 && $row['premio'] != 2 && $row['premio'] != 3) ? 'selected' : '') . '>No ganador</option>';
        echo '</select>';
        echo '<input type="hidden" name="id_proyectos[]" value=' . $id_proyecto . '>';
        echo '</td>';
        echo '</tr>';
      }
      echo '</table>';
      echo '</div>';
    }
    Database::disconnect();
    ?>

    <div class=''>
      <button id="nueva-edicion-btn" class="btn" type="submit" name="submit">Guardar</button>
    </div>
    <br>
  </form>

  <article></article>
  <div id="footer"></div>


</body>

</html>