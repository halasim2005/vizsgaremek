<?php
/*session_start();

// Adatbázis kapcsolat betöltése
require_once './db.php';

// Ha nincs aktív kosár vagy felhasználó, irányítsuk vissza a főoldalra
if (!isset($_SESSION['kosar']) || empty($_SESSION['kosar']) || !isset($_SESSION['felhasznalo']['id'])) {
    header("Location: index.php");
    exit();
}

// A rendelés adatainak mentése
$felhasznalo_id = $_SESSION['felhasznalo']['id'];
$kosar = $_SESSION['kosar'];
$szallitas_mod = $_POST['szallitasi_mod'] ?? 'standard';  // Alapértelmezett érték: standard
$fizetesi_mod = $_POST['fizetesi_mod'] ?? 'kartya';  // Alapértelmezett érték: bankkártyás

// Végösszeg kiszámítása
$osszesen = osszegzo($kosar);
$szallitas_dij = szallitas_dij($kosar);
$vegosszeg = $osszesen + $szallitas_dij;

// Rendelés mentése az adatbázisba
$query = "INSERT INTO rendelesek (felhasznalo_id, szallitas_mod, fizetesi_mod, osszeg, szallitas_dij, vegosszeg, statusz)
          VALUES (?, ?, ?, ?, ?, ?, 'felfuggesztve')";  // A rendelés státusza kezdetben 'felfüggesztve'
$stmt = $pdo->prepare($query);
$stmt->execute([$felhasznalo_id, $szallitas_mod, $fizetesi_mod, $osszesen, $szallitas_dij, $vegosszeg]);

// Rendelés tételek mentése
$rendeles_id = $pdo->lastInsertId();  // Az előző lekérdezés utolsó generált ID-ja
foreach ($kosar as $termek) {
    $query = "INSERT INTO rendeles_tetelek (rendeles_id, termek_id, mennyiseg, ar)
              VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$rendeles_id, $termek['termek_id'], $termek['tetelek_mennyiseg'], $termek['egysegar']]);
}

// Kosár ürítése és session törlése
$_SESSION['kosar'] = [];

// Vásárlás visszaigazolása*/
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés sikeres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include './navbar.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <h3>Rendelés sikeres!</h3>
                    <p>Köszönjük, hogy vásárolt nálunk! A rendelése <strong>felfüggesztve</strong> státuszban van, és hamarosan feldolgozásra kerül.</p>
                    <p>A rendelés összegzése:</p>
                    
                    <p>Ha bármilyen kérdése van, kérjük lépjen kapcsolatba velünk!</p>
                    <a href="index.php" class="btn btn-primary">Vissza a főoldalra</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
