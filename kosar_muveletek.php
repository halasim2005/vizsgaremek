<?php
session_start();

require_once './db.php';

if (!isset($_SESSION['kosar'])) {
    $_SESSION['kosar'] = [];
}

// Kosárba adás



if (isset($_POST['add_to_cart'])) {
    $termek_id = $_POST['termek_id'];
    $termek_nev = $_POST['termek_nev'] ?? null;
    $ar = $_POST['ar'];
    $mennyiseg = $_POST['mennyiseg'];
    $kep = $_POST['termek_kep'];
    $van_mar = false;
    foreach ($_SESSION['kosar'] as &$termek) {
        if ($termek['termek_id'] == $termek_id) {
            $termek['mennyiseg'] += $mennyiseg; // Mennyiség növelése
            $van_mar = true;
            break;
        }
    }
    
    if (!$van_mar) {
        $_SESSION['kosar'][] = [
            'termek_id' => $termek_id,
            'termek_nev' => $termek_nev,
            'ar' => $ar,
            'mennyiseg' => $mennyiseg,
            'termek_kep' => $kep,
        ];
    }
    //var_dump($_SESSION['kosar']);
    // Felhasználó kosarába tett termék mentése
    $user_id = $_SESSION['felhasznalo']['fh_nev'];  // A felhasználó ID-ja
    $termek_id = $_POST['termek_id'];  // A termék ID-ja
    $mennyiseg = $_POST['mennyiseg'];  // A mennyiség
    
    // Új rendelés ID generálása (például: automatikusan hozzárendelhetjük a felhasználóhoz)
    //$rendeles_id = uniqid($user_id . '_');  // Egyedi rendelés ID generálása
    
    // Lekérdezés a kosárba történő mentéshez
    $query = "INSERT INTO tetelek (rendeles_id, termek_id, tetelek_mennyiseg) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id, $termek_id, $mennyiseg]);
    header("Location: termekek"); // Vissza a termékoldalra
    exit();
}

// Eltávolítás
if (isset($_POST['remove_from_cart'])) {
    $index = $_POST['index'];
    unset($_SESSION['kosar'][$index]);
    $_SESSION['kosar'] = array_values($_SESSION['kosar']); // Újrendezés
    header("Location: kosar");
    exit();
}

// Kosár ürítése
if (isset($_POST['empty_cart'])) {
    $_SESSION['kosar'] = [];
    header("Location: kosar");
    exit();
}
?>
