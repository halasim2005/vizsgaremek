<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include './db.php';
$query = "UPDATE termek SET akcios_ar = NULL, akcio_kezdete = NULL, akcio_vege = NULL 
          WHERE (akcio_vege IS NOT NULL AND akcio_vege < NOW()) 
          OR (akcio_kezdete IS NULL AND akcio_vege IS NULL)";
$pdo->query($query);
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
    <link rel="icon" type="image/x-icon" href="./képek/HaLálip.ico">
</head>
<body>

    <script src="./js/termekek.js"></script>

    <?php
        include './nav.php';
    ?>

    <div class="container mt-5">
        <div class="d-flex flex-wrap gap-3 justify-content-between" id="szures_" oninput="termekekLeker()">
            
            <div class="flex-grow-1">
                <label for="kategoriaSzures" class="form-label">Kategória</label>
                <select id="kategoriaSzures" class="form-select">
                    <option value="osszes" selected>Összes termék</option>
                </select>
            </div>

            <div class="flex-grow-1">
                <label for="gyartoSzures" class="form-label">Gyártó</label>
                <select id="gyartoSzures" class="form-select">
                    <option value="osszesGyarto" selected>Összes gyártó</option>
                </select>
            </div>

            <div class="flex-grow-1">
                <label class="form-label">Ár (Min - Max)</label>
                <div id="rangeEgy"></div>
                <div id="rangeKetto"></div>
            </div>

            <div class="flex-grow-1">
                <label for="keresesSzures" class="form-label">Keresés</label>
                <input type="text" id="keresesSzures" class="form-control" placeholder="Írja be a termék nevét!">
            </div>

            <div class="flex-grow-1">
                <label for="rendez" class="form-label">Rendezés</label>
                <select id="rendez" class="form-select">
                    <option value="nevAz" selected>Név szerint (A-Z)</option>
                    <option value="nevZa">Név szerint (Z-A)</option>
                    <option value="arCsokk">Ár szerint növekvő</option>
                    <option value="arNov">Ár szerint csökkenő</option>
                    <option value="akcio">Akciós termékek</option>
                </select>
            </div>

        </div>

        <div id="talalatokSzama">

        </div>

        <!-- Termékek listája -->
        <div id="termekekTartalom" class="row mt-4">
            <!-- Ide töltődnek be dinamikusan a termékek -->
        </div>

        <div id="valaszSzoveg" class="text-center mt-3"></div>
        <div class="text-center" id="hibaKepDiv">
            <img src="./képek/HaLálip.png" style="margin-bottom:55px" width="300" alt="HaLáli Kft. logo">
        </div>
    </div>

    <?php
        include './footer.php';
    ?>

</body>
</html>