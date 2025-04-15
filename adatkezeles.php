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
    <title>Adatkezelési tájékoztató</title>
    <link rel="icon" type="image/x-icon" href="./képek/HaLálip.ico">
</head>
<body>
    <?php
        include './nav.php';
    ?>

    <div class="container mb-3">
        <div class="row m-5">
            <h2 class="">Adatkezelési Tájékoztató</h2>
            
            <section id="adatkezelesi-tajekoztato">
                <p><strong>Adatkezelő:</strong> HaLáli Korlátolt Felelősségű Társaság (HaLáli Kft.)</p>
                <p><strong>Székhely:</strong> 8200 Veszprém, Szabadság tér 6.</p>
                <p><strong>E-mail:</strong> <a style="color:black; text-decoration:none; font-weight:bold" href="mailto:halalikft@gmail.com">halalikft@gmail.com</a></p>
                <p><strong>Telefon:</strong> +36 30 123 4567</p>

                <h3>1. Az adatkezelés célja</h3>
                <p>
                    A HaLáli Kft. kizárólag olyan személyes adatokat kezel, amelyek az ügyfelek részéről történő kapcsolatfelvétel,
                    árajánlatkérés, megrendelés, számlázás, valamint a szolgáltatások teljesítése érdekében szükségesek.
                </p>

                <h3>2. A kezelt adatok köre</h3>
                <ul>
                    <li>Teljes név</li>
                    <li>E-mail cím</li>
                    <li>Telefonszám</li>
                    <li>Szállítási és számlázási cím</li>
                    <li>Megrendelt termékek, szolgáltatások adatai</li>
                </ul>

                <h3>3. Az adatkezelés jogalapja</h3>
                <p>
                    Az adatkezelés az érintett hozzájárulása alapján, valamint szerződés teljesítése érdekében történik
                    az Európai Parlament és a Tanács (EU) 2016/679 rendelete (GDPR) alapján.
                </p>

                <h3>4. Az adatok tárolásának időtartama</h3>
                <ul>
                    <li>Kapcsolatfelvétel esetén: a kommunikáció lezárását követő 6 hónap</li>
                    <li>Megrendelés esetén: a számviteli törvényben előírt 8 év</li>
                    <li>Marketing célú hozzájárulás esetén: visszavonásig</li>
                </ul>

                <h3>5. Az érintettek jogai</h3>
                <p>Az érintettek jogosultak:</p>
                <ul>
                    <li>tájékoztatást kérni a rájuk vonatkozó személyes adatok kezeléséről,</li>
                    <li>hozzáférést kérni az általunk kezelt adataikhoz,</li>
                    <li>helyesbítést vagy törlést kérni,</li>
                    <li>az adatkezelés korlátozását kérni,</li>
                    <li>tiltakozni az adatkezelés ellen,</li>
                    <li>az adathordozhatósághoz való jogot gyakorolni.</li>
                </ul>

                <h3>6. Adattovábbítás</h3>
                <p>
                    A HaLáli Kft. az ügyfelek személyes adatait harmadik fél részére kizárólag jogszabályi kötelezettség teljesítése
                    vagy szerződéses partnerek (pl. futárszolgálatok, könyvelő) számára – kizárólag a szükséges mértékben – továbbítja.
                </p>

                <h3>7. Panasztételi lehetőség</h3>
                <p>
                    Amennyiben Ön úgy érzi, hogy személyes adatai kezelése során jogsérelem érte, panaszával fordulhat a Nemzeti
                    Adatvédelmi és Információszabadság Hatósághoz (NAIH):
                </p>
                <ul>
                    <li><strong>Honlap:</strong> <a style="color:black; text-decoration:none; font-weight:bold" href="https://naih.hu" target="_blank">https://naih.hu</a></li>
                    <li><strong>Cím:</strong> 1055 Budapest, Falk Miksa utca 9-11.</li>
                    <li><strong>Postacím:</strong> 1363 Budapest, Pf. 9.</li>
                    <li><strong>E-mail:</strong> ugyfelszolgalat@naih.hu</li>
                    <li><strong>Telefon:</strong> +36 1 391 1400</li>
                </ul>

                <p>
                    A HaLáli Kft. elkötelezett az Ön adatainak biztonságos, átlátható és jogszerű kezelése iránt, és minden szükséges
                    technikai és szervezési intézkedést megtesz azok védelme érdekében.
                </p>
            </section>
        </div>
    </div>
    
    <?php
        include './footer.php';
    ?>
</body>
</html>