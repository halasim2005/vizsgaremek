<?php

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