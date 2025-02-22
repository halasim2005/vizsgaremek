<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

require_once '../db.php';

if (isset($_GET['id'])) {
    $termek_id = $_GET['id'];

    // Az akciós adatokat töröljük (null-ra állítjuk)
    $sql = "UPDATE termek SET akcios_ar = NULL, akcio_kezdete = NULL, akcio_vege = NULL WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$termek_id]);

    header("Location: admin_akciok.php");
    exit();
}
?>
