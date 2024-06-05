<?php
$DB_SERVER = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB_NAME = "login_tuto";

// Establish connection
$enlace = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if ($enlace === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="es">
<head color="ORANGE">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renta de Muebles para Fiestas</title>
    <link rel="stylesheet" href="css/estilos2.css">
</head>
<body class="background1">

<header>
    <a href="cerrar-sesion.php"><img src="images/logoEm.png" width="75" height="90"></a>
    <?php
    session_start();
    $id = $_SESSION['id'];
    $_SESSION["id"] = $id;

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];

        $sql = "SELECT usuario FROM usuarios WHERE id = ?";
        if ($stmt = mysqli_prepare($enlace, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $usuario);

                    if (mysqli_stmt_fetch($stmt)) {
                        echo "Usuario: " . $usuario;
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

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: lolillo.php");
        exit;
    }
    ?>
    <a href="carrito.php?id=<?php echo $id; ?>"><button>Ver Carrito</button></a>
</header>


<div class="search-bar">
    <input type="text" id="search-input" placeholder="Buscar artículo...">
    <button onclick="buscarArticulo()"><img src="images/iconL.png" width="30" height="30"><h3>Buscar</h3></button>
</div>

<div></div>
<aside class="Precios">
    <table border="1px">
        <tr>
            <center><td>articulo</td><td>precio</td><td>unidades</td><td>capacidad</td></center>
        </tr>
        <tr>
            <center><td>Mantel de Plastico</td><td>50</td><td>1</td><td>10 personas</td></center>
        </tr>
        <tr>
            <center><td>Carpa Fiesta</td><td>2000</td><td>1</td><td>50 personas</td></center>
        </tr>
        <tr>
            <center><td>Mesas Plegables Plastico</td><td>1000</td><td>1</td><td>30 personas</td></center>
        </tr>
        <tr>
            <center><td>Sillas Plegables de Plastico</td><td>1500</td><td>50</td><td>50 personas</td></center>
        </tr>
    </table>
</aside>
<button onclick="togglePrecio()">Mostrar/ocultar Precios</button>
<aside class="contact-info">
    <h2>Contacto</h2>
    <p>Teléfono: <a href="tel:+123456789">123-456-789</a></p>
    <p>Correo electrónico: <a href="mailto:PartyEventRent@gmail.com">PartyEventRent@gmail.com</a></p>
</aside>
<button onclick="toggleContactInfo()">Mostrar/ocultar información de contacto</button>
<aside class="Video">
    <video class="video" src="An8uXNGAVgffOAihVqosfWAIrDNUNidXimUP57NtJpdNYuzYq18v8FmeH7YiLPHuyAJxMZoDhotzqleS7nU9iCrm.mp4" controls autoplay preload="autoplay" poster="logoEm.png" loop></video>
</aside>
<button onclick="toggleVideo()">Mostrar/ocultar Video</button>

    <section id="lista-articulos">
        <!-- Ejemplo: -->
        <a href="MesaN.html">
            <div class="sillas" >
            <h3>Mantel de plástico negro</h3>
            <img src="images/mantelN.png" width="200" height="200">
        </a>
        <form action="" method="POST">
        <?php
        $producto = "Mantel de Plastico Negro";
        ?>
        <input type="hidden" name="producto" value="<?php echo $producto; ?>">
        <input type="submit" name="registro" value="Agregar al carrito">
    </form>
        </div>
        
   
        <div class="Mesa">
            <a href="Mesa2.html">
            <h3>Mesa Blanca</h3>
        
        <img src="images/Mesa2.png" width="200" height="200">
            <p>Mesa de Plastico Blanca 10x5</p>
        </a>
        <form action="" method="POST">
        <?php
        $producto = "Mesa Blanca";
        ?>
        <input type="hidden" name="producto" value="<?php echo $producto; ?>">
        <input type="submit" name="registro" value="Agregar al carrito">
    </form>
        </div>
   
        <div class="Carpa 1">
            <a href="CarpaG.html">
            <h3>Carpa Grande</h3>
        
        <img src="images/CarpaGr.png" width="200" height="200">
            <p>Carpa para 50 personas</p>
        </a>
        <form action="" method="POST">
        <?php
        $producto = "Carpa Grande";
        ?>
        <input type="hidden" name="producto" value="<?php echo $producto; ?>">
        <input type="submit" name="registro" value="Agregar al carrito">
    </form>
        </div>
        
        <div class="Sillas">
            <a href="silla2.html">
            <h3>Sillas</h3>
            <img src="images/sillaB.jpg" width="200" height="200">
            <p>Sillas Imitacion Madera</p>
        </a>
        <form action="" method="POST">
        <?php
        $producto = "Sillas Imitacion Madera";
        ?>
        <input type="hidden" name="producto" value="<?php echo $producto; ?>">
        <input type="submit" name="registro" value="Agregar al carrito">
    </form>
        </div>
       
    </section>

   <center> <ul class="pagination">
        <li ><a href="lolillo.php">1</a></li>
        <li class="active">2</li>
        
        <!-- ... Agrega más números de página aquí ... -->
    </ul></center>
    <script>
    function buscarArticulo() {
        const input = document.getElementById('search-input').value.toLowerCase();
        const articulos = document.querySelectorAll('#lista-articulos > div');

        articulos.forEach(articulo => {
            const nombreArticulo = articulo.querySelector('h3').textContent.toLowerCase();
            if (nombreArticulo.includes(input)) {
                articulo.style.display = 'block';
            } else {
                articulo.style.display = 'none';
            }
        });
    }

    function toggleContactInfo() {
        const contactInfo = document.querySelector('.contact-info');
        contactInfo.style.display = (contactInfo.style.display === 'none') ? 'block' : 'none';
    }

    function togglePrecio() {
        const Precios = document.querySelector('.Precios');
        Precios.style.display = (Precios.style.display === 'none') ? 'block' : 'none';
    }

    function toggleVideo() {
        const Video = document.querySelector('.Video');
        Video.style.display = (Video.style.display === 'none') ? 'block' : 'none';
    }
</script>
<?php
if (isset($_POST['registro'])) {
    $nom = $_POST['producto'];
    $idu = $_SESSION["id"];

    
    $ingresar = "INSERT INTO carrito (articulo, id_usuario) VALUES ('$nom', '$idu')";
    $ejecutar = mysqli_query($enlace, $ingresar);

    if ($ejecutar) {
        echo "Producto agregado al carrito correctamente.";
    } else {
        echo "Error al agregar el producto al carrito: " . mysqli_error($enlace);
    }
}
?>
</body>
</html>