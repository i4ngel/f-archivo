<?php
include 'subir.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mi Formulario </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7f6fbdcfb8.js" crossorigin="anonymous"></script>
    <script src="parametro.js"></script>
    <!-- Resto de las etiquetas head -->
    <script>
        // Función para guardar la URL en el almacenamiento local
        function guardarURL() {
            var url = window.location.href; // Obtén la URL actual
            localStorage.setItem("miURL", url); // Guarda la URL en el almacenamiento local
        }

        // Evento de carga de página y recarga de página
        window.onload = function() {
            guardarURL(); // Llama a la función para guardar la URL cuando la página se carga
            var urlGuardada = localStorage.getItem("miURL"); // Obtiene la URL guardada
            if (urlGuardada) {
                console.log("La URL guardada es: " + urlGuardada);
            }
        };
    </script>


</head>

<body>

</br>
</br>
<div class="conteiner">
    <h1><strong>Easy File Converter</strong></h1>
    <h5>The easisest way to convert any file</h5>
</div>
<div class="agua">
 <div class="rectangulo">
    <div class="spinner">

        <form action="procesarArchivo.php" method="post" enctype="multipart/form-data">
    
        <!-- El atributo 'enctype' con el valor 'multipart/form-data' es necesario para subir archivos. -->
            
            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script><lottie-player src="https://lottie.host/e44b3843-6d0b-4174-a968-32470d9d96e3/l8GhsscPt8.json" background="#ffffff" speed="1" style="width: 150px; height: 150px" loop autoplay direction="1" mode="normal"></lottie-player>
            <h2><label for="archivo">Selecciona un archivo:</label></h2>

            <input type="file" class="btn btn-secondary" id="archivo" name="archivo" accept=".jpg, .png, .pdf"> </br> <br/>
        <!-- 'accept' limita los tipos de archivos que se pueden seleccionar. -->

            <button type="submit" class="btn-primary" value="Cargar archivo">
                <img width="40" height="40" src="https://img.icons8.com/pastel-glyph/64/FFFFFF/download--v1.png" alt="download--v1">
                Cargar archivo
            </button>
            <div class="letra">
                <p>or drop the files here</p>
            </div>
            </div>
            <div>
                <h6 class="xixi">By using our converter, you accept our <b>terms and conditions</b> of use our <strong> Privacy Policy</strong></h6>
            </div>
         
            <div class="card text-white">
                <img src="4.jpg" class="card-img">
                <div class="card-img-overlay"></div>
            </div>

        </form>

    </div>
</div>

        <title> Lista de Archivo </title>
        
        <br/>
<div class="clase">
    <div class="center">
        <div class="lola">
        
            <h2 class="o"><strong>Archivos Subidos:</strong></h2>
    
            <div id="file-list" class="pila">
                <?php
                $targetDir = "./descarga/";

                $files = scandir($targetDir);
                $files = array_diff($files, array('.', '..'));

                if (count($files) > 0) {
                echo "<table>";
                echo "<tr><th>Nombre del archivo</th><th>Descargar</th></tr>";
                foreach ($files as $file) {
                    $filePath = $targetDir . $file;
                    echo "<tr><td>$file</td><td><a href='$filePath' download class='boton-descargar'>Descargar</a></td></tr>";
                }
                echo "</table>";
                } else {
                echo "No se han subido archivos.";
                }
                ?>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
    $(document).ready(function() {
        function updateFileList() {
            $.ajax({
                url: 'update_file_list.php',  // Archivo PHP que generará la lista de archivos
                success: function(response) {
                    $('#file-list').html(response);  // Actualiza el contenido del contenedor
                },
                error: function() {
                    console.log('Error al actualizar la lista de archivos.');
                }
            });
        }

        // Actualizar la lista de archivos al cargar la página y después de cargar un nuevo archivo
        updateFileList();

        // Manejar la carga del archivo
        $('form').submit(function(e) {
            e.preventDefault();  // Evita la recarga de la página
            var formData = new FormData(this);
            
            $.ajax({
                url: 'procesarArchivo.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    updateFileList();  // Actualiza la lista de archivos después de cargar un archivo
                },
                error: function() {
                    console.log('Error al cargar el archivo.');
                }
            });
        });
    });
</script>

    
    
</body>
</html>

