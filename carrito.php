<?php
session_start();

$DB_SERVER = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB_NAME = "login_tuto";

// Establecer conexión
$enlace = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Comprobar conexión
if ($enlace === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Manejar la actualización de cantidad y eliminación de artículos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $id_carrito = $_POST['id_carrito'];
        $cantidad = $_POST['cantidad'];

        // Actualizar la cantidad en el carrito
        $sql = "UPDATE carrito SET cantidad = ? WHERE id_agg = ?";
        if ($stmt = mysqli_prepare($enlace, $sql)) {
            mysqli_stmt_bind_param($stmt, "ii", $cantidad, $id_carrito);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    if (isset($_POST['delete'])) {
        $id_carrito = $_POST['id_carrito'];

        // Eliminar el artículo del carrito
        $sql = "DELETE FROM carrito WHERE id_agg = ?";
        if ($stmt = mysqli_prepare($enlace, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id_carrito);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

// Obtener los artículos del carrito
$id_usuario = $_SESSION['id'];
$sql = "SELECT id_agg, articulo, cantidad FROM carrito WHERE id_usuario = ?";
$articulos = [];

if ($stmt = mysqli_prepare($enlace, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $articulo, $cantidad);

    while (mysqli_stmt_fetch($stmt)) {
        $articulos[] = [
            'id_agg' => $id,
            'articulo' => $articulo,
            'cantidad' => $cantidad,
        ];
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error al preparar la consulta: " . mysqli_error($enlace);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="css/estilos2.css">
</head>
<body>
<header>
    <a href="index.php"><img src="images/logoEm.png" width="75" height="90"></a>
    <h1>Carrito de Compras</h1>
</header>

<main>
    <table border="1px">
        <tr>
            <th>Artículo</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($articulos as $articulo): ?>
            <tr>
                <td><?php echo htmlspecialchars($articulo['articulo']); ?></td>
                <td>
                    <form action="carrito.php" method="POST">
                        <input type="hidden" name="id_carrito" value="<?php echo $articulo['id_agg']; ?>">
                        <input type="number" name="cantidad" value="<?php echo $articulo['cantidad']; ?>" min="1">
                        <input type="submit" name="update" value="Actualizar">
                    </form>
                </td>
                <td>
                    <form action="carrito.php" method="POST">
                        <input type="hidden" name="id_carrito" value="<?php echo $articulo['id_agg']; ?>">
                        <input type="submit" name="delete" value="Eliminar">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="index.php"><button>Seguir Comprando</button></a>
    <a href="checkout.php"><button>Proceder al Pago</button></a>
</main>
</body>
</html>
