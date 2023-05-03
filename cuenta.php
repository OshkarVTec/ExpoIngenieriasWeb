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
            if ($_SESSION['estudiante'] != null) {
                echo '"header_estudiante.php"';
            } else if ($_SESSION['admin'] != null) {
                echo '"header_admin.php"';
            } else if ($_SESSION['juez'] != null) {
                if ($_SESSION['docente'] != null)
                    echo '"header_juez.php"';
                else
                    echo '"header_docente_juez.php"';
            } else if ($_SESSION['docente'] != null) {
                echo '"header_docente.php"';
            }
            ?>);
        });
    </script>
</head>

<body>
    <div id="header"></div>

    <div class="container">
        <div class="firstrow">
            <h1 class="title">Mi Cuenta</h1>
            <a href="logout.php" class="logout"><button>Logout</button></a>
        </div>
        <hr color="#1687A7">

        <br>
        <p>Nombre, Matricula y Carrera</p>
        <hr color="#1687A7" width="50%">
        <div class="cuentabig">
            <p>
                <?php echo !empty($name) ? $name : '';
                echo ' ';
                echo !empty($apellidoP) ? $apellidoP : ' ';
                echo ' ';
                echo !empty($apellidoM) ? $apellidoM : '';
                echo ', ';
                echo $matricula;
                echo ' - ';
                $sql = 'SELECT * FROM r_carreras WHERE id_carrera = ?';
                $w = $pdo->prepare($sql);
                $w->execute(array($id_carrera));
                $c_name = $w->fetch(PDO::FETCH_ASSOC);
                echo $c_name['nombre'];
                Database::disconnect();
                ?>
            </p>
        </div>

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
            echo '<p> Mi Proyecto</p>';
            echo '<hr color="#1687A7" width="50%">';
            echo '<div class="cuentabig">';
            echo '<ul class="cuentalast">';
            echo '<li><p>';

            $pdo = Database::connect();
            $sql = 'SELECT * FROM r_proyecto_estudiantes WHERE matricula = ?';
            $q = $pdo->prepare($sql);
            $q->execute(array($matricula));
            $p_estudiantes = $q->fetch(PDO::FETCH_ASSOC);
            $proyecto = $p_estudiantes['id_proyecto'];

            $sql = 'SELECT * FROM r_proyectos WHERE id_proyecto = ?';
            $q = $pdo->prepare($sql);
            $q->execute(array($proyecto));
            $p_name = $q->fetch(PDO::FETCH_ASSOC);
            $proyectos = $p_name['nombre'];
            echo $proyectos;
            Database::disconnect();
            echo '</a></li>';
            echo '<li>';
            echo '<a href="proyecto.php?id_proyecto=' . $proyecto . '" class="btnP"><button>Editar</button></a>';
        }
        echo '</li>';
        ?>

        </ul>
        <br>
    </div>

    <br>
    <hr color="#1687A7">
    </div>

</body>

</html>