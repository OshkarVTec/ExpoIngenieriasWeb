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

         


    $anuns = array("Anuncio 1", "Anuncio 2");


    //if (isset($_POST['nuevo'])) {
        //$sql[] = 'Anuncio ' . (count($sql) + 1);
    //}    

        

        foreach($pdo->query($sql) as $row)
        {
         $rol = 'Administrador';
         $id_anuncio = $row['id_anuncio'];
         $contenido = $row['contenido'];
         echo '<tr>';
         echo '<td><a class="link" href="MostrarAnuncio.php?id_anuncio=' . $id_anuncio . '&contenido=' . $contenido . '">'. 'Anuncio ' . $row['id_anuncio'] . '</a></td>';
         echo '<td class="tabla">';
         //echo '<td><input type="checkbox" id="Activar"> <label for="Activar">Activar</label>';
         echo '<a class="btn" href="actualizar_anuncio.php.php?id_anuncio=' . $id_anuncio . '&contenido=' . $contenido . '">Editar</a>';
         echo '</td>';
         echo '</tr>';
        }



        //foreach () {   
         //   echo '<tr>';
         //   echo '<td><a class="link" href="Editar_Anuns.php">' . $ . '</a></td>';
         //   echo '<td class="tabla">';
         //   echo '<td><input type="checkbox" id="Activar"> <label for="Activar">Activar</label>';
         //   echo '<a class="btn" href="NuevosAnuncios.html">Editar</a>';
         //   echo '</td>';
         //   echo '</tr>';
        //}
        ?>
         <tr>
            <td><a class="btn" href="CrearAnuncio.php">Nuevo</a></td>
            
            
            <td class = "tabla">
                <td><a class ="btn" href="AceptaAnuncios.php">Publicar anuncios</a></td>
         </tr>
      </table>
   </div>
</body>
</html>