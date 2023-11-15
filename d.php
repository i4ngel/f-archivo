<?php
// Nombre de la carpeta a crear (obtenido del parámetro)
$carpetaNombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';

// Ruta donde deseas crear la carpeta (por ejemplo, en la carpeta 'descarga')
$carpetaRuta = "./descarga/" . $carpetaNombre;

try {
    // Verifica si la carpeta ya existe antes de crearla
    if (!file_exists($carpetaRuta)) {
        // Crea la carpeta con permisos adecuados (por ejemplo, 0755)
        mkdir($carpetaRuta, 0755, true);
        $mensaje = "Carpeta '$carpetaNombre' creada con éxito.";
    } else {
        $mensaje = "La carpeta '$carpetaNombre' ya existe.";
    }

    // Luego, cuando se procese un archivo, guárdalo en la carpeta creada
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['archivo'])) {
            $archivo = $_FILES['archivo'];

            if (move_uploaded_file($archivo['tmp_name'], $carpetaRuta . '/' . $archivo['name'])) {
                $subido = true;
                $mensaje = "Archivo subido con éxito.";
            } else {
                throw new Exception("Error al subir el archivo.");
            }
        }
    }

    // Verificar si se ha enviado una solicitud para eliminar un archivo
    if (isset($_POST['eliminarArchivo'])) {
        $archivoAEliminar = $_POST['eliminarArchivo'];
        $archivoRutaAEliminar = $carpetaRuta . '/' . $archivoAEliminar;

        if (file_exists($archivoRutaAEliminar)) {
            if (unlink($archivoRutaAEliminar)) {
                $mensaje = "Archivo '$archivoAEliminar' eliminado con éxito.";
            } else {
                throw new Exception("Error al eliminar el archivo.");
            }
        } else {
            throw new Exception("El archivo '$archivoAEliminar' no existe.");
        }
    }
} catch (Exception $e) {
    $mensaje = "Error: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Uploader</title>
    <script src="parametro.js"></script>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

    <div class="spn"> CARGA DE ARCHIVOS A LA CARPETA "<?php echo $carpetaNombre; ?>"</div>
    <div class="content">
    <div class="drop-area" id="drop-area">
            <form action="" id="form" method="POST" enctype="multipart/form-data">
                <img src="img/subir.png" class="upload" id="upload"> <br>
                <div class="input-group">
                <input type="file" name="archivo" class="form-control" id="archivo" aria-describedby="inputGroupFileAddon04" aria-label="Upload" onclick="notificacionSubida(<?php echo $subido ? 'true' : 'false'; ?>)">
                </div>
                <button class="Btn" type="Submit">  <img src="img/select.svg">  Subir Archivo</button>
                <label> O Arrastra aqui</label> <br>
                <!--BARRA DE PROGRESO-->
            <progress id="progressBar" value="0" max="100"></progress> 
            </form>
        </div>



        <div class="container2">
            <h2 class="o">Archivos Subidos:</h2>

            <div id="file-list" class="pila">
                <?php
                $targetDir = $carpetaRuta;

                $files = scandir($targetDir);
                $files = array_diff($files, array('.', '..'));

                if (count($files) > 0) {
                    echo "<table>";
                    echo "<tr><th>Nombre del archivo</th><th>Funciones</th></tr>";

                    foreach ($files as $file) {
                        echo "<tr><td>$file</td><td>
                            <a href='$carpetaRuta/$file' download class='boton-descargar'>Descargar</a> 
                            <form action='' method='POST' style='display:inline;'>
                                <input type='hidden' name='eliminarArchivo' value='$file'>
                                <input type='submit' class='boton-eliminar' value='Eliminar'>
                            </form>
                        </td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No se han subido archivos.";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="parametro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>