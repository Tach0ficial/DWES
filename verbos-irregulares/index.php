<?php
/**
 * Proyecto de verbos irregulares.
 * 
 * @author Carlos Hidalgo Risco
 */

include("verbs.php");

function clearData($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);

    return $data;
}

$arrayOfIndexes;
$goodAnswers = 0;
$quantityErr = $difficultyErr = "";
$lerror = false;
$enviado = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" and  isset($_POST['actualizar'])) {
    //Validando difficulty
    if (empty($_POST["difficulty"])) {
        $difficultyErr = "Difficulty is required";
        $lerror = true;
    } else {
        $difficulty = clearData($_POST["difficulty"]);
    }

    //Validando quantity
    if (empty($_POST["quantity"]) or $_POST["quantity"] > count($verbs)) {
        $quantityErr = "Quantity is required";
        $lerror = true;
    } else {
        $quantity = clearData($_POST["quantity"]);
    }

    if ($lerror) {
        $difficulty = clearData($_POST["difficultyBefore"]);
        $quantity = clearData($_POST["quantityBefore"]);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['send'])) {
    $enviado = true;
    $difficulty = clearData($_POST["difficultyBefore"]);
    $quantity = clearData($_POST["quantityBefore"]);
    $arrayOfIndexes = unserialize($_POST["indexes"]);
} else {
    $difficulty = 1;
    $quantity = 6;
}

//funcion para elegir verbos randon
if (!isset($_POST['send'])) {

    $aRand = range(0, count($verbs) - 1);
    
    function random(&$arrayOfIndexes, &$aRand, $difficulty)
    {
        $rand = array_rand($aRand);
        unset($aRand[$rand]);

        $inputs = range(0, 3);
        for ($i = 0; $i < $difficulty; $i++) {
            $randInput = array_rand($inputs);
            unset($inputs[$randInput]);
            $arrayOfIndexes[$rand][$i] = $randInput;
        }
    }

    for ($i = 0; $i < $quantity; $i++) {
        random($arrayOfIndexes, $aRand, $difficulty);
    }
}
$cols = 4;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Carlos Hidalgo Risco">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/styles.css">
    <title>Verbos irregulares.</title>
</head>

<body>
    <form action="index.php" method="POST">
        <label for="difficulty">Dificultad:
            <select name="difficulty">
                <option value="1">Easy</option>
                <option value="2">Medium</option>
                <option value="3">Hard</option>
            </select>
            <span class="error">*<?php echo $difficultyErr; ?></span>
            <span class="error"></span>
        </label><br><br>
        <label for="quantity">Cantidad de verbos:
            <input type="number" name="quantity" id="quantity">
            <span class="error">*<?php echo $quantityErr; ?></span>
            <span class="error"></span>
        </label><br><br>
        <input type="submit" value="Actualizar" name="actualizar">
        <table>
            <tr>
                <td colspan='4'>
                    <h1>Verbos Irregulares</h1>
                </td>
            </tr>
            <tr class="title">
                <td><b>Infinitive</b></td>
                <td><b>Past simple</b></td>
                <td><b>Participle</b></td>
                <td><b>Spanish</b></td>
            </tr>
            <?php
            foreach ($arrayOfIndexes as $key => $index) {
                echo "<tr>";
                for ($x = 0; $x < $cols; $x++) {
                    echo "<td>";
                    if (in_array($x, $index, true)) {
                        if (isset($_POST['send'])) {
                            //Comparar el array de respuestas con el array de verbos.
                            if ($_POST["$key$x"] == $verbs[$key][$x]) {
                                echo "<span class='correct'>";
                                echo cleardata($_POST["$key$x"]);
                                echo "</span>";
                                $goodAnswers++;
                            } else {
                                echo "<span class='error'>";
                                if (empty($_POST["$key$x"])) {
                                    echo "---";
                                }else {
                                    echo cleardata($_POST["$key$x"]);
                                }
                                echo "</span><br>";
                                echo "<span class='correct'>";
                                echo $verbs[$key][$x];
                                echo "</span>";
                            }
                        } else {
                            echo "<input type='text' name='$key";
                            echo $x;
                            echo "'>";
                        }
                    } else {
                        echo $verbs[$key][$x];
                    }
                    echo "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <?php if (isset($_POST["send"])) {
            echo "<h1>Has acertado  $goodAnswers  de " . ($quantity * $difficulty) . " verbos.</h1>";
        } else {
            echo "<input type='submit' value='Corregir' name='send'>";
        } ?>
        <input type="hidden" name="difficultyBefore" value="<?php echo $difficulty ?>">
        <input type="hidden" name="quantityBefore" value="<?php echo $quantity ?>">
        <input type="hidden" name="indexes" value="<?php echo serialize($arrayOfIndexes) ?>">
    </form>
</body>
</html>