<?php
    if(empty($_SESSION["cart_szamlalo"])){
        echo 0;
    }else if($_SESSION["cart_szamlalo"] > 0){
        echo nl2br(htmlspecialchars($_SESSION["cart_szamlalo"]));
    }
?>