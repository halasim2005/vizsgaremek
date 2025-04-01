<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rendeles_id'], $_POST['statusz'])) {
    $rendeles_id = $_POST['rendeles_id'];
    $uj_statusz = $_POST['statusz'];

    $update_query = "UPDATE megrendeles SET statusz = ? WHERE id = ?";
    $stmt = $pdo->prepare($update_query);
    $stmt->execute([$uj_statusz, $rendeles_id]);

    header("Location: orders.php");
    exit();
}
?>
