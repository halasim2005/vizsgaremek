<?php
session_start();

if (!isset($_SESSION['kosar'])) {
    $_SESSION['kosar'] = [];
}

// Kosárba adás
if (isset($_POST['add_to_cart'])) {
    $termek_id = $_POST['termek_id'];
    $termek_nev = $_POST['termek_nev'];
    $ar = $_POST['ar'];
    $mennyiseg = $_POST['mennyiseg'];

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
        ];
    }
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
