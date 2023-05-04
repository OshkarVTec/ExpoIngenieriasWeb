<?php
session_start();
require 'database.php';
$pdo = Database::connect();

$Error = null;

if (!empty($_POST)) {

  $name = $_POST['name'];
  $poster = $_POST['poster'];
  $video = $_POST['video'];
  $uf = $_POST['uf'];
  $docente = $_POST['docente'];
  $categoria = $_POST['categoria'];
  $descripcion = $_POST['descripcion'];
  $nivel = $_POST['nivel'];

  // validate input
  $valid = true;

  if (empty($name)) {
    $Error = 'Por favor escribe un nombre';
    $valid = false;
  }
  if (empty($poster)) {
    $Error = 'Por favor proporcione un link al poster';
    $valid = false;
  }
  if (empty($video)) {
    $Error = 'Por favor proporcione un link al video';
    $valid = false;
  }
  if (empty($uf)) {
    $Error = 'Por favor seleccione una UF';
    $valid = false;
  }
  if (empty($docente)) {
    $Error = 'Por favor seleccione un docente';
    $valid = false;
  }
  if (empty($categoria)) {
    $Error = 'Por favor seleccione una categoria';
    $valid = false;
  }
  if (empty($descripcion)) {
    $Error = 'Por favor proporcione una descripcion';
    $valid = false;
  }

  // insert data
  if ($valid) {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO r_proyectos (id_proyecto, poster, description, estatus, nombre, video, 
                                fecha_registro, id_uf,  id_docente, id_edicion, id_categoria, id_nivel) 
                                values (NULL, ?, ?, false, ?,?, current_timestamp(), ?, ?, 1, ?, ?)";

    $q = $pdo->prepare($sql);
    $q->execute(array($poster, $descripcion, $name, $video, $uf, $docente, $categoria, $nivel));
    Database::disconnect();

    $sql = 'SELECT * FROM r_proyectos WHERE nombre = ?';
    $q = $pdo->prepare($sql);
    $q->execute(array($name));
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $id_proyecto = $row['id_proyecto'];
    $sql = "INSERT INTO r_proyecto_estudiantes (id_registro, matricula, id_proyecto) 
                                values (?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array(null, $_SESSION['matricula'], $id_proyecto));
    $select = $_POST['pers'];
    foreach ($select as $value) {
      $query = "SELECT * FROM r_estudiantes WHERE matricula = '$value'";
      $result = $pdo->query($query);
      $row = $result->fetch(PDO::FETCH_ASSOC);
      $sql = "INSERT INTO r_proyecto_estudiantes (matricula, id_proyecto) VALUES (?,?)";
      $q = $pdo->prepare($sql);
      $q->execute(array($row['matricula'], $id_proyecto));
      Database::disconnect();
      header("Location: mis_proyectos.php");
    }
  }
  header("Location: mis_proyectos.php");
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Proyecto</title>
  <link rel="stylesheet" href="CSS/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script>
    $(function () {
      $("#header").load(<?php
      if ($_SESSION['matricula'] != null) {
        echo '"header_estudiante.php"';
      } else if ($_SESSION['admin'] != null) {
        echo '"header_admin.php"';
      } else if ($_SESSION['juez'] != null) {
        if ($_SESSION['docente'] != null)
          echo '"header_docente_juez.php"';
        else
          echo '"header_juez.php"';
      } else if ($_SESSION['docente'] != null) {
        echo '"header_docente.php"';
      }
      ?>);
    });
    $(function () {
      $("#footer").load("footer.html");
    })
  </script>
</head>

<body>
  <div id="header"></div>
  <div class="ventana">
    <h1 class="label"></h1>
    <div class="container">
      <form class="login" action="crear_proyecto.php" method=POST>
        <table>

          <tr>
            <td><label for="name">Nombre del Proyecto:</label></td>
            <td><input type="text" id="title" name="name" value="<?php echo !empty($name) ? $name : ''; ?>"></td>
            <td>
            <td class="pruebaZ">
              <div class="dropdown">
                <button class="dropbtn">
                  <h2>Agregar compañeros</h2>
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                  <?php
                  $query = 'SELECT * FROM r_estudiantes WHERE matricula != "' . $_SESSION['matricula'] . '"';
                  foreach ($pdo->query($query) as $row) {
                    echo '<input type="checkbox" name="pers[]" value="' . $row['matricula'] . '">';
                    echo '<label>' . $row['nombre'] . ' ' . $row['apellidoP'] . ' ' . $row['apellidoM'] . '</label><br>';
                  }
                  echo '</div>';
                  echo '</div>';
                  ?>
            </td>

          </tr>



          <tr>
            <td><label for="poster">Link al poster:</label></td>
            <td><input type="text" id="linkp" name="poster" value="<?php echo !empty($poster) ? $poster : ''; ?>"></td>
          </tr>
          <tr>
            <td><label for="video">Link al video:</label></td>
            <td><input type="text" id="linkv" name="video" value="<?php echo !empty($video) ? $video : ''; ?>"></td>
          </tr>

          <tr>
            <td><label for="link">Seleccionar UF:</label></td>
            <td>
              <select name="uf">
                <?php
                $query = 'SELECT * FROM r_ufs';
                foreach ($pdo->query($query) as $row) {
                  echo "<option value='" . $row['id_uf'] . "'>" . $row['nombre'] . "</option>";
                }
                Database::disconnect();
                ?>
              </select>
            </td>
          </tr>

          <tr>
            <td><label for="docente">Seleccionar docente:</label></td>
            <td>
              <select name="docente">
                <?php
                $pdo = Database::connect();
                $query = 'SELECT * FROM r_docentes';
                foreach ($pdo->query($query) as $row) {
                  echo "<option value='" . $row['id_docente'] . "'>" . $row['nombre'] . " " . $row['apellidoP'] . "</option>";
                }
                Database::disconnect();
                ?>
              </select>
            </td>
          </tr>

          <tr>
            <td><label for="categoria">Seleccionar categoría:</label></td>
            <td>
              <select name="categoria">
                <?php
                $pdo = Database::connect();
                $query = 'SELECT * FROM r_categorias';
                foreach ($pdo->query($query) as $row) {
                  echo "<option value='" . $row['id_categoria'] . "'>" . $row['nombre'] . "</option>";
                }
                Database::disconnect();
                ?>
              </select>
            </td>
          </tr>

          <tr>
            <td><label for="nivel">Seleccionar nivel de desarrollo:</label></td>
            <td>
              <select name="nivel">
                <?php
                $pdo = Database::connect();
                $query = 'SELECT * FROM r_niveles_desarrollo';
                foreach ($pdo->query($query) as $row) {
                  echo "<option value='" . $row['id_nivel'] . "'>" . $row['nombre'] . "</option>";
                }
                Database::disconnect();
                ?>
              </select>
            </td>
          </tr>

          <tr>
            <td><label for="descripcion">Descripcion:</label></td>
            <td><textarea id="comment"
                name="descripcion"><?php echo !empty($descripcion) ? $descripcion : ''; ?></textarea>
            </td>
          </tr>

        </table>
        <div>
          <button class="cancel" onclick="history.go(-1);">Cancelar</button>
          <input value="Registrar Proyecto" type="submit" class="btn" id="convert-btn">
        </div>
        <?php if (($Error != null)) ?>
        <div class="Error">
          <?php echo $Error; ?>
        </div>
      </form>
    </div>
  </div>
  <article></article>
  <div id="footer"></div>
</body>

</html>

<script>
    (function ($) {

      var url = $('#linkv'),
        btn = $('#convert-btn');

      btn.on('click', function (event) {
        found = url.val().match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);

        if (found[1].length) {
          new_url = 'https://www.youtube.com/embed/' + found[1];

          url.val(new_url);
        }
      });

    })(jQuery);
</script>

<script>
  (function ($) {

    var url = $('#linkp'),
      btn = $('#convert-btn');

    btn.on('click', function (event) {
      found = url.val().match(/d\/([A-Za-z0-9_\-]+)/);
      if (found[1].length) {
        new_url = 'https://drive.google.com/uc?export=view&id=' + found[1];
        url.val(new_url);
      }
    });

  })(jQuery);
</script>