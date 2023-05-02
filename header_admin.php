<?php 
session_start();
?>

<header class="header">
   <div class="logo">
     <img src="IMG/logo-expo.png" alt="Logo de la pagina">
   </div>
   <nav class="menu">
    <ul class="nav-links">
      <li><a href="GanadoresPage.html">Ganadores</a></li>
      <li><a href="ver_proyectos.php">Ver proyectos</a></li>
      <li><a href="EditarAnuncios.html">Editar anuncios</a></li>
      <li><a href="">Asignar jueces</a></li>
    </ul>
  </nav>
    <nav class="menu">
    <div class="dropdown">
      <button class="dropbtn">Más Acciones
        <i class="fa fa-caret-down"></i>
      </button>
    <div class="dropdown-content">
      <a href="rubrica_evaluacion.html">Criterio de evaluación</a>
      <a href="">Editar usuarios</a>
      <?php echo '<a href="cuenta.php?id_usuario='.$_SESSION['id_usuario'].'">Mi Cuenta</a>';?>
      <a href="edicion_de_expo_vista.html">Edición de Expo</a>
      <a href="">Reportes</a>
    </div>
  </nav>
</header>