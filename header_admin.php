<?php 
session_start();
?>

<header class="header">
   <div class="logo">
     <img src="IMG/logo-expo.png" alt="Logo de la pagina">
   </div>
   <nav class="menu">
    <ul class="nav-links">
      <li><a href="GanadoresPorCategoria.php">Ganadores</a></li>
      <li><a href="ver_proyectos.php">Ver proyectos</a></li>
      <li><a href="SistemaAnuncios.php">Editar anuncios</a></li>
      <li><a href="asignar_jueces.php">Asignar jueces</a></li>
    </ul>
  </nav>
    <nav class="menu">
    <div class="dropdown">
      <button class="dropbtn">Más Acciones
        <i class="fa fa-caret-down"></i>
      </button>
    <div class="dropdown-content">
      <a href="rubrica_evaluacion.php">Criterio de evaluación</a>
      <a href="editar_usuarios.php">Editar usuarios</a>
      <?php echo '<a href="cuenta.php?id_usuario='.$_SESSION['id_usuario'].'">Mi Cuenta</a>';?>
      <a href="edicion_de_expo_vista.php">Edición de Expo</a>
    </div>
  </nav>
</header>