<?php
session_start();
if (!$_SESSION['loggedin']) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRIVADO</title>
</head>

<body>
    <nav>
        <a href="index.php">Inicio  </a>
        <a href="public.php">Publico  </a>
        <a href="logout.php">Salir</a>
    </nav>
    <h1>Pagina privada.</h1>
    <?php
    echo "<h2>Bienvenido " . $_SESSION["username"] . "</h2>";
    ?>
</body>

</html>