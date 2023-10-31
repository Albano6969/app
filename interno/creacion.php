<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css"> <!-- Agrega tu hoja de estilos CSS -->
    <title>Formulario de Ingreso de Datos</title>
    
</head>
<body>
<?php 
    include 'form/nav.php';
    ?> 
    <h1>Formulario de Ingreso de Datos</h1>

    <div class="container" id="formulario-container">
        <!-- El contenido del formulario seleccionado se cargará aquí -->
    </div>




   
   
 <!-- Div para mostrar el mensaje (inicialmente oculto) -->
 <div id="mensaje" class="popup"></div>
 <script>
        // Función para cargar un formulario en el contenedor central
        function cargarFormulario(url) {
            var container = document.getElementById("formulario-container");
            container.innerHTML = ''; // Limpiar el contenedor
            var iframe = document.createElement('iframe');
            iframe.src = url;
            iframe.style.width = "100%";
            iframe.style.height = "80vh"; // Ajustar la altura según sea necesario
            iframe.onload = function() {
        // Esta función se ejecutará cuando el iframe se cargue
        mostrarMensajeExito();
        container.removeChild(iframe);
    };
            container.appendChild(iframe);
        }
    </script>
<script>
    // Función para mostrar el mensaje con el estilo especificado y luego ocultarlo después de unos segundos
    function mostrarMensaje(mensaje, estilo) {
        var mensajeDiv = document.getElementById("mensaje");
        mensajeDiv.textContent = mensaje;
        mensajeDiv.className = "popup " + estilo;
        mensajeDiv.style.display = "block";
        setTimeout(function () {
            mensajeDiv.style.display = "none";
        }, 3000); // El mensaje se ocultará después de 3 segundos (3000 ms)
    }

    // Verificar si el parámetro "exito" está presente en la URL y mostrar un mensaje de éxito
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('exito')) {
        mostrarMensaje("Creado correctamente", "success");
    }

    // Verificar si el parámetro "error" está presente en la URL y mostrar un mensaje de error
    if (urlParams.has('error')) {
        mostrarMensaje("No se ha podido ingresar los datos", "error");
    }

    
    
</script>
   
</body>
</html>
