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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(empty($bodyAdatok['id_kategoria']) && empty($bodyAdatok['gyarto']) && empty($bodyAdatok['ar_also']) && empty($bodyAdatok['ar_felso']) && empty($bodyAdatok['keres'])){
                echo json_encode(['valasz' => 'Hiányos adatok!']);
                header('BAD REQUEST', true, 400);
            }else if(empty($bodyAdatok['keres'])){
                $szuresElso_sql = "SELECT kategoria.id AS k_id, 
                                        kategoria.nev AS k_nev, 
                                        kategoria.leiras AS k_leiras, 
                                        termek.id AS t_id, 
                                        termek.nev AS t_nev, 
                                        termek.egysegar AS t_egysegar, 
                                        termek.leiras AS t_leiras, 
                                        termek.gyarto AS t_gyarto, 
                                        termek.tipus AS t_tipus, 
                                        termek.elerheto_darab AS t_db, 
                                        termek.kep AS t_kep FROM `termek` INNER JOIN kategoria 
                                        ON kategoria.id = termek.kategoria_id 
                                        WHERE kategoria.id = {$bodyAdatok['id_kategoria']} 
                                        AND termek.gyarto = '{$bodyAdatok['gyarto']}' 
                                        AND termek.egysegar BETWEEN {$bodyAdatok['ar_also']} AND {$bodyAdatok['ar_felso']};";
                $szuresElso = adatokLekerdezese($szuresElso_sql);
                if(is_array($szuresElso)){
                    echo json_encode($szuresElso, JSON_UNESCAPED_UNICODE);
                }else{
                    echo json_encode(['valasz' => 'Hiba!'], JSON_UNESCAPED_UNICODE);
                }
            }else if(!empty($bodyAdatok['keres'])){
                $szuresMasodik_sql = "SELECT kategoria.id AS k_id, 
                                        kategoria.nev AS k_nev, 
                                        kategoria.leiras AS k_leiras, 
                                        termek.id AS t_id, 
                                        termek.nev AS t_nev, 
                                        termek.egysegar AS t_egysegar, 
                                        termek.leiras AS t_leiras, 
                                        termek.gyarto AS t_gyarto, 
                                        termek.tipus AS t_tipus, 
                                        termek.elerheto_darab AS t_db, 
                                        termek.kep AS t_kep FROM `termek` INNER JOIN kategoria 
                                        ON kategoria.id = termek.kategoria_id 
                                        WHERE kategoria.id = {$bodyAdatok['id_kategoria']} 
                                        AND termek.gyarto = '{$bodyAdatok['gyarto']}' 
                                        AND termek.egysegar BETWEEN {$bodyAdatok['ar_also']} AND {$bodyAdatok['ar_felso']} AND termek.nev LIKE '%{$bodyAdatok['keres']}%';";
                $szuresMasodik = adatokLekerdezese($szuresMasodik_sql);
                if(is_array($szuresMasodik)){
                    echo json_encode($szuresMasodik, JSON_UNESCAPED_UNICODE);
                }else{
                    echo json_encode(['valasz' => 'Hiba!'], JSON_UNESCAPED_UNICODE);
                }
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