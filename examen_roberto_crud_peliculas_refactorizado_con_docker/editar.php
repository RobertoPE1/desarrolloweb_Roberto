<?php
/**
 * Permite consultar y actualizar una película existente.
 *
 * @package CrudPeliculas
 */

require "config.php";

$id = $_GET["id"] ?? null;

if ($id === null) {
    die("ERROR: No se recibió el ID de la película.");
}

/**
 * Busca una película por su identificador.
 *
 * @param PDO $pdo Conexión a la base de datos.
 * @param mixed $id Identificador de la película.
 * @return array<string, mixed>|false Datos de la película o false si no existe.
 */
function obtenerPelicula(PDO $pdo, mixed $id): array|false
{
    $stmt = $pdo->prepare(
        "SELECT id, titulo, director, duracion, genero, anio
         FROM peliculas
         WHERE id = :id"
    );

    $stmt->execute([":id" => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$pelicula = obtenerPelicula($pdo, $id);

if (!$pelicula) {
    die("ERROR: No existe una película con el ID " . htmlspecialchars((string) $id));
}

$errores = [];

/**
 * Actualiza una película en la base de datos.
 *
 * @param PDO $pdo Conexión a la base de datos.
 * @param mixed $id Identificador de la película.
 * @param array<string, string> $datos Nuevos datos.
 * @return void
 */
function actualizarPelicula(PDO $pdo, mixed $id, array $datos): void
{
    $sql = "UPDATE peliculas SET
                titulo = :titulo,
                director = :director,
                duracion = :duracion,
                genero = :genero,
                anio = :anio
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":titulo" => $datos["titulo"],
        ":director" => $datos["director"],
        ":duracion" => $datos["duracion"],
        ":genero" => $datos["genero"],
        ":anio" => $datos["anio"],
        ":id" => $id,
    ]);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $datos = [
        "titulo" => trim($_POST["titulo"] ?? ""),
        "director" => trim($_POST["director"] ?? ""),
        "duracion" => trim($_POST["duracion"] ?? ""),
        "genero" => trim($_POST["genero"] ?? ""),
        "anio" => trim($_POST["anio"] ?? ""),
    ];

    if (!in_array("", $datos, true)) {
        actualizarPelicula($pdo, $id, $datos);

        header("Location: index.php");
        exit;
    }

    $errores[] = "Todos los campos son obligatorios.";

    // Mantenemos los datos introducidos si hay errores.
    $pelicula = array_merge($pelicula, $datos);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar película</title>
</head>
<body>

<h1>Editar película</h1>

<?php foreach ($errores as $error): ?>
    <p style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
<?php endforeach; ?>

<form method="POST">
    Título:
    <input type="text" name="titulo"
           value="<?= htmlspecialchars($pelicula["titulo"], ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    Director:
    <input type="text" name="director"
           value="<?= htmlspecialchars($pelicula["director"], ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    Duración:
    <input type="text" name="duracion"
           value="<?= htmlspecialchars($pelicula["duracion"], ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    Género:
    <input type="text" name="genero"
           value="<?= htmlspecialchars($pelicula["genero"], ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    Año:
    <input type="number" name="anio"
           value="<?= htmlspecialchars($pelicula["anio"], ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    <button type="submit">Actualizar</button>
</form>

<a href="index.php">Volver</a>

</body>
</html>
