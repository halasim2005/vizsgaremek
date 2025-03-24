<?php
session_start();

//Adatbázis kapcsolat betöltése
require_once './db.php';

/* Ha nincs aktív kosár vagy felhasználó, irányítsuk vissza a főoldalra
if (!isset($_SESSION['kosar']) || empty($_SESSION['kosar']) || !isset($_SESSION['felhasznalo']['id'])) {
    header("Location: index.php");
    exit();
}*/


?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés sikeres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

    <?php include './nav.php'; ?>

    <div class="container text-center my-5">
        <h1>Sikeres megrendelés!</h1>
        <p>Köszönjük, hogy minket választott! Rendeléséről visszaigazoló e-mailt küldtünk.</p>
        <p class="countdown">Visszairányítjuk a főoldalra <span id="countdown">10</span> másodperc múlva...</p>
        <a href="/" id="" class="btn btn-dark">Vissza a főoldalra</a>
    </div>
    <script>
        let timeLeft = 10;
        function countdown() {
            document.getElementById("countdown").innerText = timeLeft;
            if (timeLeft === 0) {
                window.location.href = "./fooldal.php";
            } else {
                timeLeft--;
                setTimeout(countdown, 1000);
            }
        }
        window.onload = countdown;
    </script>
</body>
</html>
