<?php
session_start();
require 'database.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM r_proyectos WHERE id_docente = ?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['docente']));
$proyecto = $q->fetch(PDO::FETCH_ASSOC);
$idproyecto = $proyecto['id_proyecto'];
?>

<header class="header">
   <div class="logo">
     <img src="IMG/logo-expo.png" alt="Logo de la pagina">
   </div>
   <nav class="menu">
      <ul class="nav-links">   
      <li><a href="aprobar_proyectos.php">Aprobar proyectos</a></li>
      <li><a href="informativa.php">Anuncios</a></li>
      <li><a href="ver_proyectos.php">Ver proyectos</a></li>
      <li><?php echo '<a href="cuenta.php?id_usuario='.$_SESSION['id_usuario'].'">Mi Cuenta</a>';?></li>
     </ul>
     </div>
  </nav>
 </header>