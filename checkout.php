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

// Obtener los artículos del carrito
$id_usuario = $_SESSION['id'];
$sql = "SELECT articulo, cantidad FROM carrito WHERE id_usuario = ?";
$osarticul = [];

if ($stmt = mysqli_prepare($enlace, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $articulo, $cantidad);

    while (mysqli_stmt_fetch($stmt)) {
        $articulos[] = [
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
    <title>Checkout</title>
    <link rel="stylesheet" href="css/estilos2.css">
</head>
<body>
<header>
    <a href="index.php"><img src="images/logoEm.png" width="75" height="90"></a>
    <h1>Checkout</h1>
</header>

<main>
    <h2>Resumen del Pedido</h2>
    <table border="1px">
        <tr>
            <th>Artículo</th>
            <th>Cantidad</th>
        </tr>
        <?php foreach ($articulos as $articulo): ?>
            <tr>
                <td><?php echo htmlspecialchars($articulo['articulo']); ?></td>
                <td><?php echo $articulo['cantidad']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Aquí puedes agregar un formulario de pago o botones de pago con la pasarela de pago que desees -->

    <a href="index.php"><button>Seguir Comprando</button></a>
</main>
</body>
</html>
