<?php

$adat = file_get_contents("kosarszamlalo.txt");

if (!isset($_SESSION['felhasznalo']))echo 0;
else echo nl2br(htmlspecialchars($adat));

?>