<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include './db.php'; // Az adatbázis kapcsolat betöltése
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
    <title>Termékek</title>
</head>
<body>

    <script src="./js/termekek.js"></script>

    <?php
        include './navbar.php'; // A navigációs sáv betöltése
    ?>

    <div class="container mt-5">
        <!-- Szűrők -->
        <div class="grid-container align-middle" id="szures_" oninput="termekekLeker()">
            <div>Kategória
                <div>
                    <select id="kategoriaSzures" style="width: 150px">
                        <option value="osszes" selected>Összes termék</option>
                    </select>
                </div>
            </div>
            <div>Gyártó
                <div>
                    <select id="gyartoSzures" style="width: 150px">
                        <option value="osszesGyarto" selected>Összes gyártó</option>
                    </select>
                </div>
            </div>
            <div>Ár (Min - Max)
                <div id="rangeEgy"></div>
                <div id="rangeKetto"></div>
            </div>
            <div>Keresés
                <div>
                    <input type="text" id="keresesSzures" style="width: 150px" placeholder="Írja be a termék nevét!">
                </div>
            </div>
            <div>Rendezés
                <div>
                    <select id="rendez">
                        <option value="nevAz" selected>Név szerint (A-Z)</option>
                        <option value="nevZa">Név szerint (Z-A)</option>
                        <option value="arCsokk">Ár szerint növekvő</option>
                        <option value="arNov">Ár szerint csökkenő</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Termékek listája -->
        <div id="termekekTartalom" class="row">
            <!-- Ide töltődnek be dinamikusan a termékek -->
        </div>

        <div id="valaszSzoveg">

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php
        include './footer.php';
    ?>

</body>
</html>
