<?php
session_start();
?>
<header class="header">
  <div class="logo">
    <img src="IMG/logo-expo.png" alt="Logo de la pagina">
  </div>
  <nav class="menu">
    <ul class="nav-links">
      <li><a href="evaluar.php">Evaluar</a></li>
      <li><a href="ver_proyectos.php">Ver proyectos</a></li>
      <li><a href="informativa.php">Anuncios</a></li>
      <li>
        <?php echo '<a href="cuenta.php?id_usuario=' . $_SESSION['id_usuario'] . '">Mi Cuenta</a>'; ?>
      </li>
    </ul>
    </div>
  </nav>
</header>