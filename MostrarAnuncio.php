<?php
        include 'database.php';
        $pdo = Database::connect();

        $id_anuncio = $_GET['id_anuncio'];

        $contenido = $_GET['contenido'];
        $multimedia = $_GET['multimedia'];


        $sql = "SELECT * FROM r_anuncios WHERE id_anuncio = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_anuncio]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
    ?>

    
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Correo de confirmacion</title>
   <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
   <header class="header">
      <div class="logo">
        <img src="IMG/logo-expo.png" alt="Logo de la pagina">
      </div>
      <a href="#" class="btn"><button>Log In</button></a>
   </header>
   <div class = "small_window">
      <h1 class="label">Log in</h1>
      <div class="container">


         <form class="login" action="login.php" method=POST>
            <table class="general"> 

               

            <tr>
                <h1 class="label">Anuncios</h1>
                  
               </tr>

              
        
            </table>
            

            <div> 

            <tr>
            <td>    
            <p name = "anuncios">
               <?php
                  $pdo = Database::connect();



   //if(isset($_GET['id_anuncio'])) {
   //$id_anuncio = $_GET['id_anuncio'];
               
                  
                 
                    echo '<td class="email-column"><a class="anuncio">'.$row['contenido'].'</a><br><br></td>';

            
                    echo '<td class="email-column"><a class="anuncio">'.$row['multimedia'].'</a></td>';
                  Database::disconnect();
               
               
               ?>
            </p>
            </td>
            </tr>


            </div>

           
            <div> 
            <!--<td><input value="Editar anuncio" type="submit" class = "btn" ></td>
            </div>-->

            </div>  
            <img src=<?php echo !empty($multimedia)?$multimedia:'';?> alt="testimage" class="img">
        </div>

            <div>
               <a class = "link" href="SistemaAnuncios.php">Regresar</a>
            </div>


            
         </form>
      </div>
   </div>
</body>
</html>