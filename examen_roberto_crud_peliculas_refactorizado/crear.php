<?php
/**
 * Permite crear una nueva película.
 *
 * @package CrudPeliculas
 */

require "config.php";

$errores = [];

/**
 * Obtiene y limpia los datos enviados por POST.
 *
 * @return array<string, string> Datos del formulario.
 */
function obtenerDatosFormulario(): array
{
    return [
        "titulo" => trim($_POST["titulo"] ?? ""),
        "director" => trim($_POST["director"] ?? ""),
        "duracion" => trim($_POST["duracion"] ?? ""),
        "genero" => trim($_POST["genero"] ?? ""),
        "anio" => trim($_POST["anio"] ?? ""),
    ];
}

/**
 * Comprueba que todos los campos de una película estén completos.
 *
 * @param array<string, string> $datos Datos de la película.
 * @return bool True si todos los campos tienen contenido.
 */
function datosCompletos(array $datos): bool
{
    return !in_array("", $datos, true);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $datos = obtenerDatosFormulario();

    if (!datosCompletos($datos)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (empty($errores)) {
        $sql = "INSERT INTO peliculas
                (titulo, director, duracion, genero, anio)
                VALUES (:titulo, :director, :duracion, :genero, :anio)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":titulo" => $datos["titulo"],
            ":director" => $datos["director"],
            ":duracion" => $datos["duracion"],
            ":genero" => $datos["genero"],
            ":anio" => $datos["anio"],
        ]);

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Crear películas</title>
</head>
<body>

<h1>Añadir película</h1>

<?php foreach ($errores as $error): ?>
    <p style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
<?php endforeach; ?>

<form method="POST">
    Título:
    <input type="text" name="titulo"
           value="<?= htmlspecialchars($datos["titulo"] ?? "", ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    Director:
    <input type="text" name="director"
           value="<?= htmlspecialchars($datos["director"] ?? "", ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    Duración:
    <input type="text" name="duracion"
           value="<?= htmlspecialchars($datos["duracion"] ?? "", ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    Género:
    <input type="text" name="genero"
           value="<?= htmlspecialchars($datos["genero"] ?? "", ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    Año:
    <input type="number" name="anio"
           value="<?= htmlspecialchars($datos["anio"] ?? "", ENT_QUOTES, "UTF-8") ?>">
    <br><br>

    <button type="submit">Guardar</button>
</form>

<a href="index.php">Volver</a>

</body>
</html>
