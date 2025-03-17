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

    <?php include './nav.php'; ?>

    <div class="container form-container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <label><input type="radio" name="kalkulatorRadios" value="feszeses" id="feszesesRadio" checked> Feszültségesés </label>
            </div>
            <div class="col-lg-6 col-sm-12">
                <label><input type="radio" name="kalkulatorRadios" value="ellenallas" id="ellenallasRadio"> Ellenállás </label>
            </div>
        </div>
    </div>

    <div class="container form-container" id="feszesesDiv">
        <h2 class="text-center">Feszültségesés kalkulátor</h2>
        <form action="">
            <div class="mb-3">
                <label for="kerNev" class="form-label">Kérem írja be a vezeték (egyirányú) hosszát méter-ben megadva!</label>
                <input type="number" class="form-control w-100" name="vezHossz" id="vezHossz" placeholder="20 (méter)" required>
            </div>
            <div class="mb-3">
                <label for="vezKereszt" class="form-label">Kérem válassza ki a vezeték keresztmetszetét (egy ér - mm<sup>2</sup>)!</label><br>
                <select name="vezKereszt" id="vezKereszt" class="form-control w-100">
                    <option class="form-control" value="1" selected>1 mm&sup2;</option>
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
                <input type="number" class="form-control w-100" name="aram" id="aram" placeholder="200 (A)" required>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label><input type="radio" id="230" name="KalkulatorKategoriak"> 1 fázis (230V)</label><br><br>
                </div>
                <div class="mb-3 col-md-6">
                    <label><input type="radio" id="400" name="KalkulatorKategoriak" class="text-end"> 3 fázis (400V)</label><br><br>
                </div>
            </div>
            
            <div>
                <div class="mb-3" id="hiba">
                    
                </div>
                <input type="button" class="btn kalk-button w-100 szamitasBtn" id="szamitas" value="Számolás">
                <div class="text-center" id="eredmeny">

                </div>
            </div>
        </form>
    </div>

    <div class="container form-container" id="ellenDiv">
        <h2 class="text-center">Ellenállás kalkulátor</h2>
        <form action="">
            <div class="mb-3">
                <label for="kerNev" class="form-label">Kérem írja be a feszültséget (V) Voltban megadva!</label>
                <input type="number" class="form-control w-100" name="feszultseg" id="feszultseg" placeholder="24 V" required>
            </div>
            <div class="mb-3">
                <label for="teljNev" class="form-label">Kérem írja be az áramerősséget (A) Amperban megadva!</label>
                <input type="number" class="form-control w-100" name="aram_ellenallas" id="aram_ellenallas" placeholder="200 A" required>
            </div>
            <div>
                <div class="mb-3" id="hiba_ellenallas">
                    
                </div>
                <input type="button" class="btn kalk-button w-100 szamitasBtn" id="szamitas_ellenallas" value="Számolás">
                <div class="text-center" id="eredmeny_ellenallas">

                </div>
            </div>
        </form>
    </div>

    <div class="container form-container" id="arDiv">
        <h2 class="text-center">Ár kalkulátor</h2>
        <form action="">
            <div class="mb-3">
                <label for="kerNev" class="form-label">Kérem írja be a vezeték (egyirányú) hosszát méter-ben megadva!</label>
                <input type="number" class="form-control w-100" name="vezHossz" id="vezHossz" placeholder="20 (méter)" required>
            </div>
            <div class="mb-3">
                <label for="vezKereszt" class="form-label">Kérem válassza ki a vezeték keresztmetszetét (egy ér - mm<sup>2</sup>)!</label><br>
                <select name="vezKereszt" id="vezKereszt" class="form-control w-100">
                    <option class="form-control" value="1" selected>1 mm&sup2;</option>
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
                <input type="number" class="form-control w-100" name="aram" id="aram" placeholder="200 (A)" required>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label><input type="radio" id="230" name="KalkulatorKategoriak"> 1 fázis (230V)</label><br><br>
                </div>
                <div class="mb-3 col-md-6">
                    <label><input type="radio" id="400" name="KalkulatorKategoriak" class="text-end"> 3 fázis (400V)</label><br><br>
                </div>
            </div>
            
            <div>
                <div class="mb-3" id="hiba">
                    
                </div>
                <input type="button" class="btn kalk-button w-100 szamitasBtn" id="szamitas" value="Számolás">
                <div class="text-center" id="eredmeny">

                </div>
            </div>
        </form>
    </div>

    <script src="./js/kalkulator.js"></script>

    <?php include './footer.php'; ?>
</body>
</html>