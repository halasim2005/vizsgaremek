<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include './db.php';
include './sql_fuggvenyek.php';

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
    <link rel="icon" type="image/x-icon" href="./képek/HaLálip.ico">
</head>
<style>
    .cell {
        flex: 1;
        padding: 20px;
        background: white;
        border: 2px solid #ccc;
        border-radius: 5px;
        text-align: left;
        font-size: 1.2rem;
    }
    
    #rendelesTable{
        display: flex;
    }

    #rendelesReszletekBtn{
        background-color: white;
        border: 1px solid black;
        color:black;
        text-decoration: none;
        border-radius: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: medium;
        margin-left: 10px;
    }

    #rendelesReszletekBtn:hover{
        background-color: rgb(61, 61, 61);
        border: 1px solid rgb(61, 61, 61);
        color:white;
        text-decoration: none;
        border-radius: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: medium;
        margin-left: 10px;
    }
    </style>
<body>
    <?php 
    
        include './nav.php';
    
    ?>

    <div class="row m-5">
        <h5 id="rendelesCount" class="text-start"></h5>
        <div id="rendelesTable" class="my-2">

        </div>
        <div id="rendeles">

        </div>
        <div id="hibauzenet">

        </div>
    </div>

    <?php 
    
        include './footer.php';
    
    ?>

    <script src="./js/rendeles_kovetes.js"></script>
</body>
</html>