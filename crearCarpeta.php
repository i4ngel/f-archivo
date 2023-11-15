
<?php

$nombreCarpeta = "mi_carpeta";

if (!file_exists($nombreCarpeta)) {
    try {
        mkdir($nombreCarpeta);
        
        
    } catch (Exception $e) {
        echo 'Error: ',  $e->getMessage(), "\n";
    }

} else {
    echo "La carpeta \"$nombreCarpeta\" ya existe.";
}
