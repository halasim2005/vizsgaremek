<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {
    $fh_nev = $_POST['user'];

    // Ellenőrizzük, hogy létezik-e a felhasználó
    $checkUserQuery = "SELECT * FROM felhasznalo WHERE fh_nev = ?";
    $stmt = $pdo->prepare($checkUserQuery);
    $stmt->execute([$fh_nev]);

    if ($stmt->rowCount() > 0) {
        // Töröljük a felhasználóhoz tartozó rendeléseket és tételeket
        $deleteTetelekQuery = "DELETE FROM tetelek WHERE rendeles_id IN (SELECT id FROM megrendeles WHERE fh_nev = ?)";
        $stmt = $pdo->prepare($deleteTetelekQuery);
        $stmt->execute([$fh_nev]);

        $deleteOrdersQuery = "DELETE FROM megrendeles WHERE fh_nev = ?";
        $stmt = $pdo->prepare($deleteOrdersQuery);
        $stmt->execute([$fh_nev]);

        // Végül töröljük a felhasználót
        $deleteUserQuery = "DELETE FROM felhasznalo WHERE fh_nev = ?";
        $stmt = $pdo->prepare($deleteUserQuery);
        $stmt->execute([$fh_nev]);

        $_SESSION['success_message'] = "A felhasználó sikeresen törölve.";
    } else {
        $_SESSION['error_message'] = "A felhasználó nem található.";
    }

    header("Location: users.php");
    exit();
}
?>
