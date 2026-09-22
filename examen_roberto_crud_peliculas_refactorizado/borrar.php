<?php
/**
 * Elimina una película y vuelve al listado.
 *
 * @package CrudPeliculas
 */

require "config.php";

/**
 * Elimina una película mediante su identificador.
 *
 * @param PDO $pdo Conexión a la base de datos.
 * @param mixed $id Identificador de la película.
 * @return void
 */
function borrarPelicula(PDO $pdo, mixed $id): void
{
    $stmt = $pdo->prepare("DELETE FROM peliculas WHERE id = :id");
    $stmt->execute([":id" => $id]);
}

$id = $_GET["id"] ?? null;

if ($id !== null) {
    borrarPelicula($pdo, $id);
}

header("Location: index.php");
exit;
?>
