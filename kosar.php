<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Inicializálás, ha szükséges
if (!isset($_SESSION['kosar'])) {
    $_SESSION['kosar'] = [];
}

// Session frissítése adatbázisból (opcionális)
function frissit_session_adatbazisbol($conn) {
    if (isset($_SESSION['felhasznalo']['id'])) {
        $query = "SELECT * FROM felhasznalok WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_SESSION['felhasznalo']['id']]);
        $_SESSION['felhasznalo'] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Profil teljesség ellenőrzés
function teljes_e_a_profil($userData) {
    $requiredFields = ['vezeteknev', 'keresztnev', 'email', 'telefonszam', 
                       'szamlazasi_iranyitoszam', 'szamlazasi_telepules', 
                       'szamlazasi_utca', 'szamlazasi_hazszam'];
    
    // Ellenőrzés: Alap mezők
    foreach ($requiredFields as $field) {
        if (empty($userData[$field])) {
            error_log("Hiányzó mező: $field");
            return false; 
        }
    }
    
    // Szállítási cím eltér? Ellenőrzés csak akkor
    if (!empty($userData['kezbesitesi_iranyitoszam']) && 
        $userData['kezbesitesi_iranyitoszam'] != $userData['szamlazasi_iranyitoszam']) {

        $shippingFields = ['kezbesitesi_iranyitoszam', 'kezbesitesi_telepules', 
                           'kezbesitesi_utca', 'kezbesitesi_hazszam'];
        
        foreach ($shippingFields as $field) {
            if (empty($userData[$field])) {
                error_log("Hiányzó szállítási mező: $field");
                return false; 
            }
        }
    }

    // Céges mezők kezelése
    if (!empty($userData['szamlazasi_cegnev']) || !empty($userData['szamlazasi_adoszam'])) {
        if (empty($userData['szamlazasi_cegnev']) || empty($userData['szamlazasi_adoszam'])) {
            error_log("Hiányzó céges mező: szamlazasi_cegnev vagy szamlazasi_adoszam");
            return false; 
        }
    }

    return true; // Profil teljes
}



// Kosár kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        $termek_id = $_POST['termek_id'];
        $termek_nev = $_POST['termek_nev'];
        $ar = $_POST['ar'];
        $mennyiseg = $_POST['mennyiseg'];
        $kep = $_POST['termek_kep'];

        $van_mar = false;
        foreach ($_SESSION['kosar'] as &$termek) {
            if ($termek['termek_id'] === $termek_id) {
                $termek['mennyiseg'] += $mennyiseg;
                $van_mar = true;
                break;
            }
        }

        if (!$van_mar) {
            $_SESSION['kosar'][] = [
                'termek_id' => $termek_id,
                'termek_nev' => $termek_nev,
                'ar' => $ar,
                'mennyiseg' => $mennyiseg,
                'termek_kep' => $kep
            ];
        }
    } elseif (isset($_POST['update_cart'])) {
        foreach ($_POST['mennyisegek'] as $index => $uj_mennyiseg) {
            if ($uj_mennyiseg > 0) {
                $_SESSION['kosar'][$index]['mennyiseg'] = (int)$uj_mennyiseg;
            } else {
                unset($_SESSION['kosar'][$index]);
            }
        }
        $_SESSION['kosar'] = array_values($_SESSION['kosar']); // Újrendezés
    } elseif (isset($_POST['empty_cart'])) {
        $_SESSION['kosar'] = [];
    }
    header("Location: kosar.php");
    exit();
}

// Kosár összesítő számítás
function osszegzo($kosar) {
    $osszesen = 0;
    foreach ($kosar as $termek) {
        $osszesen += $termek['ar'] * $termek['mennyiseg'];
    }
    return $osszesen;
}

// Bejelentkezési állapot ellenőrzése
$bejelentkezve = isset($_SESSION['felhasznalo']);
$profil_teljes = $bejelentkezve ? teljes_e_a_profil($_SESSION['felhasznalo']) : false;
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
    <link rel="stylesheet" href="./style/style.css">
    <title>Kosár</title>
</head>
<body>

    <?php include './navbar.php'; ?>

    <div class="container main-container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h2>Kosár</h2>
                <?php if (empty($_SESSION['kosar'])): ?>
                    <div class="alert alert-warning">A kosár üres. <a href="termekek.php">Vásárlás folytatása</a></div>
                <?php else: ?>
                    <form method="POST" action="kosar.php">
                        <?php foreach ($_SESSION['kosar'] as $index => $termek): ?>
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="<?= htmlspecialchars($termek['termek_kep']) ?>" class="img-fluid rounded-start" alt="<?= htmlspecialchars($termek['termek_nev']) ?>">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($termek['termek_nev']) ?></h5>
                                            <p class="card-text"><?= $termek['ar'] ?> Ft / db</p>
                                            <input type="number" name="mennyisegek[<?= $index ?>]" value="<?= $termek['mennyiseg'] ?>" min="1" class="form-control w-25">
                                            <p class="card-text"><strong><?= $termek['ar'] * $termek['mennyiseg'] ?> Ft</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <button type="submit" name="update_cart" class="btn btn-primary">Kosár frissítése</button>
                        <button type="submit" name="empty_cart" class="btn btn-danger">Kosár ürítése</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <h3>Rendelés összesítő</h3>
                <p>Összesen: <strong><?= osszegzo($_SESSION['kosar']) ?> Ft</strong></p>
                <p>Szállítás: <strong>1690 Ft</strong></p>
                <p>ÁFA: <strong><?= round(osszegzo($_SESSION['kosar']) * 0.27, 2) ?> Ft</strong></p>
                <h4>Végösszeg: <strong><?= osszegzo($_SESSION['kosar']) + 1690 ?> Ft</strong></h4>
                <?php if (!$bejelentkezve): ?>
                    <div class="alert alert-danger">Vásárlás folytatásához kérjük, jelentkezzen be! <a href="profil.php">Bejelentkezés</a></div>
                <?php elseif (!$profil_teljes): ?>
                    <div class="alert alert-danger">Vásárlás folytatásához kérjük, töltse ki a profilját! <a href="profil.php">Profil szerkesztése</a></div>
                <?php else: ?>
                    <button class="btn btn-success w-100">Tovább a fizetéshez</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
