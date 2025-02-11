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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <title>HaLáli Webshop</title>
</head>

<body>
    <?php include './nav.php';?>
    <div>
        <div class="row bemutatkozasDiv mr-2" id="rolunk">
            <div class="col-sm-12 col-lg-6 text-center">
                <img id="logoKepBemutatkozasDiv" width="100%" class="pb-2" src="./képek/HaLálip.png" alt="HaLáli Villszer Kft. logo">
            </div>
            <div class="col-sm-12 col-lg-6">
                <h1 class="fooldalDivSzovegCim">Rólunk</h1>
                <h5 class="fooldalDivSzoveg text-wrap text-justify">A HaLáli Kft. egy dinamikusan fejlődő webáruház, amely villanyszerelési termékek széles választékát kínálja ügyfeleinek. A cég alapítói, Halasi Martin és Lálity Dominik, több éves szakmai tapasztalattal rendelkeznek a villanyszerelés területén, és céljuk, hogy minőségi, megbízható termékeket biztosítsanak a piacon. A HaLáli Kft. webáruháza egyszerű és gyors vásárlási élményt kínál, ahol a legújabb technológiákat és eszközöket találhatják meg a szakemberek és a háztartások is. A cég elkötelezett a kiváló ügyfélszolgálat mellett, hogy minden vásárló teljes elégedettséggel távozhasson. Rendeljen kényelmesen otthonról, és bízzon a HaLáli Kft. megbízhatóságában!</h5>
            </div>
        </div>

        <div class="row termekekDiv" id="termekek">
            <div class="col-sm-12 col-lg-6 text-center">
                <img width="100%" class="pb-2" src="./képek/izzok.jpg" alt="Izzók">
            </div>
            <div class="col-sm-12 col-lg-6">
                <h1 class="fooldalDivSzovegCim">Kínálatunk</h1>
                <h5 class="fooldalDivSzoveg text-wrap text-justify">Fedezze fel webáruházunk gazdag választékát, ahol minden villanyszerelési eszközt és anyagot könnyedén megtalál! Nézze meg a Termékek részt, és kattintson a számos kategória egyikére, hogy gyorsan rátaláljon a szükséges eszközökre és alapanyagokra. Akár szakember, akár háztartást vezet, nálunk mindent megtalál, amire szüksége lehet a villanyszereléshez. Vásároljon egyszerűen, kényelmesen, közvetlenül online!</h5>
                <br><a href="./termekek.php" class="fooldalDivButton">TERMÉKEK</a>
            </div>
        </div>

        <div class="row kalkulatorDiv" id="kalkulator">
            <div class="col-sm-12 col-lg-6 text-center">
                <img width="100%" class="pb-2" src="./képek/kalkulator.jpeg" alt="Izzók">
            </div>
            <div class="col-sm-12 col-lg-6">
                <h1 class="fooldalDivSzovegCim">Kalkulátor</h1>
                <h5 class="fooldalDivSzoveg text-wrap text-justify">Ez az elektromos kalkulátor a feszültségveszteség gyors és pontos kiszámítására szolgál, figyelembe véve a vezeték hosszát, keresztmetszetét és az áramerősséget. A felhasználóbarát online eszköz segítségével könnyedén meghatározhatja a megfelelő vezetékeket, hogy minimalizálja a feszültségcsökkenést és biztosítsa a rendszer hatékonyságát. Ideális választás villanyszerelők, mérnökök és bárki számára, aki pontos tervezést végez az elektromos rendszerekben.</h5>
                <br><a href="./kalkulator.php" class="kalkDivButton">KALKULÁTOR</a>
            </div>
        </div>

        <div class="row ugyfelszolgalatDiv" id="ugyfel">
            <div class="col-sm-12 col-lg-6 text-center">
                <img width="100%" class="pb-2" src="./képek/ugyfelszolg.jpeg" alt="Izzók">
            </div>
            <div class="col-sm-12 col-lg-6">
                <h1 class="fooldalDivSzovegCim">Ügyfélszolgálat</h1>
                <h5 class="fooldalDivSzoveg text-wrap text-justify">Üdvözlünk a HaLáli Kft. ügyfélszolgálatán! Ha kérdésed van rendeléseddel, termékeinkkel vagy bármilyen más témával kapcsolatban, itt tudsz kapcsolatba lépni velünk. A cég alapítói, Halasi Martin és Lálity Dominik készséggel áll rendelkezésedre, hogy gyors és segítőkész válaszokkal támogassunk. Ne habozz írni, bármilyen problémával vagy kérdéssel kereshetsz minket! Köszönjük, hogy minket választottál!</h5>
                <br><a href="./kapcsolat.php" class="ugyfelszDivButton">KAPCSOLAT</a>
            </div>
        </div>

    </div>

    <?php include './footer.php';?>

    
</body>
</html>