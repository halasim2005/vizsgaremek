<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

session_unset();
session_destroy();

// Kijelentkezés utáni visszairányítás üzenettel
header("Location: bejelentkezes.php?logout=1");
exit();
?>
