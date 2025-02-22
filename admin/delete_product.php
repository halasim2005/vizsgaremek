<?php
require_once '../db.php'; 

// Termék ID lekérése az URL-ből vagy a POST-ból
$product_id = $_POST['product_id'] ?? $_GET['id'] ?? null;

if (!$product_id) {
    die("Hiba: A termék ID hiányzik.");
}

// Termék adatok lekérdezése
$stmt = $pdo->prepare("SELECT * FROM termek WHERE id = :id");
$stmt->execute(['id' => $product_id]);

// Adatok mentése
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("DELETE FROM termek WHERE id = :id");
    $stmt->execute(['id' => $product_id]);

    echo "Termék sikeresen törölve.";
    header("Location: products.php"); 
    exit;
}
?>