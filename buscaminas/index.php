<?php

/**
 * @author Carlos Hidalgo Risco
 */
session_start();

if (!isset($_SESSION['play'])) {
    $_SESSION['play'] = false;
    $_SESSION['size'] = 0;
    $_SESSION['booms'] = 0;
}

$sizeErr = $boomsErr = "";
$error = false;
if (isset($_POST['play'])) {
    if (empty($_POST['size'])) {
        $error = true;
        $sizeErr = "Introduce el tamaño del tablero.";
    } elseif ($_POST['size'] > 20 || $_POST['size'] < 5) {
        $error = true;
        $sizeErr = "Tamaño del tablero incorrecto.";
    } else {
        $_SESSION['size'] = $_POST['size'];
    }
    if (empty($_POST['booms'])) {
        $error = true;
        $boomsErr = "Introduce el número de minas";
    } elseif ($_POST['booms'] > ($_POST['size']*$_POST['size'])-5 || $_POST['booms'] < 10) {
        $error = true;
        $boomsErr = "Numero de bombas incorrecto.";
    } else {
        $_SESSION['booms'] = $_POST['booms'];
    }
    if (!$error) {
        $_SESSION['play'] = true;
    }
}
//numero de minas
define("BOOMS", $_SESSION['booms']);

//tamaño del Tablero vacio con zeros
define("SIZE",  $_SESSION['size']);

if (isset($_POST['play'])) {
    initBoard();
}

function showBoard()
{
    echo "<table id='board' border='1'>";
    for ($fila = 0; $fila < SIZE; $fila++) {
        echo "<tr>";
        for ($columna = 0; $columna < SIZE; $columna++) {
            if ($_SESSION['aVisible'][$fila][$columna] === 1) {
                if ($_SESSION['atablero'][$fila][$columna] === 0) {
                    echo "<td class='box_open'></td>";
                } else {
                    echo "<td class='box_open'>" . $_SESSION['atablero'][$fila][$columna] . "</td>";
                }
            } else {
                //comprobando si tenemos que deshabilitar los botones
                echo (isWinner() or isLoser())  ? "<td><a><div class='box_close'></div></a></td>" : "<td><a href='index.php?row=$fila&col=$columna'><div class='box_close'></div></a></td>";
            }
        }
        echo "</tr>";
    }
    echo "</table>";
}

function initBoard()
{
    $_SESSION['atablero'] = array();
    $_SESSION['aVisible'] = array();

    for ($fila = 0; $fila < SIZE; $fila++) {
        for ($columna = 0; $columna < SIZE; $columna++) {
            $_SESSION['atablero'][$fila][$columna] = 0;
            $_SESSION['aVisible'][$fila][$columna] = 0;
        }
    }

    //colocamos las minas con un bucle de 1 hasta el numero de minas
    //fila--> random(0,ROW_SIZE)
    //columna--> random(0,COL_SIZE)
    for ($i = 0; $i < BOOMS; $i++) {
        do {
            $fila = rand(0, SIZE - 1);
            $columna = rand(0, SIZE - 1);
        } while ($_SESSION['atablero'][$fila][$columna] == "💣");
        $_SESSION['atablero'][$fila][$columna] = "💣";
        //agragamos los numeros a las casillas
        for ($x = max(0, $fila - 1); $x <= min(SIZE - 1, $fila + 1); $x++) {
            for ($y = max(0, $columna - 1); $y <= min(SIZE - 1, $columna + 1); $y++) {
                if ($_SESSION['atablero'][$x][$y] != "💣") {
                    $_SESSION['atablero'][$x][$y]++;
                }
            }
        }
    }
}

function isWinner()
{
    $isWinner = 0;
    for ($fila = 0; $fila < SIZE; $fila++) {
        for ($columna = 0; $columna < SIZE; $columna++) {
            if ($_SESSION['aVisible'][$fila][$columna] == 1 && $_SESSION['atablero'][$fila][$columna] != "💣") {
                $isWinner++;
            }
        }
    }
    return $isWinner == SIZE * SIZE - BOOMS;
}

function isLoser()
{
    for ($fila = 0; $fila < SIZE; $fila++) {
        for ($columna = 0; $columna < SIZE; $columna++) {
            if ($_SESSION['aVisible'][$fila][$columna] == 1 && $_SESSION['atablero'][$fila][$columna] == "💣") {
                return true;
            }
        }
    }
    return false;
}

function clicBox($row, $col)
{
    if ($_SESSION['aVisible'][$row][$col] == 0) {
        $_SESSION['aVisible'][$row][$col] = 1;
        if ($_SESSION['atablero'][$row][$col] == 0) {
            for ($x = max(0, $row - 1); $x <= min(SIZE - 1, $row + 1); $x++) {
                for ($y = max(0, $col - 1); $y <= min(SIZE - 1, $col + 1); $y++) {
                    clicBox($x, $y);
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Buscaminas</title>
</head>

<body>
    <div id="container">
        <h1>Buscaminas</h1>
        <?php
        if (!$_SESSION['play']) {
        ?>
            <form action="index.php" method="post">
                <label for="booms">Numero de boombas: </label>
                <input type="number" name="booms" value="10" required><br><br>
                <span class="error"><?php echo $boomsErr?></span><br><br>
                <label for="size">Tamaño del tablero: </label>
                <input type="number" name="size" value="10" maxLength="20" required><br><br>
                <span class="error"><?php echo $sizeErr?></span><br><br>
                <input type="submit" name="play" value="Jugar">
            </form>
        <?php
        } else {

            if (isset($_GET['row']) && isset($_GET['col'])) {
                $getRow = $_GET['row'];
                $getCol = $_GET['col'];
                clicBox($getRow, $getCol);
            }

            echo "<form action=\"index.php\" method=\"GET\">";

            showBoard();

            echo "</form>";

            if (isWinner()) {
                echo "<h1>Has ganado</h1>";
                echo "<a href=\"logout.php\"><div id=\"btn_new_match\">Nueva partida</div></a>";
            } elseif (isLoser()) {
                echo "<h1>Has perdido</h1>";
                echo "<a href=\"logout.php\"><div id=\"btn_new_match\">Nueva partida</div></a>";
            }
        }
        ?>
    </div>
</body>

</html>