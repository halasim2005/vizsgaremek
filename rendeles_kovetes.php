<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include './db.php';
include './sql_fuggvenyek.php';

//Felhasználó összes rendelés lekérése
$fh_nev = $_SESSION['felhasznalo']['fh_nev'];

$OSSZES_RENDELES_SQL = "SELECT megrendeles.id, megrendeles.vegosszeg, megrendeles.leadas_datum, 
                        SUM(tetelek.tetelek_mennyiseg) AS osszesTetel, megrendeles.statusz 
                        FROM megrendeles 
                        INNER JOIN tetelek ON tetelek.rendeles_id = megrendeles.id 
                        INNER JOIN termek ON termek.id = tetelek.termek_id WHERE megrendeles.fh_nev = '{$fh_nev}' GROUP BY megrendeles.id;";
$OSSZES_RENDELES = adatokLekerdezese($OSSZES_RENDELES_SQL);

//Rendelések száma
if(is_array($OSSZES_RENDELES)){
    $rendelesek_szama = count($OSSZES_RENDELES);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <title>Rendelés állapota</title>
</head>
<body>
    <?php 
    
        include './nav.php';
    
    ?>

    <div class="row m-5 text-center justify-content-center">
        <?php
        if(is_array($OSSZES_RENDELES)){
            $thead_th = "style='border-bottom:none;padding-bottom:20px;padding-top:20px;color:white'";
            $tbody_td = "style='padding-bottom:25px;padding-top:25px'";
            $thead_style = "style='border:none;background-color:rgb(61, 61, 61);border-radius:15px'";

            echo "<h5 class='mb-3 text-start'>Rendelések száma: {$rendelesek_szama} db</h5>";
            echo 
            "
                <table class='table'>
                    <thead {$thead_style}>
                        <tr>
                            <th {$thead_th}>Sorszám</th>
                            <th {$thead_th}>Végösszeg</th>
                            <th {$thead_th}>Dátum</th>
                            <th {$thead_th}>Tételek</th>
                            <th {$thead_th}>Állapot</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            foreach($OSSZES_RENDELES as $elem){
                    $statuszSzoveg = ($elem["statusz"] === "kész") ? "futárnak átadva" :
                        (($elem["statusz"] === "csomagolva") ? "csomagolva" :
                        (($elem["statusz"] === "feldolgozás alatt") ? "feldolgozás alatt" : $elem["statusz"]));

                    $statuszStyle = ($elem["statusz"] === "kész") ? "color:green;font-weight:bold" :
                        (($elem["statusz"] === "csomagolva") ? "color:orange;font-weight:bold" :
                        (($elem["statusz"] === "feldolgozás alatt") ? "color:gray;font-weight:bold" : ""));

                    echo "
                        <tr>
                            <td {$tbody_td}>{$elem["id"]}</td>
                            <td {$tbody_td}>{$elem["vegosszeg"]} Ft</td>
                            <td {$tbody_td}>{$elem["leadas_datum"]}</td>
                            <td {$tbody_td}>{$elem["osszesTetel"]} db</td>
                            <td style='$statuszStyle;padding-bottom:25px;padding-top:25px'>$statuszSzoveg</td>
                        </tr>
                    ";
            }
            echo 
            "
                    </tbody>
                </table>
            ";
        }else{
            echo "<h5 style='font-weight:bold'>Még nincsen aktuális rendelése!</h5>";
        }
        ?>
    </div>
</body>
</html>