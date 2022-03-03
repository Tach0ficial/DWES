<?php
//cerrar session
session_start();
unset($_SESSION['contracts']);
session_destroy();
header('location: index.php')
?>
