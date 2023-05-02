<?php
    if(isset($_GET['id_proyecto'])) {
        $id_usuario = $_GET['id_proyecto'];
        include 'database.php';

        $pdo = Database::connect();
        $sql = "DELETE FROM r_usuarios WHERE id_usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usuario]);
        Database::disconnect();
    }

    header("Location: ver_usuarios.php");
    exit();
?>
