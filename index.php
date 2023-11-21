<?php
$carpetaNombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$carpetaRuta = "./descarga/" . $carpetaNombre;

try {
    if (!file_exists($carpetaRuta)) {
        mkdir($carpetaRuta, 0755, true);
        $mensaje = "Carpeta '$carpetaNombre' creada con éxito.";
    } else {
        $mensaje = "La carpeta '$carpetaNombre' ya existe.";
    }

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
</head>

<body>
    <div class="title1">
        <span class="uno"> UPLOAD </span> <span class="dos"> FILES</span></SPAN>
    </div>
    <div class="content">
        <div class="title2"> CARGA DE ARCHIVOS A LA CARPETA "<?php echo $carpetaNombre; ?>"</div>
        <div class="container">
            <div class="drop-area" id="drop-area">
                <form action="" id="form" method="POST" enctype="multipart/form-data">
                    <img src="img/up.png" class="upload" id="upload"> <br>
                    <input type="file" class="file-input" name="archivo" id="archivo" onchange="document.getElementById('form').submit()">
                    <label> Arrastra tus archivos aquí</label> <br>
                    <label>  -------------------- O -------------------- </label> <br>
                    <label style="color: blue; font-weight: bold;"> Abre el explorador </label> <br>
                    <!-- Eliminado el botón de subir manualmente -->
                    <!-- <button class="Btn" type="Submit" value="Subir archivo"> <img src="img/select.svg" style="color: white;">Subir archivo </button> -->
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
    </div>

    <script src="parametro.js"></script>

</body>

</html>
