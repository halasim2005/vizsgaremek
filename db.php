<?php
$host = 'localhost';
$dbname = 'halaliweb';
$username = 'root';
$password = '';

try {
    // PDO adatbázis kapcsolat létrehozása
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Hiba kezelési mód beállítása
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Ha a kapcsolat nem sikerül, akkor hibaüzenet
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>