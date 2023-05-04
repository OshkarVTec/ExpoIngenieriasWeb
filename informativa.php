<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Informativa</title>
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
      } else {
        echo '"header_login.html"';
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

    <?php
    require 'database.php';
    $pdo = Database::connect();
    $sql = "SELECT * FROM r_anuncios WHERE vigente = 1";
    $stmt = $pdo->query($sql);
    $anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($anuncios as $anuncio) {
      //echo '<div class="mySlides fade">';
      echo '<tr>';
      echo '<div>';
      echo '<p>' . $anuncio['contenido'] . '</p>';
      echo '</div>';
      echo '<img src="' . $anuncio['multimedia'] . '">';
      echo '</tr>';
    }
    ?>
  </div>
  <article></article>
  <div id="footer"></div>

</body>

</html>