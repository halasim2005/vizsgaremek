<?php
session_start();
include 'db.php';

if (!isset($_SESSION['felhasznalo'])) {
    header("Location: bejelentkezes.php");
    exit;
}

$fh_nev = $_SESSION['felhasznalo'];

// Felhasználó adatok lekérdezése
$query = $pdo->prepare("SELECT * FROM felhasznalo WHERE fh_nev = :fh_nev");
$query->bindParam(':fh_nev', $fh_nev, PDO::PARAM_STR);
$query->execute();
$userData = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Felhasználói adatok
    $vezeteknev = $_POST['vezeteknev'];
    $keresztnev = $_POST['keresztnev'];
    $email = $_POST['email'];
    $telefonszam = $_POST['telefonszam'];
    
    // Számlázási adatok
    $szamlazasi_iranyitoszam = $_POST['szamlazasi_iranyitoszam'];
    $szamlazasi_telepules = $_POST['szamlazasi_telepules'];
    $szamlazasi_utca = $_POST['szamlazasi_utca'];
    $szamlazasi_hazszam = $_POST['szamlazasi_hazszam'];

    // Kézbesítési cím, ha a checkbox be van jelölve
    if (isset($_POST['same_address'])) {
        $kezbesitesi_iranyitoszam = $szamlazasi_iranyitoszam;
        $kezbesitesi_telepules = $szamlazasi_telepules;
        $kezbesitesi_utca = $szamlazasi_utca;
        $kezbesitesi_hazszam = $szamlazasi_hazszam;
    } else {
        $kezbesitesi_iranyitoszam = $_POST['kezbesitesi_iranyitoszam'];
        $kezbesitesi_telepules = $_POST['kezbesitesi_telepules'];
        $kezbesitesi_utca = $_POST['kezbesitesi_utca'];
        $kezbesitesi_hazszam = $_POST['kezbesitesi_hazszam'];
    }

    // Céges vásárlás, ha be van jelölve
    if (isset($_POST['ceg'])) {
        $cegnev = $_POST['szamlazasi_cegnev'];
        $ceg_adoszam = $_POST['szamlazasi_adoszam'];
    } else {
        $cegnev = null;
        $ceg_adoszam = null;
    }

    // Adatok frissítése az adatbázisban
    $updateQuery = $pdo->prepare("
        UPDATE felhasznalo 
        SET 
            vezeteknev = :vezeteknev, 
            keresztnev = :keresztnev, 
            email = :email, 
            telefonszam = :telefonszam, 
            szamlazasi_iranyitoszam = :szamlazasi_iranyitoszam, 
            szamlazasi_telepules = :szamlazasi_telepules, 
            szamlazasi_utca = :szamlazasi_utca, 
            szamlazasi_hazszam = :szamlazasi_hazszam, 
            kezbesitesi_iranyitoszam = :kezbesitesi_iranyitoszam,
            kezbesitesi_telepules = :kezbesitesi_telepules,
            kezbesitesi_utca = :kezbesitesi_utca,
            kezbesitesi_hazszam = :kezbesitesi_hazszam,
            szamlazasi_cegnev = :szamlazasi_cegnev,
            szamlazasi_adoszam = :szamlazasi_adoszam
        WHERE fh_nev = :fh_nev
    ");

    $updateQuery->bindParam(':vezeteknev', $vezeteknev, PDO::PARAM_STR);
    $updateQuery->bindParam(':keresztnev', $keresztnev, PDO::PARAM_STR);
    $updateQuery->bindParam(':email', $email, PDO::PARAM_STR);
    $updateQuery->bindParam(':telefonszam', $telefonszam, PDO::PARAM_STR);
    $updateQuery->bindParam(':szamlazasi_iranyitoszam', $szamlazasi_iranyitoszam, PDO::PARAM_INT);
    $updateQuery->bindParam(':szamlazasi_telepules', $szamlazasi_telepules, PDO::PARAM_STR);
    $updateQuery->bindParam(':szamlazasi_utca', $szamlazasi_utca, PDO::PARAM_STR);
    $updateQuery->bindParam(':szamlazasi_hazszam', $szamlazasi_hazszam, PDO::PARAM_STR);
    $updateQuery->bindParam(':kezbesitesi_iranyitoszam', $kezbesitesi_iranyitoszam, PDO::PARAM_INT);
    $updateQuery->bindParam(':kezbesitesi_telepules', $kezbesitesi_telepules, PDO::PARAM_STR);
    $updateQuery->bindParam(':kezbesitesi_utca', $kezbesitesi_utca, PDO::PARAM_STR);
    $updateQuery->bindParam(':kezbesitesi_hazszam', $kezbesitesi_hazszam, PDO::PARAM_STR);
    $updateQuery->bindParam(':szamlazasi_cegnev', $cegnev, PDO::PARAM_STR);
    $updateQuery->bindParam(':szamlazasi_adoszam', $ceg_adoszam, PDO::PARAM_STR);
    $updateQuery->bindParam(':fh_nev', $fh_nev, PDO::PARAM_STR);

    if ($updateQuery->execute()) {
        $message = "Adatok sikeresen frissítve!";
    } else {
        $message = "Hiba történt az adatok frissítésekor.";
    }
    header("Location: profil");
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Profil</title>
</head>
<body>
<?php include './navbar.php'; ?>

<h1>Profil szerkesztése</h1>
<?php if (isset($message)) echo "<p>$message</p>"; ?>

<form method="POST">
    <div class="card mb-3">
        <div class="card-header">Személyes adatok</div>
        <div class="card-body">
            <label>Vezetéknév:</label>
            <input type="text" name="vezeteknev" value="<?= htmlspecialchars($userData['vezeteknev']) ?>" required><br>
            
            <label>Keresztnév:</label>
            <input type="text" name="keresztnev" value="<?= htmlspecialchars($userData['keresztnev']) ?>" required><br>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required><br>

            <label>Telefonszám:</label>
            <input type="text" name="telefonszam" value="<?= htmlspecialchars($userData['telefonszam']) ?>" required><br>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Számlázási cím</div>
        <div class="card-body">
            <label>Irányítószám:</label>
            <input type="text" name="szamlazasi_iranyitoszam" value="<?= htmlspecialchars($userData['szamlazasi_iranyitoszam']) ?>" required><br>

            <label>Település:</label>
            <input type="text" name="szamlazasi_telepules" value="<?= htmlspecialchars($userData['szamlazasi_telepules']) ?>" required><br>

            <label>Utca:</label>
            <input type="text" name="szamlazasi_utca" value="<?= htmlspecialchars($userData['szamlazasi_utca']) ?>" required><br>

            <label>Házszám:</label>
            <input type="text" name="szamlazasi_hazszam" value="<?= htmlspecialchars($userData['szamlazasi_hazszam']) ?>" required><br>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Kézbesítési cím</div>
        <div class="card-body">
            <label>Számlázási címmel megegyezik</label>
            <input type="checkbox" name="same_address" <?= $userData['kezbesitesi_iranyitoszam'] == $userData['szamlazasi_iranyitoszam'] ? 'checked' : '' ?>><br>

            <label>Irányítószám:</label>
            <input type="text" name="kezbesitesi_iranyitoszam" value="<?= htmlspecialchars($userData['kezbesitesi_iranyitoszam']) ?>"><br>

            <label>Település:</label>
            <input type="text" name="kezbesitesi_telepules" value="<?= htmlspecialchars($userData['kezbesitesi_telepules']) ?>"><br>

            <label>Utca:</label>
            <input type="text" name="kezbesitesi_utca" value="<?= htmlspecialchars($userData['kezbesitesi_utca']) ?>"><br>

            <label>Házszám:</label>
            <input type="text" name="kezbesitesi_hazszam" value="<?= htmlspecialchars($userData['kezbesitesi_hazszam']) ?>"><br>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">Céges vásárlás (opcionális)</div>
        <div class="card-body">
            <label for="szamlazasi_cegnev">Cég neve:</label>
            <input type="text" name="szamlazasi_cegnev" value="<?= htmlspecialchars($userData['szamlazasi_cegnev']) ?>"><br>

            <label for="szamlazasi_adoszam">Cég adószáma:</label>
            <input type="text" name="szamlazasi_adoszam" value="<?= htmlspecialchars($userData['szamlazasi_adoszam']) ?>"><br>

            <label>Céges vásárlás:</label>
            <input type="checkbox" name="ceg" <?= $userData['szamlazasi_cegnev'] ? 'checked' : '' ?>><br>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Mentés</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
