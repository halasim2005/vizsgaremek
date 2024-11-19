<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Admin Főoldal</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h2>Üdvözöljük az admin felületen!</h2>
    <nav>
        <a href="users.php">Felhasználók kezelése</a>
        <a href="products.php">Termékek kezelése</a>
        <a href="orders.php">Megrendelések kezelése</a>
        <a href="settings.php">Beállítások</a>
        <a href="logout.php">Kijelentkezés</a>
    </nav>
</body>
</html>
