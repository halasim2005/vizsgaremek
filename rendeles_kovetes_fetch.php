<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include './db.php';
include './sql_fuggvenyek.php';

//Felhasználó összes rendelés lekérése
$fh_nev = $_SESSION['felhasznalo']['fh_nev'];
$teljesURL = explode('/', $_SERVER['REQUEST_URI']);
$url = explode('?', end($teljesURL));
$bodyAdatok = json_decode(file_get_contents('php://input'),true);

switch (mb_strtolower($url[0])) {
    case 'rendelesek':
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $OSSZES_RENDELES_SQL = "SELECT megrendeles.id, megrendeles.vegosszeg, megrendeles.leadas_datum, megrendeles.statusz FROM megrendeles WHERE megrendeles.fh_nev = '{$fh_nev}' ORDER BY megrendeles.id DESC;";
            $OSSZES_RENDELES = adatokLekerdezese($OSSZES_RENDELES_SQL);
            if(is_array($OSSZES_RENDELES)){
                echo json_encode($OSSZES_RENDELES, JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(['valasz' => 'A rendelések lekérése sikertelen! Hiba!'], JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode(['valasz' => 'Hibás metódus!'], JSON_UNESCAPED_UNICODE);
            header('BAD REQUEST', true, 400);
        }
        break;
    case 'rendeles_reszletek':
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $RENDELES_ADATAI_SQL = "SELECT termek.nev, termek.kep, termek.egysegar, tetelek.tetelek_mennyiseg, megrendeles.szallitasi_mod, megrendeles.fizetesi_mod, megrendeles.vegosszeg, megrendeles.leadas_datum, megrendeles.statusz 
                                    FROM termek INNER JOIN tetelek ON tetelek.termek_id = termek.id 
                                    INNER JOIN megrendeles ON megrendeles.id = tetelek.rendeles_id 
                                    WHERE megrendeles.fh_nev = ? AND megrendeles.id = ? AND megrendeles.statusz = ?;";
            $RENDELES_ADATAI = $pdo->prepare($RENDELES_ADATAI_SQL);
            $DB_jo = $RENDELES_ADATAI->execute([$fh_nev, $bodyAdatok["id"], $bodyAdatok["statusz"]]);
            if($DB_jo){
                $rendeles_adatok = $RENDELES_ADATAI->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($rendeles_adatok, JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(['valasz' => 'A rendelések adatainak lekérése sikertelen! Hiba!'], JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode(['valasz' => 'Hibás metódus!'], JSON_UNESCAPED_UNICODE);
            header('BAD REQUEST', true, 400);
        }
        break;
    default:
        break;
}

?>



