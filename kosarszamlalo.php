<?php

/*$adat = file_get_contents("kosarszamlalo.txt");

if (!isset($_SESSION['felhasznalo']))echo 0;
else echo nl2br(htmlspecialchars($adat));*/

if (!isset($_SESSION['felhasznalo'])) {
    echo 0; 
} else {
    if (!isset($_SESSION['kosar']) || empty($_SESSION['kosar'])) {
        echo 0;
    } else {
        echo count($_SESSION['kosar']);
    }
}

?>