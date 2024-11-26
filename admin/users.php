<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}
include './admin_navbar.php';
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
</head>
<style>
    :root {
    --navbar-height: 70px;
    }   
    body {
        padding-top: var(--navbar-height);
    }
    .row {
    overflow-x: auto; /* Ha az adatok túl szélesek, görgetést biztosít */
    word-wrap: break-word; /* Szöveg tördelése túl hosszú sorok esetén */
    max-width: 100%; /* A konténer szélességének korlátozása */
    margin: 0 auto; /* Középre igazítás */
}
</style>
<body>
<div class="mt-4 text-center">
    <h2>Üdvözlünk, <?php echo htmlspecialchars($_SESSION['felhasznalo']); ?>!</h2>
    <p>Felhasználók kezelése oldal tartalma</p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
