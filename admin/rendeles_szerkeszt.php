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

    $query = "SELECT tetelek.id as tetel_id, termek.nev, tetelek.tetelek_mennyiseg, termek.egysegar
              FROM tetelek
              JOIN termek ON tetelek.termek_id = termek.id
              WHERE tetelek.rendeles_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([(int)$rendeles_id]);
    $tetel_adatok = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fizetesi_mod'], $_POST['fizmodBtn'])){
    $fizetesi_mod = isset($_POST['fizetesi_mod']) ? $_POST['fizetesi_mod'] : null;
    $rendeles_id = $_POST['rendeles_id'];

    if ($fizetesi_mod) {
        $update_total_query = "UPDATE megrendeles SET fizetesi_mod = ? WHERE id = ?";
        $update_total_stmt = $pdo->prepare($update_total_query);
        $update_total_stmt->execute([$fizetesi_mod, $rendeles_id]);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tetel_id'], $_POST['uj_mennyiseg'], $_POST['modositBtn'])) {
    $rendeles_id = $_POST['rendeles_id'];
    $tetel_id = $_POST['tetel_id'];
    $uj_mennyiseg = $_POST['uj_mennyiseg'];

    if ($uj_mennyiseg > 0) {
        $update_query = "UPDATE tetelek SET tetelek_mennyiseg = ? WHERE id = ?";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->execute([$uj_mennyiseg, $tetel_id]);
    } else {
        $delete_query = "DELETE FROM tetelek WHERE id = ?";
        $delete_stmt = $pdo->prepare($delete_query);
        $delete_stmt->execute([$tetel_id]);
    }

    $osszeg_query = "SELECT SUM(tetelek.tetelek_mennyiseg * COALESCE(termek.akcios_ar, termek.egysegar)) AS vegosszeg
                     FROM tetelek
                     JOIN termek ON tetelek.termek_id = termek.id
                     WHERE tetelek.rendeles_id = ?";
    $osszeg_stmt = $pdo->prepare($osszeg_query);
    $osszeg_stmt->execute([$rendeles_id]);
    $osszeg_result = $osszeg_stmt->fetch(PDO::FETCH_ASSOC);
    $vegosszeg = $osszeg_result['vegosszeg'];

    $szallitasi_dij = ($vegosszeg >= 25000) ? 0 : 1690;
    $vegosszeg += $szallitasi_dij;

    $update_total_query = "UPDATE megrendeles SET vegosszeg = ?, szallitas = ?, osszeg = vegosszeg-szallitas, szallitasi_mod='standard' WHERE id = ?";
    $update_total_stmt = $pdo->prepare($update_total_query);
    $update_total_stmt->execute([$vegosszeg, $szallitasi_dij, $rendeles_id]);

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
    <link rel="icon" type="image/x-icon" href="./képek/HaLálip.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Rendelés Szerkesztése (ID: <?php echo htmlspecialchars($rendeles_id); ?>)</h2>
    <?php if(isset($tetel_adatok) && is_array($tetel_adatok)) foreach ($tetel_adatok as $tetel): ?>
        <form method="POST">
            <input type="hidden" name="rendeles_id" value="<?php echo $rendeles_id; ?>">
            <input type="hidden" name="tetel_id" value="<?php echo $tetel['tetel_id']; ?>">
            <div class="mb-3">
                <label><?php echo htmlspecialchars($tetel['nev']); ?> (Egységár: <?php echo htmlspecialchars($tetel['egysegar']); ?> Ft)</label>
                <input type="number" name="uj_mennyiseg" value="<?php echo htmlspecialchars($tetel['tetelek_mennyiseg']); ?>" min="0" class="form-control">
            </div>
            <button type="submit" name="modositBtn" class="btn btn-primary">Módosítás</button>
        </form>
    <?php endforeach; ?>

    <form method="POST" class="mt-4">
        <input type="hidden" name="rendeles_id" value="<?php echo $rendeles_id; ?>">
        <div class="mb-3">
            <label for="fizetesi_mod">Fizetési mód</label>
            <select name="fizetesi_mod" id="fizetesi_mod" class="form-control">
                <option value="bankkartya" <?php echo (isset($_POST['fizetesi_mod']) && $_POST['fizetesi_mod'] === 'bankkartya') ? 'selected' : ''; ?>>Bankkártya</option>
                <option value="utanvet" <?php echo (isset($_POST['fizetesi_mod']) && $_POST['fizetesi_mod'] === 'utanvet') ? 'selected' : ''; ?>>Utánvét</option>
            </select>
        </div>
        <button type="submit" name="fizmodBtn" class="btn btn-success">Fizetési mód frissítése</button>
    </form>

    <a href="orders.php" class="btn btn-secondary mt-3">Vissza</a>
</div>
</body>
</html>
