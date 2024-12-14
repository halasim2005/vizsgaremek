<?php

include './sql_fuggvenyek.php';

$teljesURL = explode('/', $_SERVER['REQUEST_URI']);
$url = explode('?', end($teljesURL));
$bodyAdatok = json_decode(file_get_contents('php://input'),true);

switch (mb_strtolower($url[0])) {
    case 'kategoriakleker':
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $kategoriak_sql = "SELECT kategoria.id AS id, kategoria.nev AS nev FROM kategoria;";
            $kategoriak = adatokLekerdezese($kategoriak_sql);
            if(is_array($kategoriak)){
                echo json_encode($kategoriak, JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(['valasz' => 'A kategóriák lekérése sikertelen! Hiba!'], JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode(['valasz' => 'Hibás metódus!'], JSON_UNESCAPED_UNICODE);
            header('BAD REQUEST', true, 400);
        }
        break;
    case 'gyartokleker':
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $gyartok_sql = "SELECT termek.gyarto AS gyartonev FROM termek;";
            $gyartok = adatokLekerdezese($gyartok_sql);
            if(is_array($gyartok)){
                echo json_encode($gyartok, JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(['valasz' => 'A gyartók lekérése sikertelen! Hiba!'], JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode(['valasz' => 'Hibás metódus!'], JSON_UNESCAPED_UNICODE);
            header('BAD REQUEST', true, 400);
        }
        break;
    case 'arakleker':
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $arak_sql = "SELECT MAX(termek.egysegar) AS arMax, MIN(termek.egysegar) AS arMin FROM termek;";
            $arak = adatokLekerdezese($arak_sql);
            if(is_array($arak)){
                echo json_encode($arak, JSON_UNESCAPED_UNICODE);
            }else{
                echo json_encode(['valasz' => 'Az árak lekérése sikertelen! Hiba!'], JSON_UNESCAPED_UNICODE);
            }
        }else{
            echo json_encode(['valasz' => 'Hibás metódus!'], JSON_UNESCAPED_UNICODE);
            header('BAD REQUEST', true, 400);
        }
        break;
    case 'szures':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $feltetelek = [];
            if (!empty($bodyAdatok['kategoria']) && $bodyAdatok['kategoria'] != 'osszes') {
                $feltetelek[] = "kategoria.id = " . intval($bodyAdatok['kategoria']);
            }
            if (!empty($bodyAdatok['gyarto']) && $bodyAdatok['gyarto'] != 'osszesGyarto') {
                 $feltetelek[] = "termek.gyarto = '" . htmlspecialchars($bodyAdatok['gyarto']) . "'";
            }
            if (!empty($bodyAdatok['minRangeAr']) && !empty($bodyAdatok['maxRangeAr'])) {
                $feltetelek[] = "termek.egysegar BETWEEN " . intval($bodyAdatok['minRangeAr']) . " AND " . intval($bodyAdatok['maxRangeAr']);
            }
            if (!empty($bodyAdatok['kereses'])) {
                $feltetelek[] = "termek.nev LIKE '%" . htmlspecialchars($bodyAdatok['kereses']) . "%'";
            }
        
            $szures_sql = "
                SELECT termek.id, termek.nev, termek.egysegar, termek.kep, termek.leiras, termek.gyarto, termek.elerheto_darab, kategoria.nev AS kategoria_nev
                FROM termek
                INNER JOIN kategoria ON termek.kategoria_id = kategoria.id
                " . (!empty($feltetelek) ? "WHERE " . implode(' AND ', $feltetelek) : "") . "
            ";
        
            $termekek = adatokLekerdezese($szures_sql);
        
            // Ha nincs találat, akkor üres tömböt küldjünk
            echo json_encode($termekek ?: []);
        } else {
            echo json_encode(['valasz' => 'Hibás metódus!']);
            header('HTTP/1.1 400 Bad Request');
        }
        break;        
    default:
        break;
}

?>



