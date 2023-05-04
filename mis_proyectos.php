<?php session_start();
if ($_SESSION['matricula'] != null)
    $matricula = $_SESSION['matricula'];
else
    header("Location:informativa.php");
$id_usuario = null;
if (!empty($_GET['id_usuario'])) {
    $id_usuario = $_REQUEST['id_usuario'];
}
require 'database.php';

$Error = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Proyectos</title>
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
        <table class="general">
            <?php
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT * FROM r_proyecto_estudiantes WHERE matricula = ?';
            $q = $pdo->prepare($sql);
            $q->execute(array($_SESSION['matricula']));
            $proyectos = $q->fetchAll(PDO::FETCH_ASSOC);
            foreach ($proyectos as $row) {
                $sql = 'SELECT * FROM r_proyectos WHERE id_proyecto = ?';
                $q = $pdo->prepare($sql);
                $q->execute(array($row['id_proyecto']));
                $proyecto = $q->fetchAll(PDO::FETCH_ASSOC);
                foreach ($proyecto as $row) {
                    echo '<tr>';
                    echo '<td>';
                    echo '<a class="link" href="proyecto.php?id_proyecto=' . $row['id_proyecto'] . '">' . $row['nombre'] . '</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            Database::disconnect();
            ?>
            <tr>
                <td><a href="crear_proyecto.php" class="btnP"><button>Nuevo Proyecto</button></a></td>
            </tr>
        </table>
    </div>
    <article></article>
    <div id="footer"></div>
</body>

</html>