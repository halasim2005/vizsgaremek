<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include './db.php'; // Az adatbázis kapcsolat betöltése

// Lekérdezés végrehajtása
$stmt = $pdo->query("SELECT 
    t.id AS termek_id,
    t.nev AS nev,
    t.leiras AS leiras,
    t.egysegar AS egysegar,
    t.elerheto_darab AS elerheto_mennyiseg,
    t.kep AS kep,
    t.tipus AS tipus,
    t.gyarto AS gyarto,
    k.nev AS kategoria_nev
FROM 
    termek t
JOIN 
    kategoria k ON t.kategoria_id = k.id");

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
    <title>Termékek</title>
</head>
<body>

    <?php
        include './navbar.php'; // A navigációs sáv betöltése
    ?>

<div class="container mt-5">
    
        <div class="grid-container align-middle" id="szures_">
            <div>Kategória
                <div>
                    <select id="kategoriaSzures" style="width: 150px">
                        <option value="osszes">Összes termék</option>
                    </select>
                </div>
            </div>
            <div>Gyártó
                <div>
                    <select id="gyartoSzures" style="width: 150px">
                        <option value="osszesGyarto">Összes gyártó</option>
                    </select>
                </div>
            </div>
            <div>Ár (Min - Max)
                <div id="rangeEgy"></div>
                <div id="rangeKetto"></div>
            </div>
            <div>Keresés
                <div>
                    <input type="text" id="keresesSzures" style="width: 150px" placeholder="Írja be a termék nevét!">
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            // Adatok megjelenítése kártyákban
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="card shadow">
                        <div id="termekekKartyaKepKozep"><img id="termekekKartyaKep" src="<?= $row['kep'] ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nev']) ?>"></div>
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($row['nev']) ?></h6>
                            <h6><strong><?= number_format($row['egysegar'], 0, '', ' ') ?> Ft</strong></h6>
                            <!--<button class="btn btn-primary">Kosárba</button>-->
                            <form method="POST" action="kosar_muveletek.php">
                                <input type="hidden" name="termek_id" value="<?= $row['termek_id'] ?>">
                                <input type="hidden" name="termek_kep" value="<?= $row['kep'] ?>">
                                <input type="hidden" name="ar" value="<?= $row['egysegar'] ?>">
                                <input type="hidden" name="mennyiseg" value="1"> <!-- Alapértelmezett mennyiség -->
                                <button type="button" id="termekekKartyaGomb" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_<?= $row['termek_id'] ?>">Részletek</button>
                                <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary">Kosárba</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade modalTermekek" id="modal_<?= $row['termek_id'] ?>" tabindex="-1" aria-labelledby="modalLabel_<?= $row['termek_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel_<?= $row['termek_id'] ?>"><strong><?= htmlspecialchars($row['nev']) ?></strong></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="modalKepekTermekek" src="<?= $row['kep'] ?>" class="img-fluid mb-3" alt="<?= htmlspecialchars($row['nev']) ?>">
                                <p><strong>Kategória:</strong> <?= htmlspecialchars($row['kategoria_nev']) ?></p>
                                <p><strong>Gyártó:</strong> <?= htmlspecialchars($row['gyarto']) ?></p>
                                <p><strong>Leírás:</strong> <?= nl2br(htmlspecialchars($row['leiras'])) ?></p>
                                <p><strong>Elérhető mennyiség:</strong> <?= htmlspecialchars($row['elerheto_mennyiseg']) ?> db</p>
                                <p><strong>Egységár:</strong> <?= number_format($row['egysegar'], 0, '', ' ') ?> Ft</p>
                            </div>
                            <div class="modal-footer">
                            <form method="POST" action="kosar_muveletek.php">
                                <input type="hidden" name="termek_id" value="<?= $row['termek_id'] ?>">
                                <input type="hidden" name="termek_nev" value="<?= htmlspecialchars($row['nev']) ?>">
                                <input type="hidden" name="ar" value="<?= $row['egysegar'] ?>">
                                <input type="hidden" name="mennyiseg" value="1"> <!-- Alapértelmezett mennyiség -->
                                <button type="submit" id="modalKartyaGomb" name="add_to_cart" class="btn btn-primary">Kosárba</button>
                            </form>
                                <button type="button" id="modalKartyaGomb" data-bs-dismiss="modal">Bezárás</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="./js/termekek.js"></script>

    <?php
        include './footer.php';
    ?>

</body>
</html>