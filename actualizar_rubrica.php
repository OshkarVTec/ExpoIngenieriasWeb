<?php
session_start();
$id_proyecto = null;
require 'database.php';

$Error = null;

if (!empty($_POST)) {
    $rubro1 = $_POST['rubro1'];
    $rubro2 = $_POST['rubro2'];
    $rubro3 = $_POST['rubro3'];
    $rubro4 = $_POST['rubro4'];
    $descripcion1 = $_POST['descripcion1'];
    $descripcion2 = $_POST['descripcion2'];
    $descripcion3 = $_POST['descripcion3'];
    $descripcion4 = $_POST['descripcion4'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE r_rubrica 
                  SET nombre1 = ?,  nombre2 = ?, nombre3 = ?, nombre4 = ?, 
                  descripcion1 = ?, descripcion2 = ?,  descripcion3 = ?, descripcion4 = ?
                  WHERE id_rubrica = 1";
    $q = $pdo->prepare($sql);
    $q->execute(array($rubro1, $rubro2, $rubro3, $rubro4, $descripcion1, $descripcion2, $descripcion3, $descripcion4));
    Database::disconnect();
    header("Location: rubrica_evaluacion.php");

} else {
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
        <h1>Rubrica de Evaluación</h1>
        <form method="post" action="actualizar_rubrica.php">
            <table class="rubrica">
                <thead>
                    <tr>
                        <th>
                            <input type="text" name="rubro1"
                                value="<?php echo !empty($rubro1) ? $rubro1 : 'Rubro 1'; ?>">
                        </th>
                        <th>
                            <input type="text" name="rubro2"
                                value="<?php echo !empty($rubro2) ? $rubro2 : 'Rubro 2'; ?>">
                        </th>
                        <th>
                            <input type="text" name="rubro3"
                                value="<?php echo !empty($rubro3) ? $rubro3 : 'Rubro 3'; ?>">
                        </th>
                        <th>
                            <input type="text" name="rubro4"
                                value="<?php echo !empty($rubro4) ? $rubro4 : 'Rubro 4'; ?>">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <textarea
                                name="descripcion1"><?php echo !empty($descripcion1) ? $descripcion1 : 'Descripcion 1'; ?></textarea>
                        </td>
                        <td>
                            <textarea
                                name="descripcion2"><?php echo !empty($descripcion2) ? $descripcion2 : 'Descripcion 2'; ?></textarea>
                        </td>
                        <td>
                            <textarea
                                name="descripcion3"><?php echo !empty($descripcion3) ? $descripcion3 : 'Descripcion 3'; ?></textarea>
                        </td>
                        <td>
                            <textarea
                                name="descripcion4"><?php echo !empty($descripcion4) ? $descripcion4 : 'Descripcion 4'; ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input value="Guardar" type="submit" class="btn">
            <a class="cancel" href="rubrica_evaluacion.php">Cancelar</a>
        </form>
    </div>
    <article></article>
    <div id="footer"></div>
</body>

</html>