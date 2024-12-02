<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

include '../db.php'; // Az adatbázis-kapcsolatot tartalmazó fájl

// Ellenőrzés, hogy van-e felhasználónév az URL-ben
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

// Adatok frissítése az űrlap beküldésekor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? $user['email'];
    $telefonszam = $_POST['telefonszam'] ?? $user['telefonszam'];
    $jogosultsag = $_POST['jogosultsag'] ?? $user['jogosultsag'];

    // Frissítési lekérdezés
    $updateQuery = $pdo->prepare("
        UPDATE felhasznalo 
        SET email = :email, telefonszam = :telefonszam, jogosultsag = :jogosultsag 
        WHERE fh_nev = :fh_nev
    ");
    $success = $updateQuery->execute([
        ':email' => $email,
        ':telefonszam' => $telefonszam,
        ':jogosultsag' => $jogosultsag,
        ':fh_nev' => $fh_nev,
    ]);

    if ($success) {
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
</head>
<body>
<?php include './admin_navbar.php';?>
<div class="container mt-5">
    <h1>Felhasználó szerkesztése: <?php echo htmlspecialchars($user['fh_nev']); ?></h1>
    <form method="POST">
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
        <button type="submit" class="btn btn-success">Mentés</button>
        <a href="users.php" class="btn btn-secondary">Vissza</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
