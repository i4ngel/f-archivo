
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
