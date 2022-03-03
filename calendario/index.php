<?php

/**
 * @author Carlos Hidalgo Risco
 */

function clearData($data)
{
  $data = trim($data);
  $data = htmlspecialchars($data);
  $data = stripslashes($data);

  return $data;
}

if (!isset($_SESSION["array_tasks"])) {
  $_SESSION["array_tasks"] = array();
}

$currentDay = getdate()["mday"];
$month = getdate()["mon"];
$year = getdate()["year"];
$yearErr = $monthErr = $lerror = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Validacion del mes
  if (empty($_POST["month"])) {
    $monthErr = "Month is required";
    $lerror = true;
  } else {
    $month = clearData($_POST["month"]);
  }

  //Validacion del año
  if (empty($_POST["year"])) {
    $yearErr = "Year is required";
    $lerror = true;
  }elseif($_POST["year"] < 1970){
    $yearErr = "The year must be greater than 1970";
    $lerror = true;

  } else {
    $year = clearData($_POST["year"]);
  }

  if (!$lerror) {
    if ($month == getdate()["mon"] and $year == getdate()["year"]) {
      $currentDay = getdate()["mday"];
    } else {
      $currentDay = null;
    }
  } else {
    $month = getdate()["mon"];
    $year = getdate()["year"];
  }
}

$date = "$year-$month-1";
$day = 1;
$fristDayOfMonth = date('l', strtotime($date));
$week = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$fristDayOfMonth = array_search($fristDayOfMonth, $week);
$filas = 5;
if ($fristDayOfMonth > 4) {
  $filas = 6;
}

$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$holidays = array(
  1 => array(
    "days" => array(1, 6),
    "names" => array("Año Nuevo", "Reyes"),
    "types" => array("nacional", "nacional")
  ),
  2 => array(
    "days" => array(28),
    "names" => array("Día de Andalucía"),
    "types" => array("comunidad")
  ),
  5 => array(
    "days" => array(1),
    "names" => array("Fiesta del Trabajo"),
    "types" => array("nacional")
  ),
  8 => array(
    "days" => array(15),
    "names" => array("Asunción de la Virgen"),
    "types" => array("comunidad")
  ),
  9 => array(
    "days" => array(8),
    "names" => array("Virgen de Fuensanta"),
    "types" => array("cordoba")
  ),
  10 => array(
    "days" => array(12, 25),
    "names" => array("Fiesta nacional de España", "San Rafael"),
    "types" => array("nacional", "cordoba")
  ),
  11 => array(
    "days" => array(1),
    "names" => array("Todos los santos"),
    "types" => array("nacional")
  ),
  12 => array(
    "days" => array(6, 8, 25),
    "names" => array("Día de la Constitución", "La Inmaculada Concepción", "Navidad"),
    "types" => array("nacional", "nacional", "nacional")
  )
);

$juevesSanto;
$viernesSanto;
$pascua = date("j-d-Y", easter_date($year));
$juevesSanto = date("d-m-Y", strtotime($pascua . "- 2 days"));
$viernesSanto = date("d-m-Y", strtotime($pascua . "- 3 days"));

/**
 * @todo meter jueves santo y viernes santo en el array de festivos.
 * 
 *  4 => array(
      array(
        "day" => 1,
        "name" => "Jueves Santo",
        "type" => "comunidad"
      ),
      array(
        "day" => 2,
        "name" => "Viernes Santo",
        "type" => "nacional"
      )
    ),
 */

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Calendar</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/Bootstrap-Calendar.css">
  <link rel="stylesheet" href="assets/css/Calendar-BS4-1.css">
  <link rel="stylesheet" href="assets/css/Calendar-BS4.css">
  <link rel="stylesheet" href="assets/css/normalize.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="bootstrap_calendar">
    <div class="container py-5">
      <div class="calendar shadow bg-white p-5">
        <form action="index.php" method="post">
          <p><span class="error">* Campos requeridos..</span></p>
          <label for="year">Año:
            <input type="year" name="year" id="year">
            <span class="error">*<?php echo $yearErr; ?></span>
            <span class="error"></span>
          </label><br><br>
          <label for="month">Mes:
            <select name="month">
              <option value=""></option>
              <?php
              // Pone los meses en la lista y selecciona el escogido.
              foreach ($months as $index => $value) {
                echo "<option value=" . ($index + 1);
                if ($month == $index + 1) {
                  echo " selected";
                }
                echo ">$value</option>";
              }
              ?>
            </select>
            <span class="error">*<?php echo $monthErr; ?></span>
          </label><br><br>
          <input type="submit" value="Actualizar">
        </form>

        <!-- For Demo Purpose -->
        <header class="text-center text-white mb-5">
          <h1 class="display-4">Calendar</h1>
        </header>


        <!-- Calendar -->

        <div class="d-flex align-items-center"><i class="fa fa-calendar fa-3x mr-3"></i>
          <h2 class="month font-weight-bold mb-0 text-uppercase"><?php echo $months[$month - 1] . " " . $year; ?></h2>
        </div>
        <p class="font-italic text-muted mb-5">No events for this day.</p>
        <ol class="day-names list-unstyled">
          <li class="font-weight-bold text-uppercase">Mon</li>
          <li class="font-weight-bold text-uppercase">Tue</li>
          <li class="font-weight-bold text-uppercase">Wed</li>
          <li class="font-weight-bold text-uppercase">Thu</li>
          <li class="font-weight-bold text-uppercase">Fri</li>
          <li class="font-weight-bold text-uppercase">Sat</li>
          <li class="font-weight-bold text-uppercase">Sun</li>
        </ol>

        <ol class="days list-unstyled">
          <?php

          for ($i = 1; $i <= 40; $i++) {
            if ($day != $days_in_month + 1) {
              if ($fristDayOfMonth > $i) {
                echo "<li class='outside'>";
                echo " <div class='date'></div>";
              } else {
                if ($i % 7 === 0) {
                  echo "<li class='sunday'>";
                } elseif ($day === $currentDay) {
                  echo "<li class='today'>";
                } elseif (array_key_exists($month, $holidays) and in_array($day, $holidays[$month]["days"])) {
                  echo "<li class=" . $holidays[$month]["types"][array_search($day, $holidays[$month]["days"])] . ">";
                } else {
                  echo "<li>";
                }
                echo "<div class='date'>";
                echo " <a href='day.php?day=$day&month=$month&year=" . $year;
                if (array_key_exists($month, $holidays) and in_array($day, $holidays[$month]["days"])) {
                  echo "&festivo=" . $holidays[$month]["names"][array_search($day, $holidays[$month]["days"])];
                }
                echo "'>" . $day++ . "</a></div></li>";
              }
              
            }
          }
          ?>
        </ol>
        <?php

        ?>
        <div style="margin:46px;">
          <?php
          if (array_key_exists($month, $holidays)) {
            for ($i=0; $i < count($holidays[$month]["days"]); $i++) { 
          ?>
              <div class="row row-striped">
                <div class="col-2 text-center ">
                  <h1 class="display-4 "><span class="badge date-green"><?php echo $holidays[$month]["days"][$i]; ?></span></h1>
                  <h2><?php echo substr($months[$month - 1], 0, 3); ?></h2>
                </div>
                <div class="col-10">
                  <h3 class="text-uppercase"><strong><?php echo $holidays[$month]["names"][$i]; ?></strong></h3>
                  <ul class="list-inline">
                    <li class="list-inline-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> Wednesday</li>
                  </ul>
                </div>
              </div>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>