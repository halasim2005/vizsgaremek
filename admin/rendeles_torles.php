<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rendeles_id'])) {
    $rendeles_id = $_POST['rendeles_id'];

    // 1. Lekérdezzük a rendeléshez tartozó termékeket és mennyiségeket
    $query = "SELECT termek_id, tetelek_mennyiseg FROM tetelek WHERE rendeles_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$rendeles_id]);
    $tetelek = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Visszaállítjuk a termékek elérhető darabszámát
    foreach ($tetelek as $tetel) {
        $update_query = "UPDATE termek SET elerheto_darab = elerheto_darab + ? WHERE id = ?";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->execute([$tetel['tetelek_mennyiseg'], $tetel['termek_id']]);
    }

    // 3. Tételek törlése
    $delete_tetelek_query = "DELETE FROM tetelek WHERE rendeles_id = ?";
    $stmt = $pdo->prepare($delete_tetelek_query);
    $stmt->execute([$rendeles_id]);

    // 4. Rendelés törlése
    $delete_rendeles_query = "DELETE FROM megrendeles WHERE id = ?";
    $stmt = $pdo->prepare($delete_rendeles_query);
    $stmt->execute([$rendeles_id]);

    header("Location: orders.php");
    exit();
}
?>
