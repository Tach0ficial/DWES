<?php

/**
 * @author Carlos Hidalgo Risco
 */

session_start();
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == 'admin' && $password == 'admin') {
        $_SESSION['loggedin'] = true;
    }else{
        $_SESSION['loggedin'] = false;
    }
}
if (isset($_POST['submit'])) {
    define("MAXSIZE", 2097152);
    define("DIR_UPLOAD", "upload/");
    $allowedExts = array("jpg", "jpeg", "gif", "png");
    $allowedFormats = array("image/jpg", "image/jpeg", "image/gif", "image/png", "image/x-png");
    $extension = explode(".", $_FILES["file"]["name"]);
    $extension = strtolower(end($extension));
    $format = $_FILES["file"]["type"];
    $size = $_FILES["file"]["size"];
    $error = $_FILES["file"]["error"];
    $name = 
    substr($_FILES["file"]["name"], 0,strrpos($_FILES["file"]["name"], ".")). 
    getdate()["year"] . 
    getdate()["mon"] . 
    getdate()["mday"] . 
    getdate()["hours"] . 
    getdate()["minutes"] . 
    getdate()["seconds"].".".$extension;
    if (
        $size <= MAXSIZE
        && in_array($format, $allowedFormats)
        && in_array($extension, $allowedExts)
        && $error == 0
        && $name != ""
    ) {
        echo "Foto subida.<br>";
        if (move_uploaded_file($_FILES["file"]["tmp_name"], DIR_UPLOAD . $name)) {
            echo "La foto " .  basename($_FILES["file"]["name"]) .
                " ha sido subido correctamente.";
        } else {
            echo "Ha ocurrido un error al subir la foto.";
        }
    } else {
        echo "Error al subir la foto.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir fotos.</title>
</head>

<body>
    <h1>Subida de fotos.</h1>
    
    <a href="gallery.php">Galeria de fotos.</a> 
    <?php
    if ($_SESSION['loggedin']) {
    ?>
    <h3>Bienvenido admin.</h3>
    <a href="logout.php">Cerrar sesion.</a><br><br>
    <form action="upload_file.php" method="post" enctype="multipart/form-data">
        <label for="file">Foto: </label>
        <input type="file" name="file" id="file"><br /><br>
        <input type="submit" name="submit" value="Subir foto">
    </form>
    <?php
    } else {
        echo "<h1>Debes iniciar sesion para subir fotos.</h1>";
    ?>
    <form action="upload_file.php" method="post">
        <label for="username">Usuario: </label>
        <input type="text" name="username" id ="username"><br /><br>
        <label for="password">Contraseña: </label>
        <input type="password" name="password" id="password"><br /><br>
        <input type="submit" name="login" value="Iniciar sesion">
    </form>
    <?php
    }
    ?>
</body>

</html>