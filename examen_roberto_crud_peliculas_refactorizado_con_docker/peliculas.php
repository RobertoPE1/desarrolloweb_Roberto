<?php

http_response_code(200);   // ←Mejor siempre al inicio del codigo de la API
require "../config.php"; // Conexión PDO

// Indicamos que la respuesta será JSON
header("Content-Type: application/json");

// Consulta para obtener TODOS los videojuegos
$sql = "SELECT * FROM peliculas";
$stmt = $pdo->query($sql);

// Convertimos los resultados en array asociativo
$peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolvemos el JSON
echo json_encode($peliculas);
?>
