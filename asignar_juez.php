<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['id_proyecto'];

    include 'database.php';
    $pdo = Database::connect();

    if (isset($_POST['deasignar'])) {
        $judge_ids = $_POST['id_juez'];

        $sql = "DELETE FROM r_calificaciones WHERE id_proyecto = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($project_id));


        $sql = "INSERT INTO r_calificaciones (puntos_rubro1, puntos_rubro2, puntos_rubro3, puntos_rubro4, comentarios, fecha, id_proyecto, id_juez) VALUES (0, 0, 0, 0, '', NULL, ?, ?)";

        foreach ($judge_ids as $judge_id) {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$project_id, $judge_id]);
        }
    }
    
    if (isset($_POST['asignar'])) {
        $judge_ids = $_POST['judge_id'];
    
        $sql = "INSERT INTO r_calificaciones (puntos_rubro1, puntos_rubro2, puntos_rubro3, puntos_rubro4, comentarios, fecha, id_proyecto, id_juez) VALUES (0, 0, 0, 0, '', NULL, ?, ?)";
        $stmt = $pdo->prepare($sql);
    
        foreach ($judge_ids as $judge_id) {
            $stmt->execute([$project_id, $judge_id]);
        }
    }
    

    Database::disconnect();
    header('Location: asignar_jueces.php');
    // header('Location: asignar_jueces.php?id_proyecto=' . $project_id);
    exit();
}
?>