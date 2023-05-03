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
    $(function(){
      $("#header").load(<?php 
        if($_SESSION['matricula'] != null){
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
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. 
          Iusto incidunt doloribus quia repudiandae error, aliquid aspernatur 
          labore illo veniam inventore velit voluptates ipsa accusantium nulla 
          voluptatum corrupti fugiat ratione? Molestiae.</p>
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
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <!-- </div> -->
      </div>
    </section>

    <script src="js/informativa.js"></script>
  </body>
</html>
