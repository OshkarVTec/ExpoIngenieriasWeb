<?php
session_start();
$id_proyecto = null;
if (!empty($_GET['id_proyecto'])) {
    $id_proyecto = $_REQUEST['id_proyecto'];
}
require 'database.php';

$Error = null;

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM r_rubrica';
$q = $pdo->prepare($sql);
$q->execute(array());
if ($q->rowCount() > 0) {
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $id_rubrica = $row['id_rubrica'];
    $rubro1 = $row['nombre1'];
    $rubro2 = $row['nombre2'];
    $rubro3 = $row['nombre3'];
    $rubro4 = $row['nombre4'];
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
        <?php
        if ($_SESSION['admin'] != null) {
            echo '<a href="#" class="btnP"><button>Editar</button></a>';
        } ?>
        <h1>Rubrica de Evaluación</h1>
        <table class="rubrica">
            <thead>
                <tr>
                    <th>
                        <?php echo $rubro1; ?>
                    </th>
                    <th>
                        <?php echo $rubro2; ?>
                    </th>
                    <th>
                        <?php echo $rubro3; ?>
                    </th>
                    <th>
                        <?php echo $rubro4; ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $descripcion1; ?>
                    </td>
                    <td>
                        <?php echo $descripcion2; ?>
                    </td>
                    <td>
                        <?php echo $descripcion3; ?>
                    </td>
                    <td>
                        <?php echo $descripcion4; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <article></article>
    <div id="footer"></div>
</body>

</html>