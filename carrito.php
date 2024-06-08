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
    // Handle deletion request
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        $articulo = $_POST['articulo'];

        // Prepare a delete statement
        $sql = "DELETE FROM carrito WHERE id_usuario = ? AND articulo = ? LIMIT 1";
        if ($stmt = mysqli_prepare($enlace, $sql)) {
            mysqli_stmt_bind_param($stmt, "is", $id, $articulo);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<div class='message'>Artículo eliminado del carrito.</div>";
            } else {
                echo "<div class='message'>Error al eliminar el artículo.</div>";
            }
            
            mysqli_stmt_close($stmt);
        }
    }

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
        /* Estilos CSS mejorados */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(90deg, #974141, #e3520f);
            color: #ffffff;
            padding: 20px;
            margin: 0;
            line-height: 1.6;
            
        }

        .container {
            width: 80%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background-color:chocolate;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            color:#fff;
            border-bottom: 2px solid #e35;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        table {
            width: 100%;
            border-collapse:inherit;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #d8000c;
        }

        th, td {
            padding: 15px;
            text-align: left;
            font-size: 0.95em;
        }

        th {
            background-color: #f7f7f7;
            color:black;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color:burlywood;
        }

        .message {
            margin: 20px 0;
            padding: 15px;
            background-color: #ffdddd;
            border-left: 6px solid #f44336;
            color: #d8000c;
            font-size: 1em;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #0f7be3;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 1em;
        }

        .back-button:hover {
            background-color: #094e99;
            transform: scale(1.05);
        }

        .producto {
            color:black;
            font-weight: bold;
            font-size: 1em;
        }

        .delete-button {
            background-color: #e35;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #d8000c;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }
            
            th, td {
                padding: 10px;
            }
            
            .back-button {
                padding: 10px 20px;
                font-size: 0.9em;
            }
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
                    <th>Producto no deseado?</th>
                </tr>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td class="producto"><?php echo $producto; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="articulo" value="<?php echo $producto; ?>">
                                <input type="submit" name="delete" value="Eliminar" class="delete-button">
                            </form>
                        </td>
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
