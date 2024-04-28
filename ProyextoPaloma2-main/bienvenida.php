<?php

    session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
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
    BIENVENIDO
</div>
   
<div class="ctn-welcome">
       
       <img src="logoEm.png" alt="" class="logo-welcome">

       <a href="lolillo.html" class="close-sesion">IR</a>
       
   </div>
   
   <div class="ctn-welcome">
       
       <img src="logoEm.png" alt="" class="logo-welcome">
      
       <a href="cerrar-sesion.php" class="close-sesion">Cerrar Sesión</a>
       
   </div>
   
   
    
</body>
</html>