<?php
session_start();
if ($_SESSION['admin'] != null)
   $id_admin = $_SESSION['admin'];
else
   header("Location:informativa.php");
require 'database.php';
$id_anuncio = null;
if (!empty($_GET['id_anuncio'])) {
   $id_anuncio = $_REQUEST['id_anuncio'];
}
$Error = null;

if (!empty($_POST)) {

   $contenido = $_POST['contenido'];
   $multimedia = $_POST['multimedia'];
   if (isset($_POST['activo']))
      $activo = 1;
   else
      $activo = 0;

   // validate input
   $valid = true;

   if (empty($contenido)) {
      $Error = 'Escriba el contenido del anuncio';
      $valid = false;
   }



   if ($valid) {
      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "UPDATE r_anuncios 
                  SET contenido = ?,  multimedia = ?, vigente = ?
                  WHERE id_anuncio = ?";
      $q = $pdo->prepare($sql);
      $q->execute(array($contenido, $multimedia, $activo, $id_anuncio));
      Database::disconnect();
      header("Location: SistemaAnuncios.php");
   }
} else {
   $pdo = Database::connect();
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $sql = 'SELECT * FROM r_anuncios WHERE id_anuncio = ?';
   $q = $pdo->prepare($sql);
   $q->execute(array($id_anuncio));
   $row = $q->fetch(PDO::FETCH_ASSOC);
   $contenido = $row['contenido'];
   $multimedia = $row['multimedia'];
   $activo = $row['vigente'];
   Database::disconnect();
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
         <form class="login" action="actualizar_anuncio.php?id_anuncio=<?php echo $id_anuncio ?>" method=POST>
            <table>

               <tr>
                  <td><label for="contenido">Anuncio:</label></td>
                  <td><textarea id="comment"
                        name="contenido"><?php echo !empty($contenido) ? $contenido : ''; ?></textarea></td>
               </tr>


               <tr>
                  <td><label for="multimedia">Link de multimedia: </label></td>
                  <td><input type="text" id="linkp" name="multimedia"
                        value="<?php echo !empty($multimedia) ? $multimedia : ''; ?>"></td>
               </tr>
               <tr>
                  <td><label for="activo">Activo</label></td>
                  <td><input type="checkbox" name="activo" value="1" <?php if ($activo): ?> checked<?php endif; ?>></td>
               </tr>
               <tr>


            </table>
            <div>
               <button class="cancel" onclick="history.go(-1);">Cancelar</button>
               <?php
               //               session_start();
//               $pdo = Database::connect();
//               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//               $sql = 'SELECT * FROM r_anuncios WHERE id_anuncio = ?';
//               $q = $pdo->prepare($sql);
//               $q->execute(array($_SESSION['estudiante']));
//               $p_estudiantes = $q->fetch(PDO::FETCH_ASSOC);
//               $proyecto = $p_estudiantes['id_anuncio'];
//
//               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//               $sql = 'SELECT * FROM r_anuncios WHERE id_anuncio = ?';
//               $q = $pdo->prepare($sql);
//               $q->execute(array($proyecto));
//               $row = $q->fetch(PDO::FETCH_ASSOC);
//               $status = $row['estatus'];
//               if ($status == 0) {
//                  echo '<input value="Actualizar" type="submit" class = "btn" id="convert-btn">';
//               }
               
               ?>
               <input value="Actualizar" type="submit" class="btn" id="convert-btn">
            </div>
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