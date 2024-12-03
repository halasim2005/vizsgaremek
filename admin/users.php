<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

include '../db.php'; // Az adatbázis-kapcsolatot tartalmazó fájl


// Felhasználói adatok és költés lekérdezése
$userQuery = $pdo->prepare("
    SELECT 
        f.fh_nev, 
        f.email, 
        f.telefonszam, 
        f.jogosultsag, 
        COALESCE(SUM(t.egysegar * te.tetelek_mennyiseg), 0) AS total_spent
    FROM felhasznalo f
    LEFT JOIN megrendeles m ON f.fh_nev = m.fh_nev
    LEFT JOIN tetelek te ON m.id = te.rendeles_id
    LEFT JOIN termek t ON te.termek_id = t.id
    GROUP BY f.fh_nev
");
$userQuery->execute();
$users = $userQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felhasználók kezelése</title>
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
    <h1 class="text-center">Felhasználók kezelése</h1>
    <div class="row">
        <?php foreach ($users as $user): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title text-center">
                            <?php echo htmlspecialchars($user['fh_nev']); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Telefonszám:</strong> <?php echo htmlspecialchars($user['telefonszam']); ?></p>
                        <p><strong>Jogosultság:</strong> <?php echo htmlspecialchars($user['jogosultsag']); ?></p>
                        <p><strong>Összes költés:</strong> <?php echo number_format($user['total_spent'], 0, ',', ' ') . ' Ft'; ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="edit_user.php?user=<?php echo urlencode($user['fh_nev']); ?>" class="btn btn-primary btn-sm">Szerkesztés</a>
                        <a href="delete_user.php?user=<?php echo urlencode($user['fh_nev']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd ezt a felhasználót?');">Törlés</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
