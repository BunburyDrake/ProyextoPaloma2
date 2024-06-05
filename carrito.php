<?php
session_start();
$DB_SERVER = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB_NAME = "login_tuto";


$enlace = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);


if ($enlace === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: lolillo.php");
    exit;
}


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
   
    $sql = "SELECT articulo FROM carrito WHERE id_usuario = ?";
    if ($stmt = mysqli_prepare($enlace, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

        
            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $articulo);
                
                echo "<h2>Productos en tu carrito:</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Producto</th>
                        </tr>";
                
              
                while (mysqli_stmt_fetch($stmt)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($articulo) . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "No hay productos en tu carrito.";
            }
        } else {
            echo "Error al ejecutar la consulta SQL.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta SQL.";
    }
} else {
    echo "ID de usuario inválido.";
}

mysqli_close($enlace);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
</head>
<body>
    
    <a href="index.php"><button>Volver</button></a>
</body>
</html>
