<?php
session_start();
session_unset();
session_destroy();
header("Location: fooldal.php"); // Átirányítás a főoldalra
exit();
?>
