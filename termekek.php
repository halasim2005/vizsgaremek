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
        </div>

        <!-- Termékek listája -->
        <div id="termekekTartalom" class="row">
            <!-- Ide töltődnek be dinamikusan a termékek -->
        </div>

        <div id="valaszSzoveg">

        </div>

        <!-- Modal 
        <div id="sikerkosarModal" class="modal fade" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 400px;">
                <div class="modal-content" style="background-color: green; color: white; border-radius: 8px;">
                    <div class="modal-body" style="padding: 20px; text-align: center;">
                        A termék a kosárba került!
                    </div>
                </div>
            </div>
        </div>
        -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php
        include './footer.php';
    ?>

</body>
</html>
