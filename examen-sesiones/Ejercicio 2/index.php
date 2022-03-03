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

//Creación de noticias con session.
if (!isset($_SESSION["noticias"])) {
    $_SESSION["noticias"] = array(
        "videojuegos" => array("Videojuego1", "Videojuego2", "Videojuego3"),
        "Literatura" => array("Literatura1", "Literatura2"),
        "Cine" => array("Cine1", "Cine2", "Cine3", "Cine4"),
        "Series" => array("Series1", "Series2")
    );
}

$aUsuarios = array(
    array(
        'usuario' => 'editor',
        'psw' => 'editor',
        'perfil' => 'editor'
    ),
    array(
        'usuario' => 'redactor',
        'psw' => 'redactor',
        'perfil' => 'redactor'
    ),
);

//Validación y control de acceso
$user = $password = "";
$userErr = $passwordErr = "";
$error = false;
if (isset($_POST["login"])) {
    if (empty($_POST["user"])) {
        $userErr = "*Usuario requerido";
        $error = true;
    } else {
        $user = clearData($_POST["user"]);
    }
    if (empty($_POST["password"])) {
        $passwordErr = "*Contraseña requerida";
        $error = true;
    } else {
        $password = clearData($_POST["password"]);
    }
    if (!$error) {
        if (array_search($user, array_column($aUsuarios, 'usuario')) !== false) {//Buscamos si el usuario existe.
            $userIndex = array_search($user, array_column($aUsuarios, 'usuario'));
            if ($aUsuarios[$userIndex]["psw"] == $password) {// Si existe, comprovamos la contraseña.
                $_SESSION["currentUser"] = $aUsuarios[$userIndex];
            }
        } else {
            $userErr = "*Usuario o contraseña incorrectos";
            $passwordErr = "*Usuario o contraseña incorrectos";
        }
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
    <title>Noticias</title>
</head>

<body>
    <h1>Resumen de noticias.</h1>
    <?php
    //Para los editores:
    if (isset($_SESSION['currentUser']) and $_SESSION['currentUser']["perfil"] == "editor") {
        echo "<a href=\"crearcategoria.php\">Crear nueva categoria</a>";
    }
    //Para los redactores:
    if (isset($_SESSION['currentUser']) and $_SESSION['currentUser']["perfil"] == "redactor") {
        echo "<a href=\"crearnoticias.php\">Crear nueva noticia</a>";
    }
    ?>
    <!-- formulario de login -->
    <?php
    if (isset($_SESSION["currentUser"])) {
        echo "<a href=\"logout.php\">logout</a>";
    }
    if (isset($_SESSION["currentUser"])) {
        echo "<h2>Bienvenido " . $_SESSION["currentUser"]["usuario"] . "</h2>";
    } else {
    ?>
        <h1>Login</h1>
        <form action="index.php" method="POST">
            <label for="user">Usuario:</label>
            <input type="text" name="user" id="user">
            <span class="error"><?php echo $userErr; ?></span><br><br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password">
            <span class="error"><?php echo $passwordErr; ?></span><br><br>
            <input type="submit" name="login" value="Iniciar sesión">
        </form>
    <?php
    }
    ?>
    <ul>
        <?php
        foreach ($_SESSION["noticias"] as $categoria => $noticias) {
            echo "<li>$categoria</li>";
            echo "<ul>";
            foreach ($noticias as $noticia) {
                echo "<li>$noticia</li>";
            }
            echo "</ul>";
        }
        ?>
    </ul>
</body>

</html>