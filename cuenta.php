<?php
session_start();
$id_usuario = null;
if (!empty($_GET['id_usuario'])) {
    $id_usuario = $_REQUEST['id_usuario'];
}
require 'database.php';

$Error = null;

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM r_estudiantes WHERE id_usuario = ?';
$q = $pdo->prepare($sql);
$q->execute(array($id_usuario));
if ($q->rowCount() > 0) {
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $name = $row['nombre'];
    $matricula = $row['matricula'];
    $apellidoP = $row['apellidoP'];
    $apellidoM = $row['apellidoM'];
    $id_edicion = $row['id_edicion'];
    $id_user = $row['id_usuario'];
    $rol = "Estudiante";
    $id_carrera = $row['id_carrera'];
}

$sql = 'SELECT * FROM r_docentes WHERE id_usuario = ?';
$q = $pdo->prepare($sql);
$q->execute(array($id_usuario));
if ($q->rowCount() > 0) {
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $name = $row['nombre'];
    $matricula = $row['matricula'];
    $apellidoP = $row['apellidoP'];
    $apellidoM = $row['apellidoM'];
    $id_edicion = $row['id_edicion'];
    $id_user = $row['id_usuario'];
    $rol = "Docente";
    $sql = 'SELECT * FROM r_jueces WHERE id_usuario = ?';
    $q = $pdo->prepare($sql);
    $q->execute(array($id_usuario));
    if ($q->rowCount() > 0) {
        $row = $q->fetch(PDO::FETCH_ASSOC);
        $name = $row['nombre'];
        $matricula = $row['matricula'];
        $apellidoP = $row['apellidoP'];
        $apellidoM = $row['apellidoM'];
        $id_edicion = $row['id_edicion'];
        $id_user = $row['id_usuario'];
        $rol = "Juez/Docente";
    }
}

$sql = 'SELECT * FROM r_jueces WHERE id_usuario = ?';
$q = $pdo->prepare($sql);
$q->execute(array($id_usuario));
if ($q->rowCount() > 0) {
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $name = $row['nombre'];
    $matricula = $row['matricula'];
    $apellidoP = $row['apellidoP'];
    $apellidoM = $row['apellidoM'];
    $id_edicion = $row['id_edicion'];
    $id_user = $row['id_usuario'];
    $rol = "Juez";
}
Database::disconnect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
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

    <div class="container">
        <div class="firstrow">
            <h1 class="title">Mi Cuenta</h1>
            <a href="logout.php" class="logout"><button>Log Out</button></a>
        </div>
        <hr color="#1687A7">

        <br>

        <p>Nombre</p>
        <hr color="#1687A7" width="50%">
        <div class="cuentabig">
            <p>
                <?php echo !empty($name) ? $name : '';
                echo ' ';
                echo !empty($apellidoP) ? $apellidoP : ' ';
                echo ' ';
                echo !empty($apellidoM) ? $apellidoM : '';
                ?>
            </p>
        </div>
        <?php
        if ($rol == 'Estudiante') {
            echo "<p>Matricula</p>";
            echo "<hr color=\"#1687A7\" width=\"50%\">";
            echo "<div class=\"cuentabig\">";
            echo "<p>";
            echo $matricula;
            echo "</p>";
            echo "</div>";

            echo "<p>Carrera</p>";
            echo "<hr color=\"#1687A7\" width=\"50%\">";
            echo "<div class=\"cuentabig\">";
            echo "<p>";
            $sql = 'SELECT * FROM r_carreras WHERE id_carrera = ?';
            $w = $pdo->prepare($sql);
            $w->execute(array($id_carrera));
            $c_name = $w->fetch(PDO::FETCH_ASSOC);
            echo $c_name['nombre'];
            echo "</p>";
            echo "</div>";
        }
        ?>


        <br>
        <p>Correo Electrónico</p>
        <hr color="#1687A7" width="50%">
        <div class="cuentabig">
            <p>
                <?php
                $pdo = Database::connect();
                $sql = 'SELECT * FROM r_usuarios WHERE id_usuario = ?';
                $q = $pdo->prepare($sql);
                $q->execute(array($id_usuario));
                $correo = $q->fetch(PDO::FETCH_ASSOC);
                echo $correo['correo'];
                Database::disconnect();
                ?>
            </p>
        </div>

        <br>
        <p>Rol</p>
        <hr color="#1687A7" width="50%">
        <div class="cuentabig">
            <p>
                <?php echo !empty($rol) ? $rol : ''; ?>
            </p>
        </div>

        <br>
        <?php
        if ($rol == 'Estudiante') {
            $pdo = Database::connect();
            $sql = 'SELECT * FROM r_proyecto_estudiantes WHERE matricula = ?';
            $q = $pdo->prepare($sql);
            $q->execute(array($matricula));
            $p_estudiantes = $q->fetchAll(PDO::FETCH_ASSOC);
            echo '<p> Mi Proyecto</p>';
            echo '<hr color="#1687A7" width="50%">';
            echo '<div class="cuentabig">';
            echo '<ul class="cuentalast">';
            foreach ($p_estudiantes as $row) {
                $proyecto = $row['id_proyecto'];
                $sql = 'SELECT * FROM r_proyectos WHERE id_proyecto = ?';
                $q = $pdo->prepare($sql);
                $q->execute(array($row['id_proyecto']));
                $p_name = $q->fetch(PDO::FETCH_ASSOC);
                $proyectos = $p_name['nombre'];
                echo '<li><p>';
                echo $proyectos;
                echo '</p>';
                echo '</li>';
                echo '<li>';
                echo '<a href="proyecto.php?id_proyecto=' . $proyecto . '" class="btnP"><button>Ver Más</button></a>';
                echo '</li>';
                echo '<br>';
                Database::disconnect();
            }
            echo '</ul>';
        }
        ?>

        </ul>
        <br>
    </div>

    </div>
    <article></article>
    <div id="footer"></div>

</body>

</html>