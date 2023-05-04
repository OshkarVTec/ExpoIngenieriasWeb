<?php
session_start();
if ($_SESSION['admin'] != null)
   $id_admin = $_SESSION['admin'];
else
   header("Location:informativa.php");
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
         require 'database.php';
         $sql = "SELECT r_anuncios.id_anuncio, r_anuncios.contenido FROM r_anuncios";
         $pdo = Database::connect();


         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sql = "UPDATE r_anuncios SET vigente = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            foreach ($_POST['anuncios'] as $id_anuncio => $valor) {
               // Actualizar anuncio en la base de datos
               $sql = "UPDATE r_anuncios SET vigente = :vigente WHERE id_anuncio = :id_anuncio";
               $stmt = $pdo->prepare($sql);
               $stmt->execute(['vigente' => $valor, 'id_anuncio' => $id_anuncio]);
            }
         }

         // Obtener los anuncios de la base de datos
         $sql = "SELECT * FROM r_anuncios";
         $stmt = $pdo->query($sql);
         $anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);
         ?>

         <form method="post" action="AceptaAnuncios.php">

            <tr>
               <th>Contenido</th>

               <th>Multimedia</th>
               <th>Activo</th>
               <td class="tabla">
               <td><input value="Guardar" type="submit" class="btn"></td>
            </tr>
            </tr>



            <?php foreach ($anuncios as $anuncio): ?>
               <tr>
                  <td>
                     <?php echo ($anuncio['contenido']); ?>
                  </td>
                  <td>
                     <?php echo ($anuncio['multimedia']); ?>
                  </td>
                  <td><input type="checkbox" name="anuncios[<?php echo $anuncio['id_anuncio']; ?>]" value="1" <?php if ($anuncio['vigente']): ?> checked<?php endif; ?>></td>
                  <td><a class="btn"
                        href="actualizar_anuncio.php?id_anuncio=<?php echo $anuncio['id_anuncio']; ?>&contenido=<?php echo urlencode($anuncio['contenido']); ?>">Editar</a>
                  </td>
               </tr>
            <?php endforeach; ?>
      </table>
      <div>
         <a class="link" href="SistemaAnuncios.php">Regresar</a>
      </div>


      </form>

      <tr>
      </tr>
      </table>
   </div>
   <article></article>
   <div id="footer"></div>
</body>

</html>