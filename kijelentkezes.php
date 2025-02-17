<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();

    $_SESSION["cart_szamlalo"] = 0;
}
session_unset();
session_destroy();
header("Location: bejelentkezes.php?logout=1");
exit();
?>
