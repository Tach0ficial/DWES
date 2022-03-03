<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Superheroes</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <a class="navbar-brand" href="./">Superheroes</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="./">Lista</a>
                </li>
                <?php
                if ($_SESSION["perfil"] == "superheroe" || $_SESSION["perfil"] == "superheroeExperto") {
                    echo "<li class=\"nav-item active\">";
                    echo    "<a class=\"nav-link\" href=\"./newHabilidad\">Añadir habilidad</a>";
                    echo "</li>";
                    echo "<li class=\"nav-item active\">";
                    echo    "<a class=\"nav-link\" href=\"./peticiones\">Peticiones</a>";
                    echo "</li>";
                }
                if ($_SESSION["perfil"] == "superheroeExperto") {
                    echo "<li class=\"nav-item active\">";
                    echo    "<a class=\"nav-link\" href=\"./add\">Añadir superheroe</a>";
                    echo "</li>";
                }
                ?>
            </ul>
            <?php
            if ($_SESSION["perfil"] == "invitado") {
                echo "<a href=\"./login\" class=\"btn btn-outline-success my-2 my-sm-0\">Login</a>";
                echo "<a href=\"./signup\" class=\"btn btn-outline-success my-2 my-sm-0\">Sign Up</a>";
            } else {
                echo "<a href=\"./logout\" class=\"btn btn-outline-success my-2 my-sm-0\">Logout</a>";
            }
            ?>

        </div>
    </nav>