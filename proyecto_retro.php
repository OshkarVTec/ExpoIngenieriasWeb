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
$sql = 'SELECT * FROM r_proyectos WHERE id_proyecto = ?';
$q = $pdo->prepare($sql);
$q->execute(array($id_proyecto));
$row = $q->fetch(PDO::FETCH_ASSOC);
$status = $row['estatus'];
$name = $row['nombre'];
$poster = $row['poster'];
$video = $row['video'];
$uf = $row['id_uf'];
$docente = $row['id_docente'];
$categoria = $row['id_categoria'];
$descripcion = $row['description'];

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM r_rubrica WHERE id_rubrica = 1';
$q = $pdo->prepare($sql);
$q->execute(array());
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
Database::disconnect();

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
                echo '"header_juez.php"';
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
    <?php
    $promedios;
    $i = 0;
    $pdo = Database::connect();
    $sql = 'SELECT * FROM r_calificaciones WHERE id_proyecto = ?';
    $q = $pdo->prepare($sql);
    $q->execute(array($id_proyecto));
    $calificaciones = $q->fetchAll(PDO::FETCH_ASSOC);
    if($calificaciones){
        echo '<table class="rubrica">';
        echo    '<thead>';
        echo        '<tr>';
        echo            '<th>Nombre del Juez</th>';
        echo            '<th>Retroalimentación</th>';
        echo            '<th>';
        echo                $rubro1;
        echo            '</th>';
        echo            '<th>';
        echo                $rubro2;
        echo            '</th>';
        echo            '<th>';
        echo                $rubro3;
        echo            '</th>';
        echo            '<th>';
        echo                $rubro4;
        echo            '</th>';
        echo            '<th>Promedio</th>';
        echo        '</tr>';
        echo    '</thead>';
        echo    '<tbody>';
                
                foreach ($calificaciones as $row) {
                    $pdo = Database::connect();
                    $sql = 'SELECT * FROM r_jueces WHERE id_juez = ?';
                    $q = $pdo->prepare($sql);
                    $q->execute(array($row['id_juez']));
                    $juez = $q->fetch(PDO::FETCH_ASSOC);

                    echo '<tr>';
                    echo '<td>' . $juez['nombre'] . ' ' . $juez['apellidoP'] . ' ' . $juez['apellidoM'] . '</td>';
                    echo '<td>' . $row['comentarios'] . '</td>';
                    echo '<td>' . $row['puntos_rubro1'] . '</td>';
                    echo '<td>' . $row['puntos_rubro2'] . '</td>';
                    echo '<td>' . $row['puntos_rubro3'] . '</td>';
                    echo '<td>' . $row['puntos_rubro4'] . '</td>';
                    echo '<td>' . $promedio = ($row['puntos_rubro1'] + $row['puntos_rubro2'] + $row['puntos_rubro3'] + $row['puntos_rubro4']) / 4 . '</td>';
                    echo '</tr>';
                    $promedios = ($promedios + $promedio);
                    $i = $i + 1;
                }
                echo '<tr>';
                echo '<td></td>' . '<td></td>' . '<td></td>' . '<td></td>' . '<td></td>' . '<td>' . 'Calificacion Final' . '</td>' . '<td>' . $promedios / $i . '</td>';
                echo '</tr>';
            }
                    ?>
            </tbody>
        </table>

        <br>
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

        <button class="cancel" onclick="history.go(-1);">Regresar</button>
    </div>
</body>

</html>