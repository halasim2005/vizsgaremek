<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
    <title>Kapcsolat</title>
    <link rel="icon" type="image/x-icon" href="./képek/HaLálip.ico">
</head>
<body>

    <?php
        include './nav.php';
    ?>
<div class="container mb-3">
<div class="row m-5">
        <h2 class="">Kapcsolat</h2>
        
        <!-- Kapcsolati Információk -->
         <!--<div class="row mt-4">-->
             <div class="col-lg-4">
                 <img id="kapcsolatLogo" width="90%" src="./képek/HaLálip.png" alt="HaLáli Villszer Kft. logo">
             </div>
            <div class="col-lg-3">
                <h4>Elérhetőségeink</h4>
                <ul class="list-unstyled">
                    <li><strong>Cégnév:</strong> HaLáli Kft.</li>
                    <li><strong>Cégalapítók:</strong> Halasi Martin, Lálity Dominik</li>
                    <li><strong>Cím:</strong> 8200, Veszprém, Szabadság tér 6.</li>
                    <li><strong>Telefon:</strong> +36 30 123 4567</li>
                    <li><strong>E-mail:</strong> halalikft@gmail.com</li>
                    <li><strong>Nyitva tartás:</strong> H-P: 9:00-17:00</li>
                </ul>
            </div>
         <!--</div>-->

         


        <!-- Kapcsolati Űrlap -->
         <!--<div class="row mt-5">-->
            <div class="col-lg-5">
                <h4>Küldjön nekünk üzenetet</h4>
                <form action="kapcsolat_kuldes.php" method="POST" class="mt-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Név</label>
                        <input type="text" class="form-control w-100" id="name" name="name" placeholder="Írja be a nevét" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail cím</label>
                        <input type="email" class="form-control w-100" id="email" name="email" placeholder="pl: valaki@email.hu" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Üzenet</label>
                        <textarea class="form-control w-100" id="message" name="message" rows="5" placeholder="Írja be az üzenetét..." required></textarea>
                    </div>
                    <button type="submit" class="btn kalk-button w-100 kapcsolatBtn">Küldés</button>
                </form>
                <?php if (isset($_SESSION['flash_success'])): ?>
                    <div class="alert alert-success my-2"><?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?></div>
                <?php elseif (isset($_SESSION['flash_error'])): ?>
                    <div class="alert alert-danger my-2"><?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mx-auto w-90">
                <h4>Térkép</h4>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10795.847019326195!2d17.914509599999997!3d47.0926767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4769dc589d4068ad%3A0x77bc6741cb716d94!2zVmVzenByw6ltLCBTemFiYWRzw6FneiB0w6lyIDYtMTAsIDgyMDA!5e0!3m2!1shu!2shu!4v1614000000000!5m2!1shu!2shu" 
                    width="100%" 
                    height="500" 
                    style="border:0;" 
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
         </div>


        <!-- Közösségi Média -->
        <div class="row mt-5 text-center">
            <h4>Kövessen minket</h4>
            <div class="col-md-12">
                <a href="https://facebook.com" target="_blank" class="me-3 kovessIkon"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="https://instagram.com" target="_blank" class="me-3 kovessIkon"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="https://twitter.com" target="_blank" class="me-3 kovessIkon"><i class="fab fa-twitter fa-2x"></i></a>
                <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin fa-2x kovessIkon"></i></a>
            </div>
        </div>
    </div>
</div>


    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <?php include './footer.php';?>

</body>
</html>