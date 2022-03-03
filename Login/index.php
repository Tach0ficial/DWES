<?php

function clearData($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);

    return $data;
}
session_start();
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}
$user = $password = "";
$userErr = $passwordErr = "";
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["user"])) {
        $userErr = "Usuario requerido";
        $error = true;
    } else {
        $user = clearData($_POST["user"]);
        if (!preg_match("/^[a-zA-Z0-9]*$/", $user)) {
            $userErr = "Solo letras y numeros";
            $error = true;
        }
    }
    if (empty($_POST["password"])) {
        $passwordErr = "Contraseña requerida";
        $error = true;
    } else {
        $password = clearData($_POST["password"]);
    }
    if (!$error) {
        if ($user == "usuario" && $password == "1234") {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $user;
        } else {
            $_SESSION["loggedin"] = false;
            $userErr = "Usuario o contraseña incorrectos";
            $passwordErr = "Usuario o contraseña incorrectos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <nav>
        <a href="index.php">Inicio </a>
        <a href="public.php">Publico  </a>
        <?php
        if ($_SESSION["loggedin"]) {
            echo "<a href=\"private.php\">Privado  </a>";
            echo "<a href=\"logout.php\">Salir</a>";
        }
        ?>
    </nav>
    <h1>Inicio (hint: user:usuario, password:1234)</h1>
    <?php
    if ($_SESSION["loggedin"]) {
        echo "<h2>Bienvenido " . $_SESSION["username"] . "</h2>";
    } else {
    ?>
        <form action="index.php" method="POST">
            <label for="user">Usuario</label>
            <input type="text" name="user" id="user">
            <span class="error"><?php echo $userErr; ?></span><br><br>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password">
            <span class="error"><?php echo $passwordErr; ?></span><br><br>
            <input type="submit" name="login" value="Iniciar sesión">
        </form>
    <?php
    }
    ?>

</body>

</html>