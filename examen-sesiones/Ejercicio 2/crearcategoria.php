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

if (!isset($_SESSION['currentUser']) or $_SESSION['currentUser']["perfil"] != "editor") {
    header("Location: index.php");
}


$categoria = $categoriaErr = $categoria = $categoriaAgregada = "";
if (isset($_POST['agregar'])) {
    if (empty($_POST["categoria"])) {
        $categoriaErr = "Categoria requerida";
        $error = true;
    } else {
        $categoria = clearData($_POST["categoria"]);
        $_SESSION["noticias"][$categoria] = array();
        $categoriaAgregada = "Categoria agregada correctamente";  
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
    <title>Crear nueva categoria</title>
</head>

<body>
    <h1>Crear nueva categoria</h1><a href="index.php">Noticias</a><br><br><br>
    <form action="crearcategoria.php" method="POST">
        <label for="noticia">Indica la nueva categoria</label>
        <input type="text" name="categoria" id="categoria">
        <span class="success"><?php echo $categoriaAgregada; ?></span>
        <span class="error"><?php echo $categoriaErr; ?></span><br><br>
        <input type="submit" value="Agregar" name="agregar">
    </form>
</body>

</html>