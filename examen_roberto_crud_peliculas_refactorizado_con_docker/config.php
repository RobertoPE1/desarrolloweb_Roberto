<?php
/**
 * Configuración y conexión con la base de datos.
 *
 * @package CrudPeliculas
 */

$host = "host.docker.internal";
$dbname = "cine";
$user = "root";
$pass = "1234";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
