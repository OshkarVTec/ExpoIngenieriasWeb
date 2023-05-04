<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Asignar jueces</title>
    <link rel="stylesheet" href="CSS/style.css" />
  </head>
  <body>
    <header class="header">
      <div class="logo">
        <a href="informativa_presentacion.html">
          <img src="IMG/logo-expo.png" alt="Logo de la pagina" />
        </a>
      </div>
      <a href="#" class="btn"><button>Log In</button></a>
    </header>


    <?php
        $nombre = $_GET['nombre'];
        echo '<div id="instrucciones-editar-usuario">';
            echo '<h1 class="label">Nombre del proyecto: '.$nombre.'</h1>';

            echo '<h5 id="texto-instruciones">';
            echo 'Selecciona para asignar o deseleccionar a los jueces de este proyecto.';
            echo '</h5>';
        echo '</div>';

        echo '<div id="instrucciones-editar-usuario">';
        echo '<h1 class="label">Jueces asignados a este proyecto: </h1>';
        echo '<!-- <h5 id="texto-instruciones">';

        echo '</h5> -->';
        echo '</div>';


    ?> 


  <!-- INSERT INTO `r_calificaciones`(`puntos_rubro1`, `puntos_rubro2`, 
  `puntos_rubro3`, `puntos_rubro4`, `comentarios`, `fecha`, `id_proyecto`, `id_juez`) 
  VALUES (0,0,0,0,'',?,?,?) -->


    <div class="container">
    <table class="general">




<?php
    if(isset($_GET['id_proyecto'])) {
        $id_proyecto = $_GET['id_proyecto'];
        include 'database.php';


        //form para quitar jueces
        echo '<form method="POST" action="asignar_juez.php" onsubmit="return true;">';



        $pdo = Database::connect();

        $sql = "SELECT r_jueces.nombre, r_jueces.apellidoP ,r_jueces.apellidoM, r_proyectos.id_proyecto, r_jueces.id_juez
        FROM r_jueces 
        LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
        LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
        WHERE r_proyectos.id_proyecto = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_proyecto]);



        $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($proyectos as $row) {


          //cuenta los jueces que han sido asignados al proyecto actual
          $sql2 = "SELECT COUNT(*) AS num_rows 
          FROM ( 
          SELECT r_jueces.nombre, r_jueces.apellidoP, r_jueces.apellidoM, r_proyectos.id_proyecto, 		r_jueces.id_juez 
          FROM r_jueces LEFT JOIN r_calificaciones ON r_calificaciones.id_juez = r_jueces.id_juez 
          LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_calificaciones.id_proyecto 
          WHERE r_jueces.id_juez = ?
          ) AS subquery";
  
          $stmt = $pdo->prepare($sql2);
          $stmt->execute([$row['id_juez']]);
          $result = $stmt->fetch();
          $num_rows = $result['num_rows'];

          // echo "Number of rows: " . $num_rows;



           
            echo '<tr>';
                
                echo '<td id="nombre-juez"><a class="link-edicion">'.$row['nombre'].' '.$row['apellidoP'].' '.$row['apellidoM'].'</a></td>';

                //checkbox
                
  echo '<td id="agregar-quitar-juez"><input type="checkbox" name="judge_id[]" value="'.$row['id_juez'].'" '.($num_rows > 0 ? 'checked' : '').'></td>';
  
 

                echo '<td> #Proyectos asignados: '.$num_rows.' </td>';
            echo '</tr>';                       

        }

        
    }

?>

    </table>
    </div>


    <button id="nueva-edicion-btn" class="btn" type="submit" name="deasignar">Guardar</button>

    <?php
      echo '<input id="input-hidden" type="hidden" name="id_proyecto" value="'.$id_proyecto.'" ?>';
    ?>

    </form>









    <div id="separador" id="instrucciones-editar-usuario" >
    <h1 class="label">Jueces sin asignar a este proyecto: </h1>
    <!-- <h5 id="texto-instruciones">
    
    </h5> -->
    </div>

  
  <div class="container">
  <table class="general">  



<?php

        $id_proyecto = $_GET['id_proyecto'];

        echo '<form method="POST" action="asignar_juez.php" onsubmit="return true;">';


        //Te dice los jueces que forman parte de la edicion activa y que no forman parte del proyecto actual
        $sql = "SELECT *
        FROM r_jueces
        WHERE id_edicion = (
          SELECT id_edicion
          FROM r_ediciones
          WHERE activa = 1
        )
        AND id_juez NOT IN (
          SELECT id_juez
          FROM r_calificaciones
          WHERE id_proyecto = ?
        )";

        $q = $pdo->prepare($sql);
        $q->execute([$id_proyecto]); // Bind the parameter with the value
        // $rowCount = $stmt->rowCount();




        // $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($q as $row) {


        echo '<tr>';
        echo '<td id="nombre-juez"><a class="link-edicion">'.$row['nombre'].' '.$row['apellidoP'].' '.$row['apellidoM'].'</a></td>';

        //checkbox
        // echo '<td id="agregar-quitar-juez"><input type="checkbox" id="activa" name="activa"   /></td>';
        echo '<td id="agregar-quitar-juez"><input type="checkbox" name="judge_id[]" value="'.$row['id_juez'].'"></td>';





        $sql2 = "SELECT COUNT(DISTINCT rc.id_proyecto)
        FROM r_calificaciones rc
        JOIN r_proyectos rp ON rc.id_proyecto = rp.id_proyecto
        JOIN r_ediciones re ON rp.id_edicion = re.id_edicion
        WHERE rc.id_juez = ? AND rc.id_proyecto != ? AND re.activa = 1";

        $q = $pdo->prepare($sql2);
        $q->execute([$row['id_juez'],$id_proyecto]);

        $num_assignments = $q->fetchColumn();

        echo '<td>#Proyectos asignados: '.$num_assignments.' </td>';


        echo '</tr>';   

        }

        

        Database::disconnect();
?>

  </table>
  </div>

  <button id="nueva-edicion-btn" class="btn" type="submit" name="asignar">Guardar</button>

  <?php
      echo '<input id="input-hidden" type="hidden" name="id_proyecto" value="'.$id_proyecto.' "?>';
    ?>

  </form>