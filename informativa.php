

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
      $(function(){
        $("#header").load(<?php 
          if($_SESSION['estudiante'] != null){
              echo '"header_estudiante.php"';
          } else if($_SESSION['admin'] != null){
              echo '"header_admin.php"';
          } else if($_SESSION['juez'] != null){
              echo '"header_juez.php"';
          } else if($_SESSION['docente'] != null){
              echo '"header_docente.php"';
          }
          ?>); 
      });
    </script> 
  </head>
  <body>
    <div id="header"></div>

    <section id="container-informativa">
      <div id="container-seccion-izquierda">
        <h1>Inicia Expoingenierias</h1>
        
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

<?php
//$n = 5;
//for ($i = 1; $i <= $n; $i++) {
  //echo '<span class="dot" onclick="currentSlide(' . $i . ')"></span>';
//}
?>
  
      </div>


      <div id="container-seccion-derecha" class="slideshow-container">
        <div id="container-seccion-derecha-img">
          <div class="mySlides fade">
            <img src="IMG/ingeniero.png" />
          </div>

          <div class="mySlides fade">
            <img src="IMG/imagen2.jpg" />
          </div>

          <div class="mySlides fade">
            <img src="IMG/imagen3.jpg" />
          </div>
        </div>

        <!-- The dots/circles -->
        <!-- <div id="container-seccion-derecha-btnes" style="text-align: center"> -->
        <span class="dot" onclick="currentSlide2(10)"></span>
        <span class="dot" onclick="currentSlide2(11)"></span>
        <span class="dot" onclick="currentSlide2(12)"></span>
        <!-- </div> -->
      </div>
    </section>

    <script src="js/informativa.js"></script>
  </body>
</html>