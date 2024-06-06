<?php
session_start();

// Configuración de la base de datos
$DB_SERVER = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB_NAME = "login_tuto";

// Conexión a la base de datos
$enlace = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Verificación de conexión
if ($enlace === false) {
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}

// Verificación de sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: lolillo.php");
    exit;
}

// Obtención del ID del usuario
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Consulta para obtener los artículos del carrito
    $sql = "SELECT articulo FROM carrito WHERE id_usuario = ?";
    if ($stmt = mysqli_prepare($enlace, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            // Verificación de resultados
            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $articulo);
                $productos = [];

                // Recopilación de artículos
                while (mysqli_stmt_fetch($stmt)) {
                    $productos[] = htmlspecialchars($articulo);
                }
            } else {
                $error_message = "No hay productos en tu carrito.";
            }
        } else {
            $error_message = "Error al ejecutar la consulta SQL.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Error al preparar la consulta SQL.";
    }
} else {
    $error_message = "ID de usuario inválido.";
}

mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(90deg, #974141, #e3520f);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: linear-gradient(90deg,#005f5f,#008cba);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        h2 {
            color:#fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .message {
            margin: 20px 0;
            padding: 15px;
            background-color: #ffdddd;
            border-left: 6px solid #f44336;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #008cba;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #005f5f;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($productos)): ?>
            <h2>Productos en tu carrito:</h2>
            <table>
                <tr>
                    <th>Producto</th>
                </tr>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (isset($error_message)): ?>
            <div class="message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <a href="index.php" class="back-button">Volver</a>
    </div>
</body>
</html>
