
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ver proyectos</title>
   <link rel="stylesheet" href="CSS/style.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
   <script> 
    $(function(){
      $("#header").load("header.html"); 
    });
    </script> 
</head>
<body>
   <div id="header"></div>
   <?php
      include 'database.php';
      $pdo = Database::connect();
      $sql = 'SELECT *  FROM r_ediciones WHERE activa = 1';
      $q = $pdo->prepare($sql);
      $q->execute();
      $id_edicion = $q->fetch(PDO::FETCH_ASSOC)['id_edicion'];
      $sql = 'SELECT * FROM r_categorias ORDER BY id_categoria';
      foreach ($pdo->query($sql) as $row) {
         echo '<h1 class="label">'.$row['nombre'].'</h1>';
         echo '<div class = "container">';
         echo '<table class="general">';
         $sql = 'SELECT * FROM r_proyectos WHERE id_categoria = ? AND id_edicion = ?';
         $q = $pdo->prepare($sql);
         $q->execute(array($row['id_categoria'], $id_edicion));
         $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);

         

         foreach ($proyectos as $row) {
            echo '<tr>';
            echo '<td>';
            echo '<a class="link" href="proyecto.php?id_proyecto='.$row['id_proyecto'].'">'. $row['nombre'] .'</a>';
            echo '<td class = "column"> 98
            

            <form method="post">
            <select name="select">
              <option value="1" >Primer lugar</option>
              <option value="2">Segundo lugar</option>
              <option value="3">Tercer lugar</option>
              <option value="4">No ganador</option>
              
            </select>';

            echo '</td>';
            echo '</td>';
            echo '</tr>';
         }
         echo '</table>';
         echo '</div>';
         //echo '<a class="link" href="proyecto.php?id_proyecto='.$row['id_proyecto'].'">'. $row['premio'] .'</a>';
      }      

      

    

      Database::disconnect();

      if(isset($_POST['submit'])){
        if($_POST['select'] == '1'){
            $sql = "UPDATE r_proyectos SET premio=1 WHERE id_proyecto=?";
        } elseif($_POST['select'] == '2'){
            $sql = "UPDATE r_proyectos SET premio=2 WHERE id_proyecto=?";
        } elseif($_POST['select'] == '3'){
            $sql = "UPDATE r_proyectos SET premio=3 WHERE id_proyecto=?";
        } elseif($_POST['select'] == '4'){
            $sql = "UPDATE r_proyectos SET premio=0 WHERE id_proyecto=?";
        }
        
    }
   ?>

<tr>
            <td><label for="link">Seleccionar UF:</label></td>
            <td>     
            <select name = "uf">
               <?php
                  $pdo = Database::connect();
                  $query = 'SELECT * FROM r_ufs';
                  foreach ($pdo->query($query) as $row) {
                     echo "<option value='" . $row['id_uf'] . "'>" . $row['nombre'] . "</option>";
                  }
                  Database::disconnect();
               ?>
            </select>
            </td>
            </tr>

</body>
<tr>

<td><button class = "btn" name="submit">Guardaro</button></td>




<td class = "tabla">
                <td><button class = "btn">Guardar</button></td>
    </td>

    <td><button class = "btn" onclick="location='GanadoresPorCategoria.php'">Guardarss</button></td>
    
</html>