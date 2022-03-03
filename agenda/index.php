<?php

/**
 * Proyecto de agenda de contractos.
 * 
 * @author Carlos Hidalgo Risco
 */

session_start();
if (isset($_POST['delete'])) {
    unset($_SESSION['contracts']);
}
if (!isset($_SESSION['contracts'])) {
    $_SESSION['contracts'] = array();
}

function clearData($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);

    return $data;
}
$tlfnoErr = $nameErr = "";
$lerror = false;
if (isset($_POST['add'])) {
    //Validate name
    if (empty($_POST["tlfno"])) {
        $tlfnoErr = "Name is required";
        $lerror = true;
    } else {
        $name = clearData($_POST["name"]);
    }

    //Validate telephone
    if (empty($_POST["tlfno"])) {
        $nameErr = "Telephone is required";
        $lerror = true;
    } elseif (strlen(clearData($_POST["tlfno"])) != 9) {
        $tlfnoErr = "Telephone must be 9 digits";
        $lerror = true;
    } else {
        $tlfno = clearData($_POST["tlfno"]);
    }

    if (!$lerror) {
        array_push($_SESSION['contracts'], array("name" => $name, "tlfno" => $tlfno));
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Carlos Hidalgo Risco">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de contactos.</title>
</head>

<body>
    <h1>Agenda de contactos.</h1>
    <a href="enviar_correo.php">Enviar correo.</a>
    <a href="cerrar_sesion.php">Cerrar sesión.</a>
    <form action="index.php" method="POST">
        <label for="name">Nombre:
            <input type="text" name="name" id="name">
        </label>
        <span class="error">*<?php echo $nameErr; ?></span>
        <br><br>
        <label for="tlfno">Telefono:
            <input type="tel" name="tlfno" id="tlfno">
        </label>
        <span class="error">*<?php echo $tlfnoErr; ?></span>
        <br><br>
        <input type="submit" value="Añadir" name="add">

    </form>
    <?php
    foreach ($_SESSION['contracts'] as $contrac) {
        echo $contrac["name"] . " " . $contrac["tlfno"] . "<br>";
    }
    ?>
    <form action="index.php" method="POST">
        <input type="submit" value="Borrar agenda." name="delete">
    </form>
</body>

</html>