<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal");
    exit();
}

require_once '../db.php';
include './admin_navbar.php';


$statuszSzures = "";
if (isset($_GET['statusz']) && !empty($_GET['statusz'])) {
    $statuszSzures = " WHERE megrendeles.statusz = :statusz ";
}

// Rendelések lekérdezése
$query = "SELECT megrendeles.id as rendeles_id, megrendeles.statusz, megrendeles.vegosszeg, 
                felhasznalo.fh_nev, felhasznalo.kezbesitesi_iranyitoszam, felhasznalo.kezbesitesi_telepules, 
                felhasznalo.kezbesitesi_utca, felhasznalo.kezbesitesi_hazszam, felhasznalo.telefonszam, GROUP_CONCAT(termek.nev, ' (' , tetelek.tetelek_mennyiseg, ' db)') as termekek
          FROM megrendeles
          JOIN felhasznalo ON megrendeles.fh_nev = felhasznalo.fh_nev
          JOIN tetelek ON megrendeles.id = tetelek.rendeles_id
          JOIN termek ON tetelek.termek_id = termek.id
          $statuszSzures
          GROUP BY megrendeles.id";

$stmt = $pdo->prepare($query);

// Ha van státusz szűrés, akkor értéket adunk át a lekérdezéshez
if (!empty($statuszSzures)) {
    $stmt->bindParam(':statusz', $_GET['statusz']);
}

$stmt->execute();
$megrendeles = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Rendelések Kezelése</h2>
    <form method="GET" action="" class="mb-3 justify-content-center d-flex">
    <select name="statusz" id="statusz" class="form-select w-auto d-inline <?php if(isset($_GET['statusz'])) {
                                                                                switch ($_GET['statusz']) {
                                                                                    case "feldolgozás alatt":
                                                                                        echo "blue-bg";
                                                                                        break;
                                                                                    case "kész":
                                                                                        echo "green-bg";
                                                                                        break;
                                                                                    case "törölve":
                                                                                        echo "red-bg";
                                                                                        break;
                                                                                    default:
                                                                                        echo "";
                                                                                }
                                                                            }
        ?>" onchange="this.form.submit()">
        <option value="">Összes</option>
        <option value="feldolgozás alatt" <?php if(isset($_GET['statusz']) && $_GET['statusz'] == 'feldolgozás alatt') echo 'selected'; ?>>Feldolgozás alatt</option>
        <option value="kész" <?php if(isset($_GET['statusz']) && $_GET['statusz'] == 'kész') echo 'selected'; ?>>Kész</option>
        <option value="törölve" <?php if(isset($_GET['statusz']) && $_GET['statusz'] == 'törölve') echo 'selected'; ?>>Törölve</option>
    </select>
</form>
    <div class="row">
        <?php foreach ($megrendeles as $rendeles): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title" name="rendeles_id">Rendelés ID: <?php echo htmlspecialchars($rendeles['rendeles_id']); ?></h5>
                        <p class="card-text">
                            <strong>Felhasználó:</strong> <?php echo htmlspecialchars($rendeles['fh_nev']); ?><br>
                            <strong>Termékek:</strong><br> <?php echo htmlspecialchars($rendeles['termekek']); ?><br>
                            <strong>Végösszeg:</strong> <?php echo htmlspecialchars($rendeles['vegosszeg']); ?> Ft<br>
                            <strong>Státusz:</strong> <?php echo htmlspecialchars($rendeles['statusz']); ?><br>
                            <strong>Cím:</strong> <?php echo htmlspecialchars($rendeles['kezbesitesi_iranyitoszam']) . " " . $rendeles['kezbesitesi_telepules'] . " " .
                                                                              $rendeles['kezbesitesi_utca'] . " " . $rendeles['kezbesitesi_hazszam'] ?><br>
                            <strong>Telefonszám:</strong> <?php echo htmlspecialchars($rendeles['telefonszam']); ?><br>
                        </p>
                        <form method="POST" action="rendeles_szerkeszt.php" class="d-inline">
                            <input type="hidden" name="rendeles_id" value="<?php echo $rendeles['rendeles_id']; ?>">
                            <button type="submit" name="szerkeszt" class="btn btn-primary btn-sm">Szerkesztés</button>
                        </form>
                        <form method="POST" action="rendeles_torles.php" class="d-inline">
                            <input type="hidden" name="rendeles_id" value="<?php echo $rendeles['rendeles_id']; ?>">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" 
                                    data-rendelesid="<?php echo $rendeles['rendeles_id']; ?>">
                                Törlés
                            </button>
                        </form>
                        <form method="POST" action="rendeles_statusz.php" class="mt-2">
                            <input type="hidden" name="rendeles_id" value="<?php echo $rendeles['rendeles_id']; ?>">
                            <select name="statusz" class="form-select form-select-sm">
                                <option value="feldolgozás alatt" <?php if ($rendeles['statusz'] === 'feldolgozás alatt') echo 'selected'; ?>>Feldolgozás alatt</option>
                                <option value="kész" <?php if ($rendeles['statusz'] === 'kész') echo 'selected'; ?>>Kész</option>
                                <!--<option value="törölve" <?//php if ($rendeles['statusz'] === 'törölve') echo 'selected'; ?>>Törölve</option>-->
                                <option value="csomagolva" <?php if ($rendeles['statusz'] === 'csomagolva') echo 'selected'; ?>>Csomagolva</option>
                            </select>
                            <button type="submit" name="statusz_modositas" class="btn btn-success btn-sm mt-1">Mentés</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Törlés megerősítő Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black" id="confirmDeleteLabel">Biztosan törölni szeretnéd?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
      </div>
      <div class="modal-body text-black">
        Ezt a rendelést nem lehet visszaállítani.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Mégse</button>
        <form id="deleteForm" method="POST" action="rendeles_torles.php">
            <input type="hidden" name="rendeles_id" id="deleteRendelesId">
            <button type="submit" class="btn btn-danger">Igen, törlöm</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var confirmDeleteModal = document.getElementById('confirmDeleteModal');
    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var rendelesId = button.getAttribute('data-rendelesid');
        document.getElementById('deleteRendelesId').value = rendelesId;
    });
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
