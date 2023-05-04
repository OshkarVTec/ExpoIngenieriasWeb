<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['id_proyecto'];

    include 'database.php';
    $pdo = Database::connect();

    if (isset($_POST['deasignar'])) {
        if (isset($_POST['judge_id'])) {
            $judge_ids = $_POST['judge_id'];
            // Delete selected judges from r_calificaciones table
            $sql = "DELETE FROM r_calificaciones WHERE id_proyecto = ? AND id_juez IN (" . implode(',', array_fill(0, count($judge_ids), '?')) . ")";
            $stmt = $pdo->prepare($sql);
            $params = array_merge([$project_id], $judge_ids);
            $stmt->execute($params);
        }
    }

    if (isset($_POST['asignar'])) {
        $judge_ids = $_POST['judge_id'];

        $sql = "INSERT INTO r_calificaciones (puntos_rubro1, puntos_rubro2, puntos_rubro3, puntos_rubro4, comentarios, fecha, id_proyecto, id_juez) VALUES (NULL, NULL, NULL, NULL, '', NULL, ?, ?)";
        $stmt = $pdo->prepare($sql);

        foreach ($judge_ids as $judge_id) {
            $stmt->execute([$project_id, $judge_id]);
        }
    }


    Database::disconnect();
    header('Location: ver_jueces.php?id_proyecto=' . $project_id);
    exit();
}
?>