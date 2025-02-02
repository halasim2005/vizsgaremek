<?php
session_start();
include 'db.php';

if (!isset($_SESSION['felhasznalo'])) {
    header("Location: bejelentkezes.php");
    exit;
}

$fh_nev = $_SESSION['felhasznalo']['fh_nev'];

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

    header("Location: profil");
    if ($updateQuery->execute()) {
        $message = "Adatok sikeresen frissítve!";
    } else {
        $message = "Hiba történt az adatok frissítésekor.";
    }
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
<?php include './nav.php'; ?>

<div class="container my-5">
        <h1 class="text-center form-label mb-4">Profil Szerkesztése</h1>
        
        <?php if (isset($message)) : ?>
            <div class="alert alert-info text-center" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="profile-form">
            <!-- Személyes adatok -->
            <div class="card mb-4 personal-info">
                <div class="card-header text-white bg-primary">Személyes adatok</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vezeteknev" class="form-label">Vezetéknév</label>
                            <input type="text" id="vezeteknev" name="vezeteknev" class="form-control w-100" value="<?= htmlspecialchars($userData['vezeteknev']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="keresztnev" class="form-label">Keresztnév</label>
                            <input type="text" id="keresztnev" name="keresztnev" class="form-control w-100" value="<?= htmlspecialchars($userData['keresztnev']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control w-100" value="<?= htmlspecialchars($userData['email']) ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="telefonszam" class="form-label">Telefonszám</label>
                            <div class="input-group">
                                <input type="text" id="telefonszam" name="telefonszam" class="form-control w-100" placeholder="+36 20 123 4567" value="<?= htmlspecialchars($userData['telefonszam']) ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Számlázási cím -->
            <div class="card mb-4 billing-info">
                <div class="card-header text-white bg-secondary">Számlázási cím</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="szamlazasi_iranyitoszam" class="form-label">Irányítószám</label>
                            <input type="text" id="szamlazasi_iranyitoszam" name="szamlazasi_iranyitoszam" class="form-control w-100" value="<?= htmlspecialchars($userData['szamlazasi_iranyitoszam']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="szamlazasi_telepules" class="form-label">Település</label>
                            <input type="text" id="szamlazasi_telepules" name="szamlazasi_telepules" class="form-control w-100" value="<?= htmlspecialchars($userData['szamlazasi_telepules']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="szamlazasi_utca" class="form-label">Utca</label>
                            <input type="text" id="szamlazasi_utca" name="szamlazasi_utca" class="form-control w-100" value="<?= htmlspecialchars($userData['szamlazasi_utca']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="szamlazasi_hazszam" class="form-label">Házszám</label>
                            <input type="text" id="szamlazasi_hazszam" name="szamlazasi_hazszam" class="form-control w-100" value="<?= htmlspecialchars($userData['szamlazasi_hazszam']) ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kézbesítési cím -->
            <div class="card mb-4 shipping-info">
                <div class="card-header text-white bg-success">Kézbesítési cím</div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="same_address" name="same_address" <?= $userData['kezbesitesi_iranyitoszam'] == $userData['szamlazasi_iranyitoszam'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="same_address">Számlázási címmel megegyezik</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kezbesitesi_iranyitoszam" class="form-label">Irányítószám</label>
                            <input type="text" id="kezbesitesi_iranyitoszam" name="kezbesitesi_iranyitoszam" class="form-control w-100" value="<?= htmlspecialchars($userData['kezbesitesi_iranyitoszam']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kezbesitesi_telepules" class="form-label">Település</label>
                            <input type="text" id="kezbesitesi_telepules" name="kezbesitesi_telepules" class="form-control w-100" value="<?= htmlspecialchars($userData['kezbesitesi_telepules']) ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kezbesitesi_utca" class="form-label">Utca</label>
                            <input type="text" id="kezbesitesi_utca" name="kezbesitesi_utca" class="form-control w-100" value="<?= htmlspecialchars($userData['kezbesitesi_utca']) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kezbesitesi_hazszam" class="form-label">Házszám</label>
                            <input type="text" id="kezbesitesi_hazszam" name="kezbesitesi_hazszam" class="form-control w-100" value="<?= htmlspecialchars($userData['kezbesitesi_hazszam']) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Céges adatok -->
            <div class="card mb-4 company-info">
                <div class="card-header text-white bg-warning">Céges vásárlás (opcionális)</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="szamlazasi_cegnev" class="form-label">Cég neve</label>
                            <input type="text" id="szamlazasi_cegnev" name="szamlazasi_cegnev" class="form-control" value="<?= htmlspecialchars($userData['szamlazasi_cegnev']) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="szamlazasi_adoszam" class="form-label">Cég adószáma</label>
                            <input type="text" id="szamlazasi_adoszam" name="szamlazasi_adoszam" class="form-control" value="<?= htmlspecialchars($userData['szamlazasi_adoszam']) ?>">
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="ceg" name="ceg" <?= $userData['szamlazasi_cegnev'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="ceg">Céges vásárlás</label>
                        </div>
                    </div>
                </div>
            </div>

    <button type="submit" class="btn btn-primary w-100">Mentés</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="./js/inputmask.min.js"></script>
<script src="./js/inputmask.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const telefonszamInput = document.getElementById("telefonszam");
        Inputmask({ mask: "+36 99 999 9999" }).mask(telefonszamInput);
    });
</script>
</body>
</html>
