<?php
session_start();
require 'database.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM r_proyecto_estudiantes WHERE matricula = ?';
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['estudiante']));
$p_estudiantes = $q->fetch(PDO::FETCH_ASSOC);
$proyecto = $p_estudiantes['id_proyecto'];
?>

<header class="header">
    <div class="logo">
    <a href="informativa_estudiante.html">
      <img src="IMG/logo-expo.png" alt="Logo de la pagina">
    </a>
    </div>
    <nav class="menu">
      <ul class="nav-links">
       <li><?php echo '<a href="cuenta.php?id_usuario='.$_SESSION['id_usuario'].'">Mi Cuenta</a>';?></li>
       <li><?php echo '<a href="mis_proyectos.php">Mis Proyectos</a>'?></li>
       <li><a href="rubrica_evaluacion.php">Criterio de evaluación</a></li>
       <li><a href="GanadoresPage.html">Ganadores</a></li>
      </ul>
      </div>
   </nav>
 </header>