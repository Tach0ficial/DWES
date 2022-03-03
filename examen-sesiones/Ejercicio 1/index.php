<?php

/**
 * @author Carlos Hidalgo Risco
 */

// Creamos las COOKIES
if (!isset($_COOKIE["expire"])) {
    setcookie("preferencias[videojuegos]", "false", time() + (86400 * 30));
    setcookie("preferencias[Literatura]", "false",time() + (86400 * 30));
    setcookie("preferencias[Cine]", "false",time() + (86400 * 30));
    setcookie("preferencias[Series]", "false",time() + (86400 * 30));
    setcookie("expire", "false",time() + (86400 * 30));
}

$noticias = array(
    "videojuegos" => array("Videojuego1", "Videojuego2", "Videojuego3"),
    "Literatura" => array("Literatura1", "Literatura2"),
    "Cine" => array("Cine1", "Cine2", "Cine3", "Cine4"),
    "Series" => array("Series1", "Series2")
);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Carlos Hidalgo Risco">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
</head>

<body>
    <h1>Resumen de noticias.</h1><a href="preferencias.php">Setting</a>
    <ul>
        <?php
        $hasNoticias = false;// Variable para saber si hay noticias
        foreach ($noticias as $categoria => $noticia) {
            if ($_COOKIE["preferencias"][$categoria] == "true") {
                $hasNoticias = true;
                echo "<li>$categoria</li>";
                echo "<ul>";
                foreach ($noticia as $not) {
                    echo "<li>$not</li>";
                }
                echo "</ul>";
            }
        }
        ?>
    </ul>
    <?php
    if (!$hasNoticias) {
        echo "<p>No hay noticias que mostrar</p>";
    }
    ?>
</body>

</html>