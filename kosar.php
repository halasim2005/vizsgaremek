<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (!isset($_SESSION['kosar'])) {
    $_SESSION['kosar'] = [];
}
require_once './db.php';
include './sql_fuggvenyek.php';

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
    
    foreach ($requiredFields as $field) {
        if (empty($userData[$field])) {
            error_log("Hiányzó mező: $field");
            return false; 
        }
    }
    
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

    /*if (!empty($userData['szamlazasi_cegnev']) || !empty($userData['szamlazasi_adoszam'])) {
        if (empty($userData['szamlazasi_cegnev']) || empty($userData['szamlazasi_adoszam'])) {
            error_log("Hiányzó céges mező: szamlazasi_cegnev vagy szamlazasi_adoszam");
            return false; 
        }
    }*/

    return true; 
}

function betolt_kosar_adatbazisbol($pdo) {
    if (isset($_SESSION['felhasznalo']['fh_nev'])) {
        $fh_nev = $_SESSION['felhasznalo']['fh_nev'];
        $query = "SELECT tetelek.termek_id, tetelek.tetelek_mennyiseg, termek.nev as termek_nev, 
                            termek.egysegar, termek.kep as termek_kep, termek.elerheto_darab
                    FROM tetelek
                    INNER JOIN termek ON tetelek.termek_id = termek.id
                    WHERE tetelek.fh_nev = ? AND tetelek.statusz = 'kosárban'";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$fh_nev]);
        $_SESSION['kosar'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['kosar'] = [];
    }
}

betolt_kosar_adatbazisbol($pdo);

// Kosár összesítő számítás
function osszegzo($kosar) {
    $osszesen = 0;
    foreach ($kosar as $termek) {
        $osszesen += $termek['egysegar'] * $termek['tetelek_mennyiseg'];
    }
    return $osszesen;
}

if (isset($_POST['delete_item'])) {
    $termek_id = $_POST['delete_item']; // Az adott termék id-ját kapjuk meg

    if (!empty($termek_id) && isset($_SESSION['felhasznalo']['fh_nev'])) {
        $fh_nev = $_SESSION['felhasznalo']['fh_nev'];
        $termek_id_db = $_SESSION['kosar'][$index]['termek_id'];
        
        // Törlés a Session-ből
        foreach ($_SESSION['kosar'] as $index => $termek) {
            if ($termek['termek_id'] == $termek_id) {
                // Készlet frissítése
                $mennyiseg = $_POST['mennyisegek'][$index];
                $keszlet_update_query = "UPDATE termek SET elerheto_darab = elerheto_darab + ? WHERE id = ?";
                $keszlet_update_stmt = $pdo->prepare($keszlet_update_query);
                $keszlet_update_stmt->execute([$mennyiseg, $termek_id]);
                unset($_SESSION['kosar'][$index]);
                break;
            }
        }

        // Törlés az adatbázisból
        $query = "DELETE FROM tetelek WHERE fh_nev = ? AND termek_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$fh_nev, $termek_id]);

        // Újrendezés a Session-ben, hogy az indexek sorban legyenek
        $_SESSION['kosar'] = array_values($_SESSION['kosar']);
    }

    // Újratöltés a tiszta kérésekhez
    header("Location: kosar");
    exit();
}

if (isset($_POST['update_cart'])) {
    $fh_nev = $_SESSION['felhasznalo']['fh_nev'];

    foreach ($_POST['mennyisegek'] as $index => $uj_mennyiseg) {
        if (!isset($_SESSION['kosar'][$index])) {
            continue; // Ha nincs ilyen index a kosárban, lépjünk tovább
        }

        $termek_id = $_SESSION['kosar'][$index]['termek_id'];
        $regi_mennyiseg = $_SESSION['kosar'][$index]['mennyiseg']; // Régi mennyiség
        
        // 🔍 Debugging - Ellenőrizzük az értékeket
        error_log("Termék ID: $termek_id | Régi mennyiség: $regi_mennyiseg | Új mennyiség: $uj_mennyiseg");

        if ($uj_mennyiseg != $regi_mennyiseg) {
            // Ha az új mennyiség 0 vagy kisebb, töröljük az elemet
            if ($uj_mennyiseg <= 0) {
                unset($_SESSION['kosar'][$index]);

                // 🔍 Debugging
                error_log("Termék törölve: $termek_id | Visszaadott készlet: $regi_mennyiseg");

                // Törlés az adatbázisból
                $query = "DELETE FROM tetelek WHERE fh_nev = ? AND termek_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$fh_nev, $termek_id]);

                // Készlet visszaállítása
                $keszlet_update_query = "UPDATE termek SET elerheto_darab = elerheto_darab + ? WHERE id = ?";
                $keszlet_update_stmt = $pdo->prepare($keszlet_update_query);
                $keszlet_update_stmt->execute([$regi_mennyiseg, $termek_id]);
            } else {
                // **Csak a változást frissítsük!**
                $keszlet_kulonbseg = $regi_mennyiseg - $uj_mennyiseg;

                if ($keszlet_kulonbseg != 0) { // Csak ha ténylegesen változott
                    error_log("Készlet változás: $keszlet_kulonbseg | Termék ID: $termek_id");

                    $keszlet_update_query = "UPDATE termek SET elerheto_darab = elerheto_darab + ? WHERE id = ?";
                    $keszlet_update_stmt = $pdo->prepare($keszlet_update_query);
                    $keszlet_update_stmt->execute([$keszlet_kulonbseg, $termek_id]);
                }

                // **Session frissítése**
                $_SESSION['kosar'][$index]['mennyiseg'] = $uj_mennyiseg;

                // **Tételek tábla frissítése**
                $query = "UPDATE tetelek SET tetelek_mennyiseg = ? WHERE fh_nev = ? AND termek_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$uj_mennyiseg, $fh_nev, $termek_id]);
            }
        }
    }

    // Újrendezés a Session-ben, hogy az indexek sorban legyenek
    $_SESSION['kosar'] = array_values($_SESSION['kosar']);

    // 🔍 Debugging - Ellenőrizzük a végső kosár tartalmát
    error_log("Kosár végső állapota: " . print_r($_SESSION['kosar'], true));

    // Frissítés után irány vissza a kosár oldalra
    header("Location: kosar");
    exit();
}

if (isset($_POST['empty_cart'])) {
    if (isset($_SESSION['felhasznalo']['fh_nev'])) {
        $fh_nev = $_SESSION['felhasznalo']['fh_nev'];
        $termek_id = $_SESSION['kosar'][$index]['termek_id'];
        $mennyiseg = $_POST['mennyisegek'];

        // Törlés az adatbázisból
        $query = "DELETE FROM tetelek WHERE fh_nev = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$fh_nev]);

        // Készlet frissítése
        $keszlet_update_query = "UPDATE termek SET elerheto_darab = elerheto_darab + ? WHERE id = ?";
        $keszlet_update_stmt = $pdo->prepare($keszlet_update_query);
        $keszlet_update_stmt->execute([$mennyiseg, $termek_id]);
    }

    // Törlés a Session-ből
    $_SESSION['kosar'] = [];

    // Újratöltés a tiszta kérésekhez
    header("Location: kosar.php");
    exit();
}

if(isset($_POST['fizetes'])){
    // Szállítási mód és fizetési mód ellenőrzés
    $szallitasi_mod = isset($_POST['szallitasi_mod']) ? $_POST['szallitasi_mod'] : 'standard';
    $fizetesi_mod = isset($_POST['fizetesi_mod']) ? $_POST['fizetesi_mod'] : 'kartya';

    // Kosár összegzés
    $osszeg = osszegzo($_SESSION['kosar']);
    $szallitas = szallitas_dij($_SESSION['kosar']);
    $vegosszeg = $osszeg + $szallitas;

    // Felhasználónév lekérése
    $fh_nev = $_SESSION['felhasznalo']['fh_nev'];

    // Megrendelés DÁTUM lekérése
    $DATE_query = "SELECT megrendeles.leadas_datum FROM megrendeles ORDER BY megrendeles.id DESC LIMIT 1;";
    $DATE_megrendeles_array = adatokLekerdezese($DATE_query);
    if(is_array($DATE_megrendeles_array)){
        foreach($DATE_megrendeles_array as $D){
            $DATE_megrendeles = $D["leadas_datum"];
        }
    }

    // Megrendelés ID lekérése
    $ID_query = "SELECT megrendeles.id FROM megrendeles WHERE megrendeles.fh_nev = '{$fh_nev}' ORDER BY megrendeles.id DESC LIMIT 1;";
    $ID_megrendeles_array = adatokLekerdezese($ID_query);
    if(is_array($ID_megrendeles_array)){
        foreach($ID_megrendeles_array as $I){
            $ID_megrendeles = $I["id"];
        }
    }

    // Rendelés adatainak módosítása
    $RENDELES_query = "UPDATE megrendeles SET megrendeles.szallitasi_mod = ?, megrendeles.fizetesi_mod = ?, megrendeles.osszeg = ?, megrendeles.szallitas = ?, megrendeles.vegosszeg = ? WHERE megrendeles.fh_nev = ? AND megrendeles.leadas_datum = ? AND megrendeles.id = ?;";
    $RENDELES_stmt = $pdo->prepare($RENDELES_query);
    $RENDELES = $RENDELES_stmt->execute([$szallitasi_mod, $fizetesi_mod, $osszeg, $szallitas, $vegosszeg, $fh_nev, $DATE_megrendeles, $ID_megrendeles]);

    //Ellenőrzés, hogy sikeres volt-e a módosítás
    if($RENDELES){
        // Tételek tábla rendeles_id, státusz módosítás
        $UPDATE_query = "UPDATE tetelek SET tetelek.rendeles_id = ?, tetelek.statusz = 'leadva' WHERE tetelek.statusz = 'kosárban' AND tetelek.fh_nev = ?;";
        $UPDATE_stmt = $pdo->prepare($UPDATE_query);
        $UPDATE_stmt->execute([$ID_megrendeles, $fh_nev]);
    }

    // Kosár ürítése a session-ben
    $_SESSION['kosar'] = [];

    // Rendelés sikeres feldolgozása
    header("Location: rendeles_sikeres");
    exit();
}

function szallitas_dij($kosar) {
    $osszesen = osszegzo($kosar);
    return $osszesen >= 25000 ? 0 : 1690;
}

$szallitas = szallitas_dij($_SESSION['kosar']);
$vegosszeg = osszegzo($_SESSION['kosar']) + $szallitas;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <title>Kosár</title>
</head>
<style>
        .main-container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .summary {
            font-size: 1.2rem;
        }
        .form-check-label {
            margin-left: 10px;
        }
    </style>
<body>

    <?php include './nav.php'; ?>

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
                                            <h5 class="card-title kosarFelirat"><?= htmlspecialchars($termek['termek_nev']) ?></h5>
                                            <p class="card-text"><?= $termek['egysegar'] ?> Ft / db</p>
                                            <input type="number" name="mennyisegek[<?= $index ?>]" value="<?= $termek['tetelek_mennyiseg'] ?>" min="0" max="<?= $termek['elerheto_darab'] + $termek['tetelek_mennyiseg'] ?>" class="form-control w-25"><br>
                                            <p class="card-text kosarAr"><strong><?= $termek['egysegar'] * $termek['tetelek_mennyiseg'] ?> Ft</strong></p>
                                                <input type="hidden" name="termek_id" value="<?= htmlspecialchars($termek['termek_id']) ?>">
                                                <button type="submit" name="delete_item" value="<?= $termek['termek_id'] ?>" class="kukaGomb" ><img class="kukaKep" src="./képek/torlesikon.svg" href="Törlés"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                            <button type="submit" id="termekekKartyaGomb" name="update_cart" class="btn btn-primary">Kosár frissítése</button>
                            <button type="submit" id="termekekKartyaGomb" name="empty_cart" class="btn btn-danger">Kosár ürítése</button>
                        </form>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <?php if (!$bejelentkezve): ?>
                    <div class="alert alert-danger">Vásárlás folytatásához kérjük, jelentkezzen be! <a href="profil.php">Bejelentkezés</a></div>
                    <?php elseif (!$profil_teljes): ?>
                        <div class="alert alert-danger">Vásárlás folytatásához kérjük, töltse ki a profilját! <a href="profil.php">Profil szerkesztése</a></div>
                        <?php elseif (empty($_SESSION['kosar'])): ?>
                            <div class="alert alert-warning">A kosár üres. Kérjük, adjon hozzá termékeket a vásárláshoz!</div>
                            <?php else: ?>
                                <h3 class="mt-5">Rendelés összesítő</h3>
                                <p>Összesen: <strong><?= osszegzo($_SESSION['kosar']) ?> Ft</strong></p>
                                <p>Szállítás: <strong><?= $szallitas ?> Ft</strong></p>
                                <p>ÁFA: <strong><?= round(osszegzo($_SESSION['kosar']) * 0.27, 2) ?> Ft</strong></p>
                                <!--<h4>Végösszeg: <strong>//$vegosszeg ?> Ft</strong></h4>-->
                                    <form action="kosar.php" method="POST">

                                        <div class="card">
                                            <div class="card-header">Szállítási mód</div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="szallitasi_mod" id="standard" value="standard" checked>
                                                    <label class="form-check-label" for="standard">Standard szállítás (1690 Ft)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="szallitasi_mod" id="express" value="express">
                                                    <label class="form-check-label" for="express">Expressz szállítás (2990 Ft)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">Fizetési mód</div>
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="fizetesi_mod" id="kartya" value="kartya" checked>
                                                    <label class="form-check-label" for="kartya">Bankkártyás fizetés</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="fizetesi_mod" id="utanvet" value="utanvet">
                                                    <label class="form-check-label" for="utanvet">Utánvét</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="fizetesi_mod" id="paypal" value="paypal">
                                                    <label class="form-check-label" for="paypal">PayPal</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">Rendelés összesítő</div>
                                            <div class="card-body">
                                                <p class="summary">Összesen: <strong><?= number_format(osszegzo($_SESSION['kosar']), 0, '.', ' ') ?> Ft</strong></p>
                                                <p class="summary">Szállítási díj: <strong><?= number_format($szallitas, 0, '.', ' ') ?> Ft</strong></p>
                                                <p class="summary">Végösszeg: <strong><?= number_format($vegosszeg, 0, '.', ' ') ?> Ft</strong></p>
                                                <button type="submit" name="fizetes" id="payment-button" class="btn btn-dark w-100">Fizetés</button>
                                            </div>
                                        </div>

                                    </form>

            <?php endif; ?>
        </div>

        </div>
    </div>

</body>
</html>

