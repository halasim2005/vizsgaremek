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

    <?php
        include './navbar.php'; // A navigációs sáv betöltése
    ?>

<div id="szuresDiv" class="shadow">
    <form id="szuresForm" method="post" class="row g-3">
        <h4 class="text-center mb-4">Szűrés alapú keresés</h4>
    
        <!-- Kategória szűrés -->
        <div class="col-md-6">
            <label for="kategoriaSzures" class="form-label">Kategória</label>
            <select name="kategoria" id="kategoriaSzures" class="form-select">
                <option value="összes">Összes termék</option>
                
            </select>
        </div>

        <!-- Ár szűrés -->
        <div class="col-md-6">
            <label for="arSzuresMin" class="form-label">Ár szűrés (Ft)</label>
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <label for="arSzuresMin" class="form-label">Minimum ár:</label>
                    <input type="range" id="arSzuresMin" name="min_ar" class="form-range" min="0" max="100000" step="1000" 
                        style="background: linear-gradient(to right, #007bff, #d1e9ff); height: 10px; border-radius: 5px;"
                        oninput="document.getElementById('arErtekMin').innerText = this.value + ' Ft';">
                    <span id="arErtekMin" class="d-block text-center">0 Ft</span>
                </div>
                <div>
                    <label for="arSzuresMax" class="form-label">Maximum ár:</label>
                    <input type="range" id="arSzuresMax" name="max_ar" class="form-range" min="0" max="100000" step="1000" 
                        style="background: linear-gradient(to right, #007bff, #d1e9ff); height: 10px; border-radius: 5px;"
                        oninput="document.getElementById('arErtekMax').innerText = this.value + ' Ft';">
                    <span id="arErtekMax" class="d-block text-center">100 000 Ft</span>
                </div>
            </div>
        </div>

        <!-- Gyártó szűrés -->
        <div class="col-md-6">
            <label for="gyartoSzures" class="form-label">Gyártó</label>
            <select name="gyarto" id="gyartoSzures" class="form-select">
                <option value="összes">Összes gyártó</option>
                <?php
                $gyartok_sql = "SELECT DISTINCT gyarto FROM termek;";
                $gyartok = adatokLekerdezese($gyartok_sql);
                if (is_array($gyartok)) {
                    foreach ($gyartok as $gyarto) {
                        echo '<option value="'. htmlspecialchars($gyarto["gyarto"]) . '">' . htmlspecialchars($gyarto["gyarto"]) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <!-- Termék kereső -->
        <div class="col-md-6">
            <label for="termekKereses" class="form-label">Termék keresés</label>
            <input type="text" id="termekKereses" name="kereses" class="form-control" placeholder="Írd be a keresett terméket">
        </div>

        <!-- Keresés gomb -->
        <div class="col-12 text-center">
            <button type="submit" id="modalKartyaGomb" name="keresesGomb" class="btn btn-primary px-4">Keresés</button>
        </div>
    </form>
</div>



    <div class="text-center">
        <h2 id="fekete">Termékek</h2>
    </div>
            
    <script src="./js/termekek.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php
        include './footer.php';
    ?>

</body>
</html>