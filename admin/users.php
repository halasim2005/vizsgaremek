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
    <h2 class="text-center">Felhasználók kezelése</h2>
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
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-user="<?php echo htmlspecialchars($user['fh_nev']); ?>">Törlés</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Törlési modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="deleteModalLabel">Felhasználó törlése</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
            </div>
            <div class="modal-body text-black">
                <p>Biztosan törölni szeretnéd <strong id="deleteUserName"></strong> nevű felhasználót? Nem fogod tudni visszavonni ezt a törlést!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Mégse</button>
                <form id="deleteForm" method="POST" action="delete_user.php">
                    <input type="hidden" name="user" id="deleteUserInput">
                    <button type="submit" class="btn btn-danger">Törlés</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userName = button.getAttribute('data-user');
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteUserInput').value = userName;
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
