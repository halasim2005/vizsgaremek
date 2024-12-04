<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include './db.php'; // Az adatbázis kapcsolat betöltése

// Lekérdezés végrehajtása

$osszesTermek = "SELECT t.id AS termek_id, t.nev AS nev, t.leiras AS leiras, t.egysegar AS egysegar, t.elerheto_darab AS elerheto_mennyiseg, t.kep AS kep, t.tipus AS tipus, t.gyarto AS gyarto, k.nev AS kategoria_nev FROM termek t JOIN kategoria k ON t.kategoria_id = k.id";

/////////////////////////////////


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
<body onclick="keresesEltunik()">

    <?php
        include './navbar.php'; // A navigációs sáv betöltése
    ?>

    <div id="szuresDiv" class="shadow">
        <form method="post">
            <p>Szűrés alapú keresés</p>
            <hr>
            <label>Kategória</label>
            <select name="kategoria">
                <option value="összes">Összes termék</option>
                <?php
                include './sql_fuggvenyek.php';
                $kategoriak_sql = "SELECT kategoria.id AS id, kategoria.nev AS nev FROM kategoria;";
                $kategoriak = adatokLekerdezese($kategoriak_sql);
                if(is_array($kategoriak)){
                    foreach($kategoriak as $kategoria){
                        echo '<option value="'. $kategoria["id"] . '">' . $kategoria["nev"] . '</option>';
                    }
                }
                ?>
            </select>
            <br><br><input type="submit" id="modalKartyaGomb" value="Keresés" name="kereses">
        </form>
    </div>

    <div id="kozepre">
        <h2 id="fekete">Termékek</h2>
    </div>

    <?php
    $kategoria = $_POST['kategoria'];

    $kategoriaAlapu_termek_sql = "SELECT kategoria.nev AS kategoria_nev, termek.id AS termek_id, termek.nev AS nev, termek.egysegar AS egysegar, termek.leiras AS leiras, termek.gyarto AS gyarto, termek.tipus AS tipus, termek.elerheto_darab AS elerheto_mennyiseg, termek.kep AS kep FROM `termek` INNER JOIN kategoria ON kategoria.id = termek.kategoria_id WHERE kategoria.id = '{$kategoria}';";
    
    if(isset($_POST['kereses'])){
        if($kategoria == "összes"){
            $stmt = $pdo->query($osszesTermek);
        }
        else{
            $stmt = $pdo->query($kategoriaAlapu_termek_sql);
        }
    }else{
        $stmt = $pdo->query($kategoriaAlapu_termek_sql);
    }
    ?>

    <div class="container mt-5">
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
                            <button type="button" id="termekekKartyaGomb" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_<?= $row['termek_id'] ?>">Részletek</button>
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
                                <button type="button" id="modalKartyaGomb">Kosárba</button>
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

    <?php
        include './footer.php';
    ?>

</body>
</html>
