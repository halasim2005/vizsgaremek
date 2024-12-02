<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulátor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>

    <?php
        include './navbar.php';
    ?>

    

    <div class="container form-container">
        <h2 class="text-center">Feszültségesés kalkulátor</h2>
        <form action="">
            <div class="mb-3">
                <label for="kerNev" class="form-label">Kérem írja be a vezeték (egyirányú) hosszát méter-ben megadva!</label>
                <input type="number" class="form-control" name="vezHossz" id="vezHossz" placeholder="20 (méter)" required>
            </div>
            <div class="mb-3">
                <label for="vezKereszt" class="form-label">Kérem válassza ki a vezeték keresztmetszetét (egy ér - mm<sup>2</sup>)!</label><br>
                <select name="vezKereszt" id="vezKereszt" class="form-control">
                    <option class="form-control" value="1" selected>1mm&sup2;</option>
                    <option class="form-control" value="1.5">1.5 mm&sup2;</option>
                    <option class="form-control" value="2.5">2.5 mm&sup2;</option>
                    <option class="form-control" value="4">4 mm&sup2;</option>
                    <option class="form-control" value="6">6 mm&sup2;</option>
                    <option class="form-control" value="10">10 mm&sup2;</option>
                    <option class="form-control" value="16">16 mm&sup2;</option>
                    <option class="form-control" value="25">25 mm&sup2;</option>
                    <option class="form-control" value="35">35 mm&sup2;</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="teljNev" class="form-label">Kérem írja be a maximális áramerősséget amper-ben megadva!</label>
                <input type="number" class="form-control" name="aram" id="aram" placeholder="200 (A)" required>
            </div>
            <div class="mb-3">
                <label><input type="radio" id="230" name="KalkulatorKategoriak"> 1 fázis (230V)</label><br><br>
                <label><input type="radio" id="400" name="KalkulatorKategoriak"> 3 fázis (400V)</label><br><br>
            </div>
            <div class="mb-3" id="hiba">
                
            </div>
            <div>
                <input type="button" class="btn kalk-button" id="szamitas" value="Számolás">
                <div id="eredmeny">

                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/kalkulator.js"></script>

    <?php
        include './footer.php';
    ?>

</body>
</html>