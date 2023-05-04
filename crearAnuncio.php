<?php
session_start();
if ($_SESSION['admin'] != null)
   $id_admin = $_SESSION['admin'];
else
   header("Location:informativa.php");
require 'database.php';

$Error = null;

if (!empty($_POST)) {

   $anuncio = $_POST['anuncio'];
   $multimedia = $_POST['multimedia'];
   if (isset($_POST['vigente'])) {
      $vigente = 1;
   } else {
      $vigente = 0;
   }


   // validate input
   $valid = true;

   if (empty($anuncio)) {
      $Error = 'Anuncio vacio';
      $valid = false;
   }

   // insert data
   if ($valid) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO r_anuncios (id_anuncio, contenido, multimedia, vigente) 
                                values (NULL, ?, ?, ?)";

      $q = $pdo->prepare($sql);
      $q->execute(array($anuncio, $multimedia, $vigente));
      Database::disconnect();
      header("Location: SistemaAnuncios.php");
   }
}
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nuevos Anuncios</title>
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
   <div class="ventana">
      <h1 class="label"></h1>
      <div class="container">
         <form class="login" action="crearAnuncio.php" method=POST>
            <table>

               <tr>
                  <td><label for="name">Anuncio:</label></td>
                  <td><textarea type="text" id="title" name="anuncio"
                        value="<?php echo !empty($name) ? $name : ''; ?>"></textarea></td>
               </tr>

               <tr>
                  <td><label for="multimedia">Link multimedia:</label></td>
                  <td><input type="text" id="linkp" name="multimedia" value="<?php echo !empty($poster) ? $poster : ''; ?>">
                  </td>
               </tr>


               <tr>
                  <td><label for="link">Vigente:</label></td>
                  <td><input type="checkbox" name="vigente"></td>


            </table>
            <td><input value="Agregar anuncio" type="submit" class="btn" id="convert-btn"></td>
            <button class="cancel" onclick="history.go(-1);">Cancelar</button>
            <?php if (($Error != null)) ?>
            <div class="Error">
               <?php echo $Error; ?>
            </div>
         </form>
      </div>
   </div>
   <article></article>
   <div id="footer"></div>
</body>

</html>


<script>
  (function ($) {

    var url = $('#linkp'),
      btn = $('#convert-btn');

    btn.on('click', function (event) {
      found = url.val().match(/d\/([A-Za-z0-9_\-]+)/);
      if (found[1].length) {
        new_url = 'https://drive.google.com/uc?export=view&id=' + found[1];
        url.val(new_url);
      }
    });

  })(jQuery);
</script>