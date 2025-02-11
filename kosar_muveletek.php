<?php
session_start();

require_once './db.php';
include './sql_fuggvenyek.php';

if (!isset($_SESSION['kosar'])) {
    $_SESSION['kosar'] = [];
}

// Kosárba adás
if (isset($_POST['add_to_cart'])) {
    $termek_id = $_POST['termek_id'];
    $mennyiseg = $_POST['mennyiseg'];
    $fh_nev = $_SESSION['felhasznalo']['fh_nev'];

    if(!$fh_nev){
        header("Location: kosar");
    }

    // Ellenőrizd vagy hozz létre rendelést
    $rendeles_query = "SELECT megrendeles.id FROM megrendeles WHERE megrendeles.fh_nev = ? AND megrendeles.fizetesi_mod = '' AND megrendeles.osszeg = 0 AND megrendeles.szallitas = '' LIMIT 1;";
    $rendeles_stmt = $pdo->prepare($rendeles_query);
    $rendeles_stmt->execute([$fh_nev]);
    $rendeles = $rendeles_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$rendeles) {
        $uj_rendeles_query = "INSERT INTO megrendeles (fh_nev, leadas_datum) VALUES (?, NOW())";
        $uj_rendeles_stmt = $pdo->prepare($uj_rendeles_query);
        $uj_rendeles_stmt->execute([$fh_nev]);
        $rendeles_id = $pdo->lastInsertId();
    } else {
        $rendeles_id = $rendeles['id'];
    }

    // Tétel hozzáadása a tetelek táblához
    $query = "INSERT INTO tetelek (rendeles_id, termek_id, tetelek_mennyiseg, fh_nev) 
              VALUES (?, ?, ?, ?) 
              ON DUPLICATE KEY UPDATE tetelek_mennyiseg = tetelek_mennyiseg + VALUES(tetelek_mennyiseg)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$rendeles_id, $termek_id, $mennyiseg, $fh_nev]);

    $_SESSION['uzenet'] = "Termék sikeresen hozzáadva a kosárhoz.";
    header("Location: termekek");
    exit();
}
?>