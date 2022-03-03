<?php
/**
 * Proyecto de agenda de contractos.
 * 
 * @author Carlos Hidalgo Risco
 */
session_start();
if (!isset($_SESSION['contracts'])) {
   header('Location: index.php');
}
function clearData($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);

    return $data;
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
    <h1>Agenda de contactos</h1>
    <a href="index.php">Volver a la agenda de contactos.</a>
    <a href="cerrar_sesion.php">Cerrar sesión.</a>
    <h2>Seleccionar destinatario.</h2>
    <form action="enviar_correo.php" method="POST">
    <?php
        foreach ($_SESSION['contracts'] as $contrac) {
            echo $contrac["name"]." ".$contrac["tlfno"]."<br>";
        }
    ?>
    </form>
</body>
</html>