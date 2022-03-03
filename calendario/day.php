<?php

/**
 * @author Carlos Hidalgo Risco
 */

session_start();

if(isset($_GET["day"])){
    $_SESSION["daySelected"] =  $_GET["day"];
    $_SESSION["monthSelected"] = $_GET["month"];
    $_SESSION["yearSelected"] = $_GET["year"];
}

if (isset($_GET["festivo"])) {
    $festivo = $_GET["festivo"];
    echo "<h2>$festivo</h2>";
}

if (!isset($_SESSION["array_tasks"][$_SESSION["yearSelected"] . $_SESSION["monthSelected"] . $_SESSION["daySelected"]])) {
    $_SESSION["array_tasks"][$_SESSION["yearSelected"] . $_SESSION["monthSelected"] . $_SESSION["daySelected"]] = array();
}

//add task
if (isset($_POST["new_task_submit"])) {
    $newTask = $_POST["new_task"];
    array_push($_SESSION["array_tasks"][$_SESSION["yearSelected"] . $_SESSION["monthSelected"] . $_SESSION["daySelected"]], $newTask);
}

//delete tasks
if (isset($_POST["delete_task_submit"])) {
    foreach ($_POST as $key => $task) {
        if ($task != "Eliminar tareas seleccionadas." and $task != "") {
            unset($_SESSION["array_tasks"][$_SESSION["yearSelected"] . $_SESSION["monthSelected"] . $_SESSION["daySelected"]][$task]);
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
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Dia <?php echo $_SESSION["daySelected"] . "/" . $_SESSION["monthSelected"] . "/" . $_SESSION["yearSelected"] ?></title>
</head>

<body>
    <a href="index.php">Volver al calendario.</a>
    <h1>Dia <?php echo $_SESSION["daySelected"] . "/" . $_SESSION["monthSelected"] . "/" . $_SESSION["yearSelected"] ?></h1>
    <h2>Tareas</h2>
    <form action="day.php" method="POST">
    <?php
    if (isset($_SESSION["array_tasks"][$_SESSION["yearSelected"] . $_SESSION["monthSelected"] . $_SESSION["daySelected"]])) {
        echo "<ul>";
        foreach ($_SESSION["array_tasks"][$_SESSION["yearSelected"] . $_SESSION["monthSelected"] . $_SESSION["daySelected"]] as $key => $task) {
            echo "<li><input type=\"checkbox\" value=\"$key\" name=\"$key\" id=\"$key\">$task</li>";
        }
        echo "</ul>";
    }
    ?>
        <input type="submit" name="delete_task_submit" value="Eliminar tareas seleccionadas.">
    </form>
    <br><br>
    <form action="day.php" method="POST">
        <label for="new_task">Nueva Tarea: </label>
        <input type="text" name="new_task" id="new_task">
        <input type="submit" name="new_task_submit" id="new_task_submit" value="Añadir">
    </form>
</body>

</html>