<?php
//cerrar session
session_start();
unset($_SESSION['currentUser']);
header('location: index.php')
?>
