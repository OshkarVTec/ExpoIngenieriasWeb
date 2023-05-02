<?php
   session_start();
   $id_proyecto = null;
	if ( !empty($_GET['id_proyecto'])) {
		$id_proyecto = $_REQUEST['id_proyecto'];
	}
	require 'database.php';

		$Error = null;

      $pdo = Database::connect();
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = 'SELECT * FROM r_rubrica';
      $q = $pdo->prepare($sql);
      $q->execute(array());
      if($q->rowCount() > 0){
        $row = $q->fetch(PDO::FETCH_ASSOC);
        $id_rubrica = $row['id_rubrica'];
        $nombre1 = $row['nombre1'];
        $nombre2   = $row['nombre2'];
        $nombre3 =$row['nombre3'];
        $nombre4 = $row['nombre4'];
        $descripcion1 = $row['descripcion1'];
        $descripcion2 = $row['descripcion2'];   
        $descripcion3 = $row['descripcion3'];
        $descripcion4 = $row['descripcion4'];
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Rubrica</title>
   <link rel="stylesheet" href="CSS/style.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
   <script> 
    $(function(){
      $("#header").load(<?php 
        if($_SESSION['estudiante'] != null){
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
   <div class = "container">
      <a href="#" class="btnP"><button>Editar</button></a>
      <table class="rubrica">  
         <thead> 
         <tr>
            <th>Subcompetencia</th>
            <th>Destacado</th>
            <th>Sólido</th>
            <th>Básico</th>
            <th>Incipiente</th>
         </tr>
         </thead>
         <tbody>
         <tr>
            <td>Competencia 1</td>
            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium distinctio nostrum quam! Officia tempore earum eius nam architecto. Quaerat doloremque, nesciunt laboriosam aut dolorem minima aliquid quo molestiae dolorum odio?</td>
            <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Possimus officia inventore at ut atque eum quae illum quaerat eaque laboriosam quasi impedit ea repudiandae corporis dolore nisi, ab, nemo libero.</td>
            <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolores esse ullam excepturi ut nisi vitae nesciunt voluptatem. Incidunt, omnis, nesciunt similique nihil animi, temporibus quas cupiditate aut blanditiis earum aliquid?</td>
            <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum ab quae itaque excepturi reprehenderit dignissimos molestias blanditiis veritatis! Culpa dolore suscipit blanditiis, vero debitis quae quisquam assumenda nobis repudiandae ut?</td>
         </tr>
         <tr>
            <td>Competencia 2</td>
            <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium distinctio nostrum quam! Officia tempore earum eius nam architecto. Quaerat doloremque, nesciunt laboriosam aut dolorem minima aliquid quo molestiae dolorum odio?</td>
            <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Possimus officia inventore at ut atque eum quae illum quaerat eaque laboriosam quasi impedit ea repudiandae corporis dolore nisi, ab, nemo libero.</td>
            <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolores esse ullam excepturi ut nisi vitae nesciunt voluptatem. Incidunt, omnis, nesciunt similique nihil animi, temporibus quas cupiditate aut blanditiis earum aliquid?</td>
            <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nostrum ab quae itaque excepturi reprehenderit dignissimos molestias blanditiis veritatis! Culpa dolore suscipit blanditiis, vero debitis quae quisquam assumenda nobis repudiandae ut?</td>
         </tr>
      </tbody>
      </table>
   </div>
</body>
</html>