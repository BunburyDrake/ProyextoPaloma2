<?php



include("registrof.php")

if(insset($_POST['send'])){

    if(
        strlen($_POST['Nombre']) >= &&
        strlen($_POST['Apellido']) >= &&
        strlen($_POST['email']) >= &&
        strlen($_POST['Contraseña']) >= &&
    )
    {
        $Nombre = trim($_POST['Nombre']);
        $Apellido = trim($_POST['Apellido']);
        $email = trim($_POST['email']);
        $Contraseña = trim($_POST['Contraseña']);
        $consulta = "INSERT INTO datos(Nombre, Apellido, email, Contraseña)
                     VALUES ('$Nombre' , '$Apellido' , '$email' , '$Contraseña')";
        $resultado = mysqli_query($conn, $consulta);

        if($resultado){
            ?>
            <h3> tu registro se a completaod <h3>
                <?php
        }else{
            ?>
            <h3> tu registro se a completaod <h3>
            <?php

        }

    }
}

?>