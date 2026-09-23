<?php
/**
 * Muestra el listado de películas almacenadas en la base de datos.
 *
 * @package CrudPeliculas
 */

require "config.php";

/**
 * Obtiene todas las películas de la base de datos.
 *
 * @return array<int, array<string, mixed>> Lista de películas.
 */
function obtenerPeliculas(): array
{
    global $pdo;

    $stmt = $pdo->query(
        "SELECT id, titulo, director, duracion, genero, anio
         FROM peliculas"
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Escapa un valor para mostrarlo de forma segura en HTML.
 *
 * @param mixed $valor Valor que se va a mostrar.
 * @return string Valor escapado.
 */
function escapar(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

$peliculas = obtenerPeliculas();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de películas</title>
</head>
<body>

<h1>Películas</h1>

<a href="crear.php">Añadir película</a>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Director</th>
        <th>Duración</th>
        <th>Género</th>
        <th>Año</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($peliculas as $pelicula): ?>
        <tr>
            <td><?= escapar($pelicula["id"]) ?></td>
            <td><?= escapar($pelicula["titulo"]) ?></td>
            <td><?= escapar($pelicula["director"]) ?></td>
            <td><?= escapar($pelicula["duracion"]) ?></td>
            <td><?= escapar($pelicula["genero"]) ?></td>
            <td><?= escapar($pelicula["anio"]) ?></td>
            <td>
                <a href="editar.php?id=<?= escapar($pelicula["id"]) ?>">
                    Editar
                </a>
                |
                <a
                    href="borrar.php?id=<?= escapar($pelicula["id"]) ?>"
                    onclick="return confirm('¿Seguro que deseas eliminar esta película?')"
                >
                    Eliminar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
