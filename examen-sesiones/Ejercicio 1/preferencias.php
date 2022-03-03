<?php

/**
 * @author Carlos Hidalgo Risco
 */
$noticias = array(
    "videojuegos" => array("Videojuego1", "Videojuego2", "Videojuego3"),
    "Literatura" => array("Literatura1", "Literatura2"),
    "Cine" => array("Cine1", "Cine2", "Cine3", "Cine4"),
    "Series" => array("Series1", "Series2")
);

if (isset($_POST["enviar"])) {
    setcookie("preferencias[videojuegos]", isset($_POST["videojuegos"])  ? "true" : "false", time() + (86400 * 30));
    setcookie("preferencias[Literatura]", isset($_POST["Literatura"]) ? "true" : "false", time() + (86400 * 30));
    setcookie("preferencias[Cine]", isset($_POST["Cine"]) ? "true" : "false", time() + (86400 * 30));
    setcookie("preferencias[Series]", isset($_POST["Series"]) ? "true" : "false", time() + (86400 * 30));
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Carlos Hidalgo Risco">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferencias</title>
</head>

<body>
    <h1>Preferencias.</h1><a href="index.php">Salir</a>
    <form action="preferencias.php" method="POST">
        <?php
        foreach ($noticias as $categoria => $noticia) {
            echo "<input type=\"checkbox\" value=\"true\" name=\"$categoria\" id=\"$categoria\"";
            if ($_COOKIE["preferencias"][$categoria]=="true") {
                echo " checked ";
            }
            echo " >";
            echo "<label for=\"$categoria\">$categoria</label><br>";
        }
        ?>
        <input type="submit" name="enviar" value="Enviar">
    </form>
</body>

</html>