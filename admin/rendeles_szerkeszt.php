<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

require_once '../db.php';
require_once '../sql_fuggvenyek.php';


$rendeles_id;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rendeles_id'])) {
    $rendeles_id = $_POST['rendeles_id'];

    // Rendelés tételeinek lekérdezése
    $query = "SELECT tetelek.id as tetel_id, termek.nev, tetelek.tetelek_mennyiseg, termek.egysegar
              FROM tetelek
              JOIN termek ON tetelek.termek_id = termek.id
              WHERE tetelek.rendeles_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([(int)$rendeles_id]);
    $tetel_adatok = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tetel_id'], $_POST['uj_mennyiseg'], $_POST['modositBtn'])) {
    $rendeles_id = $_POST['rendeles_id'];
    $tetel_id = $_POST['tetel_id'];
    $uj_mennyiseg = $_POST['uj_mennyiseg'];
    
    // Megrendelés ID lekérdezése a tételből
    $megrendel_id_query = "SELECT megrendeles.id FROM megrendeles, tetelek WHERE tetelek.rendeles_id = megrendeles.id AND tetelek.id = ?";
    $megrendel_stmt = $pdo->prepare($megrendel_id_query);
    $megrendel_stmt->execute([$tetel_id]);
    $megrendeles = $megrendel_stmt->fetch(PDO::FETCH_ASSOC);
    $megrendeles_id = $megrendeles['id'];
    
    if ($uj_mennyiseg > 0) {
        // Mennyiség frissítése
        $update_query = "UPDATE tetelek SET tetelek_mennyiseg = ? WHERE id = ?";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->execute([$uj_mennyiseg, $tetel_id]);
    } else {
        // Tétel törlése, ha a mennyiség 0
        $delete_query = "DELETE FROM tetelek WHERE id = ?";
        $delete_stmt = $pdo->prepare($delete_query);
        $delete_stmt->execute([$tetel_id]);
    }

    // Frissítés a rendelés végösszegének újraszámításához
    $update_total_query = "UPDATE megrendeles SET vegosszeg = 
                            (SELECT SUM(tetelek.tetelek_mennyiseg * 
                                        COALESCE(termek.akcios_ar, termek.egysegar)) 
                             FROM tetelek 
                             JOIN termek ON tetelek.termek_id = termek.id 
                             WHERE tetelek.rendeles_id = ?) 
                            WHERE id = ?";
    $update_total_stmt = $pdo->prepare($update_total_query);
    $update_total_stmt->execute([$rendeles_id, $megrendeles_id]);
    // Visszairányítás az orders.php oldalra
    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés Szerkesztése</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Rendelés Szerkesztése (ID: <?php echo htmlspecialchars($rendeles_id); ?>)</h2>
    <?php if(isset($tetel_adatok) && is_array($tetel_adatok)) foreach ($tetel_adatok as $tetel): ?>
        <form method="POST">
            <input type="hidden" name="tetel_id" value="<?php echo $tetel['tetel_id']; ?>">
            <div class="mb-3">
                <label><?php echo htmlspecialchars($tetel['nev']); ?> (Egységár: <?php echo htmlspecialchars($tetel['egysegar']); ?> Ft)</label>
                <input type="hidden" name="rendeles_id" value="<?php echo htmlspecialchars($rendeles_id); ?>">
                <input type="number" name="uj_mennyiseg" value="<?php echo htmlspecialchars($tetel['tetelek_mennyiseg']); ?>" class="form-control">
            </div>
            <button type="submit" name="modositBtn" class="btn btn-primary">Módosítás</button>
        </form>
    <?php endforeach; ?>
    <a href="orders.php" class="btn btn-secondary mt-3">Vissza</a>
</div>
</body>
</html>
