<?php

    session_start();
    require_once "conexion.php";
    $id = $_SESSION['id'];
    $_SESSION["id"] = $id;
    
    // Verifica si la variable de sesión 'id' está definida
    if(isset($_SESSION['id'])) {
        // Obtén la id de la sesión
        $id = $_SESSION['id'];
    
        // Realiza la consulta SQL para obtener el nombre del usuario
        $sql = "SELECT usuario FROM usuarios WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $id); // "i" indica que se espera un valor entero (la id)
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                // Verifica si se encontró un usuario con esa id
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $usuario);
                    
                    // Obtiene el nombre del usuario
                    if(mysqli_stmt_fetch($stmt)){
                        echo "Bienvenido, " . $usuario;
                    }
                } else {
                    echo "No se encontró ningún usuario con esa id.";
                }
            } else {
                echo "Error al ejecutar la consulta SQL";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la consulta SQL";
        }
    } else {
        echo "No se ha establecido la sesión correctamente.";
    }
    

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: lolillo.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido - MagtimusPro</title>
    <link rel="stylesheet" href="css/estilos.css">
    
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
<div class="lol">
    BIENVENIDO <?php echo $usuario ?>
</div>
   
<div class="ctn-welcome">
       
       <img src="images/logoEm.png" alt="" class="logo-welcome">
    
       <a href="lolillo.php" class="close-sesion">IR</a>
       
   </div>
   
   <div class="ctn-welcome">
       
       <img src="images/logoEm.png" alt="" class="logo-welcome">
      
       <a href="cerrar-sesion.php" class="close-sesion">Cerrar Sesión</a>
       
   </div>
   
   
    
</body>
</html>