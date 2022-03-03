<?php

/**
 * @author Carlos Hidalgo Risco
 */
session_start();
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria de fotos.</title>
</head>

<body>
    <h1>Galeria de fotos.</h1>
    <a href="upload_file.php">Subir fotos.</a><br><br>
    
    <?php
    if ($_SESSION['loggedin']) {
       echo "<a href=\"logout.php\">Cerrar sesion.</a><br><br>";
    }
    define("DIR_UPLOAD", "upload");
    $dir = dir(DIR_UPLOAD);
    while (($archivo = $dir->read()) !== false) {
        $extension = explode(".", $archivo);
        $extension = strtolower(end($extension));
        if ("gif" == $extension || "jpg" == $extension || "png" == $extension) {
            echo '<img width="350px"  height="250px" src="' . DIR_UPLOAD . "/" . $archivo . '">' . "\n";
        }
    }
    $dir->close();
    ?>
</body>

</html>