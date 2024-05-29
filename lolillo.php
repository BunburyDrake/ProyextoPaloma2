<!DOCTYPE html>
<html lang="es">
<head color="ORANGE">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renta de Muebles para Fiestas</title>
    <link rel="stylesheet" href="css/estilos2.css">
    
</head>
<body  class="background1">
    
  

    <header>
        <a href="cerrar-sesion.php"><img src="images/logoEm.png" width="75" height="90"></a>
        
    </header>

    <!-- Barra de búsqueda -->
    <div class="search-bar">
       
        <input type="text" id="search-input" placeholder="Buscar artículo...">
    <button onclick="buscarArticulo()"><img src="images/iconL.png" width="30" height="30"><h3>Buscar</h3></button>
   
    </div>
    
<div>
    
</div>
<aside class="Precios">
   <table border="1px">
    <tr>
        <center><td>articulo</td><td>precio</td><td>unidades</td><td>capacidad</td></center>
    </tr>
    <tr>
        <center><td>Mantel de Plastico </td><td>50</td><td>1</td><td>10 personas</td></center>

    </tr>
    <tr>
        <center><td>Carpa Fiesta</td><td>2000</td><td>1</td><td>50 personas</td></center>

    </tr>
    <tr>
        <center><td>Mesas Plegables Plastico </td><td>1000</td><td>1</td><td>30 personas</td></center>

    </tr>
    <tr>
        <center><td>Sillas Plegables de Plastico </td><td>1500</td><td>50</td><td>50 personas</td></center>

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
    

    <!-- Aquí puedes agregar la lista de artículos disponibles -->
    <section id="lista-articulos">
        <!-- Ejemplo: -->
        <a href="MesaN.html">
            <div class="sillas" >
            <h3>Mantel de plástico negro</h3>
            <img src="images/mantelN.png" width="200" height="200">
        </a>
        <center></center><button onclick="agregarAlCarrito('Mantel de plástico negro')">Agregar al carrito</button>
        </div>
        
   
        <div class="Mesa">
            <a href="Mesa.html">
            <h3>Mesa</h3>
        </a>
        <img src="images/mesa.png" width="200" height="200">
            <p>Mesa de Plastico 10x5</p>
        </div>
   
        <div class="Carpa 1">
            <a href="CarpaG.html">
            <h3>Carpa Grande</h3>
        </a>
        <img src="images/CarpaGr.png" width="200" height="200">
            <p>Carpa para 50 personas</p>
        </div>
        
        <div class="Sillas">
            <a href="sillas.html">
            <h3>Sillas</h3></a>
            <img src="images/silla.png" width="200" height="200">
            <p>Sillas Plegables</p>
        </div>
       
    </section>

   <center> <ul class="pagination">
        <li class="active">1</li>

        <li ><a href="Pestaña2.html">2</a></li>
        
        <!-- ... Agrega más números de página aquí ... -->
    </ul></center>
    <script>
        // Función para buscar un artículo
        function buscarArticulo() {
    const input = document.getElementById('search-input').value.toLowerCase(); // Obtener el valor de búsqueda y convertirlo a minúsculas para ser insensible a mayúsculas y minúsculas
    const articulos = document.querySelectorAll('#lista-articulos > div'); // Obtener todos los elementos de la lista de artículos

    // Iterar sobre cada artículo para comprobar si coincide con el término de búsqueda
    articulos.forEach(articulo => {
        const nombreArticulo = articulo.querySelector('h3').textContent.toLowerCase(); // Obtener el nombre del artículo y convertirlo a minúsculas
        if (nombreArticulo.includes(input)) {
            articulo.style.display = 'block'; // Mostrar el artículo si coincide
        } else {
            articulo.style.display = 'none'; // Ocultar el artículo si no coincide
        }
    });
}
        const carrito = [];

        function agregarAlCarrito(nombreProducto, cantidad) {
            const productoExistente = carrito.find(item => item.nombre === nombreProducto);

            if (productoExistente) {
                productoExistente.cantidad += cantidad;
            } else {
                carrito.push({ nombre: nombreProducto, cantidad });
            }

            localStorage.setItem('carrito', JSON.stringify(carrito));
            alert(`Se agregaron ${cantidad} ${nombreProducto} al carrito.`);
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
</body>
</html>