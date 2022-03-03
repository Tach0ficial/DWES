<?php
//cerrar session
session_start();
unset($_SESSION['loggedin']);
unset($_SESSION['username']);
session_destroy();
header('location: gallery.php')
?>
