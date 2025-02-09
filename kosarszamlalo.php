<?php

$adat = file_get_contents("kosarszamlalo.txt");

if(empty($adat) || $adat == 0){
    echo 0;
}else if($adat > 0){
    echo nl2br(htmlspecialchars($adat));
}

?>