<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rendeles_id'])) {
    $rendeles_id = $_POST['rendeles_id'];

    // Tételek törlése
    $delete_tetelek_query = "DELETE FROM tetelek WHERE rendeles_id = ?";
    $stmt = $pdo->prepare($delete_tetelek_query);
    $stmt->execute([$rendeles_id]);

    // Rendelés törlése
    $delete_rendeles_query = "DELETE FROM megrendeles WHERE id = ?";
    $stmt = $pdo->prepare($delete_rendeles_query);
    $stmt->execute([$rendeles_id]);

    header("Location: orders.php");
    exit();
}
?>
