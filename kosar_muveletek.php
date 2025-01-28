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

    // Ellenőrizd a készletet
    $keszlet_query = "SELECT elerheto_darab FROM termek WHERE id = ?";
    $keszlet_stmt = $pdo->prepare($keszlet_query);
    $keszlet_stmt->execute([$termek_id]);
    $termek = $keszlet_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$termek) {
        $_SESSION['uzenet'] = "A termék nem található.";
        header("Location: termekek");
        exit();
    }

    $keszlet = $termek['elerheto_darab'];

    if ($keszlet <= 0) {
        $_SESSION['uzenet'] = "Ez a termék jelenleg nincs készleten.";
        header("Location: termekek");
        exit();
    }

    // Ellenőrizd, hogy van-e elég készlet
    if ($mennyiseg > $keszlet) {
        $_SESSION['uzenet'] = "Nem adhat a kosárhoz több terméket, mint amennyi készleten van. Elérhető mennyiség: $keszlet.";
        header("Location: termekek");
        exit();
    }

    // Ellenőrizd vagy hozz létre rendelést
    $rendeles_query = "SELECT megrendeles.id FROM megrendeles WHERE megrendeles.fh_nev = ? AND megrendeles.szallitasi_mod = '' LIMIT 1;";
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

    /////////////////////////////////////////////////////////////
    //Rendelés ID lekérése
    $ID_query = "SELECT megrendeles.id FROM megrendeles WHERE megrendeles.fh_nev = '{$fh_nev}' ORDER BY megrendeles.id DESC LIMIT 1;";
    $ID_megrendeles_array = adatokLekerdezese($ID_query);
    if(is_array($ID_megrendeles_array)){
        foreach($ID_megrendeles_array as $I){
            $ID_megrendeles = $I["id"];
        }
    }

    //Kosárszámláló
    $KOSAR_SZAMLALO_sql = "SELECT COUNT(tetelek.id) AS kosarSzamlalo FROM `tetelek` WHERE tetelek.statusz = 'kosárban' AND tetelek.fh_nev = '{$fh_nev}' AND tetelek.rendeles_id = {$ID_megrendeles} ORDER BY tetelek.id DESC;";
    $KOSAR_SZAMLALO_Array = adatokLekerdezese($KOSAR_SZAMLALO_sql);
    if(is_array($KOSAR_SZAMLALO_Array)){
        foreach($KOSAR_SZAMLALO_Array as $K){
            $kosar_szamlalo = $K["kosarSzamlalo"];
        }
    }

    // Tétel hozzáadása a tetelek táblához
    $query = "INSERT INTO tetelek (rendeles_id, termek_id, tetelek_mennyiseg, fh_nev) 
              VALUES (?, ?, ?, ?) 
              ON DUPLICATE KEY UPDATE tetelek_mennyiseg = tetelek_mennyiseg + VALUES(tetelek_mennyiseg)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$rendeles_id, $termek_id, $mennyiseg, $fh_nev]);

    // Készlet frissítése
    $keszlet_update_query = "UPDATE termek SET elerheto_darab = elerheto_darab - ? WHERE id = ?";
    $keszlet_update_stmt = $pdo->prepare($keszlet_update_query);
    $keszlet_update_stmt->execute([$mennyiseg, $termek_id]);

    $_SESSION['uzenet'] = "Termék sikeresen hozzáadva a kosárhoz.";
    header("Location: termekek");
    exit();
}
?>