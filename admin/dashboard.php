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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
    <link rel="icon" type="image/x-icon" href="../képek/HaLálip.ico">
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
    <h2>Üdvözlünk, <?php echo htmlspecialchars($_SESSION['felhasznalo']['fh_nev']); ?>!</h2>
    <p>Használd az admin navbar-t a funkciók eléréséhez.</p>
</div>
    <div class="row">
        <div class="col-md-4">
            <div class="alert alert-info text-center">
                <strong>15</strong> aktív felhasználó
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-success text-center">
                <strong>27</strong> függő rendelés
            </div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-warning text-center">
                <strong>8</strong> alacsony készletű termék
            </div>
        </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
