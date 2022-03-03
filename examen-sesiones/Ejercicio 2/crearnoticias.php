<?php

/**
 * @author Carlos Hidalgo Risco
 */
session_start();

function clearData($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);

    return $data;
}

if (!isset($_SESSION['currentUser']) or $_SESSION['currentUser']["perfil"] != "redactor") {
    header("Location: index.php");
}

$noticia = $noticiaErr = $categoria = $noticiaAgregada = "";
if (isset($_POST['agregar'])) {
    if (empty($_POST["noticia"])) {
        $noticiaErr = "Noticia requerida";
        $error = true;
    } else {
        $noticia = clearData($_POST["noticia"]);
        $categoria = $_POST["categoria"];
        array_push($_SESSION["noticias"][$categoria],$noticia);
        $noticiaAgregada = "Noticia agregada correctamente";  
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Carlos Hidalgo Risco">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Crear nueva noticia</title>
</head>

<body>
    <h1>Crear nueva noticia</h1><a href="index.php">Noticias</a><br><br><br>
    <form action="crearnoticias.php" method="POST">
        <label for="titulo">Indica en que categoria quieres meter la noticia:</label>   
        <br>
        <?php
            foreach ($_SESSION["noticias"] as $keyCategoria => $categoria) {
                echo "<input type=\"radio\" value=\"$keyCategoria\" name=\"categoria\" id=\"categoria\">".$keyCategoria;
                echo "<br>";
            }
        ?>
        <br><br>
        <label for="noticia">Indica la nueva noticia</label>
        <input type="text" name="noticia" id="noticia">
        <span class="success"><?php echo $noticiaAgregada; ?></span>
        <span class="error"><?php echo $noticiaErr; ?></span><br><br>
        <input type="submit" value="Agregar" name="agregar">
    </form>
</body>

</html>