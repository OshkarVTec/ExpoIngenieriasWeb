<?php
    if(isset($_GET['id_anuncio'])) {
        $id_anuncio = $_GET['id_anuncio'];
        include 'database.php';

        $pdo = Database::connect();
        $sql = "DELETE FROM r_anuncios WHERE id_anuncio = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_anuncio]);
        Database::disconnect();
        header('Location: SistemaAnuncios.php');
    }


    exit();
?>