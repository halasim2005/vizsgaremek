<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

include '../db.php'; // Az adatbázis-kapcsolatot tartalmazó fájl

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

    $updateQuery = $pdo->prepare("
        UPDATE felhasznalo SET 
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
        WHERE fh_nev = :fh_nev
    ");
    
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
</head>
<body>
<?php include './admin_navbar.php';?>
<div class="container mt-5">
    <h2>Felhasználó szerkesztése: <?php echo htmlspecialchars($user['fh_nev']); ?></h2>
    <form method="POST">
        <div class="mb-3"><label>Vezetéknév</label>
            <input type="text" name="vezeteknev" class="form-control" value="<?php echo htmlspecialchars($user['vezeteknev']); ?>" required>
        </div>
        <div class="mb-3"><label>Keresztnév</label>
            <input type="text" name="keresztnev" class="form-control" value="<?php echo htmlspecialchars($user['keresztnev']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="telefonszam" class="form-label">Telefonszám</label>
            <input type="text" name="telefonszam" id="telefonszam" class="form-control" value="<?php echo htmlspecialchars($user['telefonszam']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="jogosultsag" class="form-label">Jogosultság</label>
            <select name="jogosultsag" id="jogosultsag" class="form-control">
                <option value="user" <?php echo $user['jogosultsag'] === 'user' ? 'selected' : ''; ?>>Felhasználó</option>
                <option value="admin" <?php echo $user['jogosultsag'] === 'admin' ? 'selected' : ''; ?>>Adminisztrátor</option>
            </select>
        </div>


        <h4>Számlázási adatok</h4>
        <div class="mb-3"><label>Irányítószám</label>
            <input type="text" name="szamlazasi_iranyitoszam" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_iranyitoszam']); ?>" required>
        </div>
        <div class="mb-3"><label>Település</label>
            <input type="text" name="szamlazasi_telepules" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_telepules']); ?>" required>
        </div>
        <div class="mb-3"><label>Utca</label>
            <input type="text" name="szamlazasi_utca" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_utca']); ?>" required>
        </div>
        <div class="mb-3"><label>Házszám</label>
            <input type="text" name="szamlazasi_hazszam" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_hazszam']); ?>" required>
        </div>

        
        <h4>Kézbesítési adatok</h4>
        <div class="mb-3"><label>Irányítószám</label>
        <input type="text" name="kezbesitesi_iranyitoszam" class="form-control" value="<?php echo htmlspecialchars($user['kezbesitesi_iranyitoszam']); ?>" required>
        </div>
        <div class="mb-3"><label>Település</label>
            <input type="text" name="kezbesitesi_telepules" class="form-control" value="<?php echo htmlspecialchars($user['kezbesitesi_telepules']); ?>" required>
        </div>
        <div class="mb-3"><label>Utca</label>
            <input type="text" name="kezbesitesi_utca" class="form-control" value="<?php echo htmlspecialchars($user['kezbesitesi_utca']); ?>" required>
        </div>
        <div class="mb-3"><label>Házszám</label>
            <input type="text" name="kezbesitesi_hazszam" class="form-control" value="<?php echo htmlspecialchars($user['kezbesitesi_hazszam']); ?>" required>
        </div>

        <h4>Cég adatok</h4>
        <div class="mb-3"><label>Cégnév</label>
            <input type="text" name="szamlazasi_cegnev" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_cegnev']); ?>">
        </div>
        <div class="mb-3"><label>Adószám</label>
            <input type="text" name="szamlazasi_adoszam" class="form-control" value="<?php echo htmlspecialchars($user['szamlazasi_adoszam']); ?>">
        </div>

        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="users.php" class="btn btn-danger">Vissza</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
