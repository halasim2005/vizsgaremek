<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

include '../db.php';

if (!isset($_GET['user']) || empty($_GET['user'])) {
    echo "Nincs kiválasztott felhasználó.";
    exit();
}

$fh_nev = $_GET['user'];

// Felhasználó adatainak lekérdezése
$userQuery = $pdo->prepare("SELECT * FROM felhasznalo WHERE fh_nev = :fh_nev");
$userQuery->execute([':fh_nev' => $fh_nev]);
$user = $userQuery->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "A felhasználó nem található.";
    exit();
}

// Adatok frissítése
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $updateData = [
        ':email' => $_POST['email'] ?? $user['email'],
        ':telefonszam' => $_POST['telefonszam'] ?? $user['telefonszam'],
        ':jogosultsag' => $_POST['jogosultsag'] ?? $user['jogosultsag'],
        ':vezeteknev' => $_POST['vezeteknev'] ?? $user['vezeteknev'],
        ':keresztnev' => $_POST['keresztnev'] ?? $user['keresztnev'],
        ':szamlazasi_iranyitoszam' => $_POST['szamlazasi_iranyitoszam'] ?? $user['szamlazasi_iranyitoszam'],
        ':szamlazasi_telepules' => $_POST['szamlazasi_telepules'] ?? $user['szamlazasi_telepules'],
        ':szamlazasi_utca' => $_POST['szamlazasi_utca'] ?? $user['szamlazasi_utca'],
        ':szamlazasi_hazszam' => $_POST['szamlazasi_hazszam'] ?? $user['szamlazasi_hazszam'],
        ':szamlazasi_cegnev' => $_POST['szamlazasi_cegnev'] ?? $user['szamlazasi_cegnev'],
        ':szamlazasi_adoszam' => $_POST['szamlazasi_adoszam'] ?? $user['szamlazasi_adoszam'],
        ':kezbesitesi_iranyitoszam' => $_POST['kezbesitesi_iranyitoszam'] ?? $user['kezbesitesi_iranyitoszam'],
        ':kezbesitesi_telepules' => $_POST['kezbesitesi_telepules'] ?? $user['kezbesitesi_telepules'],
        ':kezbesitesi_utca' => $_POST['kezbesitesi_utca'] ?? $user['kezbesitesi_utca'],
        ':kezbesitesi_hazszam' => $_POST['kezbesitesi_hazszam'] ?? $user['kezbesitesi_hazszam'],
        ':fh_nev' => $fh_nev,
    ];

    // Ha van új jelszó, akkor hash-eljük és frissítjük
    if (!empty($_POST['jelszo'])) {
        $updateData[':jelszo'] = password_hash($_POST['jelszo'], PASSWORD_BCRYPT);
        $updateQuery = $pdo->prepare("UPDATE felhasznalo SET 
            email = :email,
            telefonszam = :telefonszam,
            jogosultsag = :jogosultsag,
            vezeteknev = :vezeteknev,
            keresztnev = :keresztnev,
            szamlazasi_iranyitoszam = :szamlazasi_iranyitoszam,
            szamlazasi_telepules = :szamlazasi_telepules,
            szamlazasi_utca = :szamlazasi_utca,
            szamlazasi_hazszam = :szamlazasi_hazszam,
            szamlazasi_cegnev = :szamlazasi_cegnev,
            szamlazasi_adoszam = :szamlazasi_adoszam,
            kezbesitesi_iranyitoszam = :kezbesitesi_iranyitoszam,
            kezbesitesi_telepules = :kezbesitesi_telepules,
            kezbesitesi_utca = :kezbesitesi_utca,
            kezbesitesi_hazszam = :kezbesitesi_hazszam,
            jelszo = :jelszo
        WHERE fh_nev = :fh_nev");
    } else {
        $updateQuery = $pdo->prepare("UPDATE felhasznalo SET 
            email = :email,
            telefonszam = :telefonszam,
            jogosultsag = :jogosultsag,
            vezeteknev = :vezeteknev,
            keresztnev = :keresztnev,
            szamlazasi_iranyitoszam = :szamlazasi_iranyitoszam,
            szamlazasi_telepules = :szamlazasi_telepules,
            szamlazasi_utca = :szamlazasi_utca,
            szamlazasi_hazszam = :szamlazasi_hazszam,
            szamlazasi_cegnev = :szamlazasi_cegnev,
            szamlazasi_adoszam = :szamlazasi_adoszam,
            kezbesitesi_iranyitoszam = :kezbesitesi_iranyitoszam,
            kezbesitesi_telepules = :kezbesitesi_telepules,
            kezbesitesi_utca = :kezbesitesi_utca,
            kezbesitesi_hazszam = :kezbesitesi_hazszam
        WHERE fh_nev = :fh_nev");
    }
    
    if ($updateQuery->execute($updateData)) {
        header("Location: users.php?message=Sikeres frissítés");
        exit();
    } else {
        echo "Frissítési hiba történt.";
    }
}
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felhasználó szerkesztése</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
    <link rel="icon" type="image/x-icon" href="./képek/HaLálip.ico">
</head>
<body>
<?php include './admin_navbar.php';?>
<div class="container mt-5">
    <form method="POST">
    <h2>Felhasználó szerkesztése: <?php echo htmlspecialchars($user['fh_nev']); ?>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="users.php" class="btn btn-danger">Vissza</a>
    </h2><hr>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Jelszó</label>
                <input type="password" name="jelszo" class="form-control">
            </div>
            <div class="mb-3 col-md-6">
                <label for="jogosultsag" class="form-label">Jogosultság</label>
                <select name="jogosultsag" id="jogosultsag" class="form-control" <?php echo $user['fh_nev'] === $_SESSION['felhasznalo']['fh_nev'] ? 'disabled' : ''  ?>>
                    <option value="user" <?php echo $user['jogosultsag'] === 'user' ? 'selected' : ''; ?>>Felhasználó</option>
                    <option value="admin" <?php echo $user['jogosultsag'] === 'admin' ? 'selected' : ''; ?>>Adminisztrátor</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Vezetéknév</label>
                <input type="text" name="vezeteknev" class="form-control" value="<?php echo htmlspecialchars($user['vezeteknev']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Keresztnév</label>
                <input type="text" name="keresztnev" class="form-control" value="<?php echo htmlspecialchars($user['keresztnev']); ?>">
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label for="telefonszam" class="form-label">Telefonszám</label>
                <input type="text" name="telefonszam" placeholder="+36 30 123 4567" id="telefonszam" class="form-control" value="<?php echo htmlspecialchars($user['telefonszam']); ?>">
            </div>
        </div>


        <hr><h4>Számlázási adatok</h4>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Irányítószám</label>
                <input type="text" name="szamlazasi_iranyitoszam" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_iranyitoszam']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Település</label>
                <input type="text" name="szamlazasi_telepules" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_telepules']); ?>">
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Utca</label>
                <input type="text" name="szamlazasi_utca" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_utca']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Házszám</label>
                <input type="text" name="szamlazasi_hazszam" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_hazszam']); ?>">
            </div>
        </div>
        
        <hr><h4>Kézbesítési adatok</h4>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Irányítószám</label>
                <input type="text" name="kezbesitesi_iranyitoszam" class="form-control" value="<?php echo htmlspecialchars($user['kezbesitesi_iranyitoszam']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Település</label>
                <input type="text" name="kezbesitesi_telepules" class="form-control" value="<?php echo htmlspecialchars($user['kezbesitesi_telepules']); ?>">
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Utca</label>
                <input type="text" name="kezbesitesi_utca" class="form-control" value="<?php echo htmlspecialchars($user['kezbesitesi_utca']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Házszám</label>
                <input type="text" name="kezbesitesi_hazszam" class="form-control" value="<?php echo htmlspecialchars($user['kezbesitesi_hazszam']); ?>">
            </div>
        </div>

        <hr><h4>Cég adatok</h4>
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Cégnév</label>
                <input type="text" name="szamlazasi_cegnev" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_cegnev']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Adószám</label>
                <input type="text" name="szamlazasi_adoszam" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_adoszam']); ?>">
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="users.php" class="btn btn-danger">Vissza</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/inputmask.min.js"></script>
<script src="../js/inputmask.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const telefonszamInput = document.getElementById("telefonszam");
        Inputmask({ mask: "+36 99 999 9999" }).mask(telefonszamInput);
    });
</script>
</body>
</html>
