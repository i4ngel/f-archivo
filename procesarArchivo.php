<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "./descarga/";
    $target_file = $target_dir . basename($_FILES["archivo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["archivo"]["tmp_name"]);
        if ($check !== false) {
            echo "El archivo es una imagen - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "El archivo no es una imagen.";
            $uploadOk = 0;
        }
    }

    // Verificar y crear el directorio si no existe
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Crea la carpeta con permisos
    }

    // Mover el archivo a la ubicación deseada
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $target_file)) {
            echo "Se subió el archivo " . basename($_FILES["archivo"]["name"]) . " exitosamente.";
        } else {
            echo "Hubo un error al subir el archivo.";
        }
    }
}


