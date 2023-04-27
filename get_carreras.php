<?php
// Connect to the database
require 'database.php';
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
];
try {
  $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Retrieve the data
$query = "SELECT id_categoria, nombre FROM r_carreras";
$stmt = $pdo->query($query);
$data = $stmt->fetchAll();

// Return the data in JSON format
header("Content-Type: application/json");
echo json_encode($data);
?>
