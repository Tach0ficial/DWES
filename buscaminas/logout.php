<?php
//cerrar session
session_start();
unset($_SESSION['atablero']);
unset($_SESSION['aVisible']);
unset($_SESSION['play']);
unset($_SESSION['booms']);
unset($_SESSION['size']);
session_destroy();
header('location: index.php')
?>
