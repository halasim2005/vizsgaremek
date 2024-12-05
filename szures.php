<?php
    if(isset($_POST['keresesGomb'])){
        $kategoria = $_POST['kategoria'];
        $gyarto = $_POST['gyarto'];
        $ar = $_POST['ar'];
        $kereses = $_POST['kereses'];

        $kategoriaAlapu_termek_sql = "SELECT kategoria.nev AS kategoria_nev, termek.id AS termek_id, termek.nev AS nev, termek.egysegar AS egysegar, termek.leiras AS leiras, termek.gyarto AS gyarto, termek.tipus AS tipus, termek.elerheto_darab AS elerheto_mennyiseg, termek.kep AS kep FROM `termek` INNER JOIN kategoria ON kategoria.id = termek.kategoria_id WHERE kategoria.id = '{$kategoria}';";
        if($kategoria === "összes"){
            $stmt = $pdo->query($osszesTermek);
        }else{
            $stmt = $pdo->query($kategoriaAlapu_termek_sql);
        }
    }else{
        $stmt = $pdo->query($osszesTermek);
    }
?>