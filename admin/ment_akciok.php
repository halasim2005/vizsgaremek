<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal");
    exit();
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['termek_id'])) {
    $termek_id = $_POST['termek_id'];
    $akcios_ar = !empty($_POST['akcios_ar']) ? $_POST['akcios_ar'] : null;
    $akcio_kezdete = !empty($_POST['akcio_kezdete']) ? $_POST['akcio_kezdete'] : null;
    $akcio_vege = !empty($_POST['akcio_vege']) ? $_POST['akcio_vege'] : null;

    $sql = "UPDATE termek SET akcios_ar = ?, akcio_kezdete = ?, akcio_vege = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$akcios_ar, $akcio_kezdete, $akcio_vege, $termek_id]);

    header("Location: admin_akciok.php");
    exit();
}
?>
