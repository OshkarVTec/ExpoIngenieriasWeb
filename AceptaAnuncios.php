<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="CSS/style.css">
   <title>Anuncios</title>
</head>
<body>
   <header class="header">
      <div class="logo">
        <img src="IMG/logo-expo.png" alt="Logo de la pagina">
      </div>
      <a href="#" class="btn"><button>Log In</button></a>
   </header>
   <h1 class="label">Anuncios</h1>

   <div class = "container">
      <table class="general">  
        <?php
        require 'database.php';
         $sql = "SELECT r_anuncios.id_anuncio, r_anuncios.contenido FROM r_anuncios";
         $pdo = Database::connect();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
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
      
      <form method="post">
        
            <tr>
              <th>Contenido</th>
              
              <th>Multimedia</th>
              <th>Vigente</th>
              <td class = "tabla">
                <td><button class = "btn" type="submit">Guardar</button></td>
         </tr>
            </tr>

         
          
            <?php foreach ($anuncios as $anuncio): ?>
              <tr>
                <td><?php echo ($anuncio['contenido']); ?></td>
                <td><?php echo ($anuncio['multimedia']); ?></td>
                <td><input type="checkbox" name="anuncios[<?php echo $anuncio['id_anuncio']; ?>]" value="1"<?php if ($anuncio['vigente']): ?> checked<?php endif; ?>></td>
                <td><a class="btn" href="actualizar_anuncio.php?id_anuncio=<?php echo $anuncio['id_anuncio']; ?>&contenido=<?php echo urlencode($anuncio['contenido']); ?>">Editar</a></td>
              </tr>
              <?php endforeach; ?>
        </table>
        <div>
               <a class = "link" href="SistemaAnuncios.php">Regresar</a>
            </div>

        
      </form>
      
         <tr>
         </tr>
      </table>
   </div>
</body>
</html>