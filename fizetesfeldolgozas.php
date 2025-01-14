<?php/*
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Szállítási mód és fizetési mód ellenőrzés
$szallitasi_mod = isset($_POST['szallitasi_mod']) ? $_POST['szallitasi_mod'] : 'standard';
$fizetesi_mod = isset($_POST['fizetesi_mod']) ? $_POST['fizetesi_mod'] : 'kartya';

// Kosár összegzés
$osszeg = osszegzo($_SESSION['kosar']);

// Rendelés rögzítése az adatbázisba
$fh_nev = $_SESSION['felhasznalo']['fh_nev'];

// Rendelés adatainak beszúrása
$query = "INSERT INTO megrendeles (fh_nev, szallitasi_mod, fizetesi_mod, osszeg, szallitas, vegosszeg)
          VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($query);
$stmt->execute([$fh_nev, $szallitasi_mod, $fizetesi_mod, $osszeg, $szallitas, $vegosszeg]);

// Rendelési tételek beszúrása
$rendeles_id = $pdo->lastInsertId();
foreach ($_SESSION['kosar'] as $termek) {
    $termek_id = $termek['termek_id'];
    $mennyiseg = $termek['tetelek_mennyiseg'];
    $query = "INSERT INTO rendeles_tetelek (rendeles_id, termek_id, mennyiseg, ar)
              VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$rendeles_id, $termek_id, $mennyiseg, $termek['egysegar']]);
}

// Kosár ürítése a session-ben
$_SESSION['kosar'] = [];

// Kosár adatbázisból történő törlése
$query = "DELETE FROM tetelek WHERE fh_nev = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$fh_nev]);

// Rendelés sikeres feldolgozása
header("Location: rendeles_sikeres.php");
exit();*/
?>