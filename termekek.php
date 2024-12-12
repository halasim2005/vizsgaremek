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
        <div class="row">
            <?php
            // Adatok megjelenítése kártyákban
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= $row['kep'] ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nev']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['nev']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($row['leiras']) ?></p>
                            <ul class="list-unstyled">
                                <li><strong>Ár: </strong><?= number_format($row['egysegar'], 0, '', ' ') ?> Ft</li>
                                <li><strong>Elérhető mennyiség: </strong><?= $row['elerheto_mennyiseg'] ?> db</li>
                                <li><strong>Típus: </strong><?= htmlspecialchars($row['tipus']) ?></li>
                                <li><strong>Gyártó: </strong><?= htmlspecialchars($row['gyarto']) ?></li>
                                <li><strong>Kategória: </strong><?= htmlspecialchars($row['kategoria_nev']) ?></li>
                            </ul>
                            <button class="btn btn-primary">Kosárba</button>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <?php
        include './footer.php';
    ?>

</body>
</html>