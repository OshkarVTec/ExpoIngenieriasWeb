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


    ?> 


    <div class="container">
    <table class="general">


<?php
    if(isset($_GET['id_proyecto'])) {
        $id_proyecto = $_GET['id_proyecto'];
        include 'database.php';



        $pdo = Database::connect();

        $sql = "SELECT r_jueces.nombre, r_jueces.apellidoP ,r_jueces.apellidoM, r_proyectos.id_proyecto
        FROM r_jueces
        LEFT JOIN r_jueces_proyectos ON r_jueces_proyectos.id_juez = r_jueces.id_juez
        LEFT JOIN r_proyectos ON r_proyectos.id_proyecto = r_jueces_proyectos.id_proyecto
        WHERE r_proyectos.id_proyecto = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_proyecto]);



        $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($proyectos as $row) {


           
            echo '<tr>';
                echo '<td><a class="link-edicion">'.$row['nombre'].' '.$row['apellidoP'].' '.$row['apellidoM'].'</a></td>';
                echo '</td>';
            echo '</tr>';                       

        }

        Database::disconnect();
    }

    // header("Location: ver_usuarios.php");
    
    exit();
?>
    </table>
    </div>