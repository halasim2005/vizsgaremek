<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>

    <?php
        include './navbar.php';
    ?>

    

    <div class="container form-container">
        <h2 class="text-center">Regisztráció</h2>
        <form action="" method="post" autocomplete="off">

            <div class="mb-3">
                <label for="vezNev" class="form-label">Vezetéknév</label>
                <input type="text" class="form-control" name="vezNev" id="vezNev" placeholder="Gipsz" required>
            </div>

            <div class="mb-3">
                <label for="kerNev" class="form-label">Keresztnév</label>
                <input type="text" class="form-control" name="kerNev" id="kerNev" placeholder="Jakab" required>
            </div>

           <!-- 
            <div class="mb-3">
                <label for="telefonszam" class="form-label">Telefonszám</label>
                <input type="tel" class="form-control" name="telefonszam" id="telefonszam" placeholder="+36 20 420 6969" required>
            </div>

           
            <div class="mb-3">
                <label for="irszam" class="form-label">Irányítószám</label>
                <input type="number" class="form-control" name="irszam" id="irszam" min="1000" max="9999" placeholder="8181" required>
            </div>

            <div class="mb-3">
                <label for="varos" class="form-label">Település</label>
                <input type="text" class="form-control" name="varos" id="varos" placeholder="Berhida" required>
            </div>

            <div class="mb-3">
                <label for="utca" class="form-label">Utca</label>
                <input type="text" class="form-control" name="utca" id="utca" placeholder="Liszt Ferenc utca" required>
            </div>

            <div class="mb-3">
                <label for="hazszam" class="form-label">Házszám</label>
                <input type="number" class="form-control" name="hazszam" id="hazszam" min="1" placeholder="6" required>
            </div>
        -->

            <div class="mb-3">
                <label for="felhasznalonev" class="form-label">Felhasználónév</label>
                <input type="text" class="form-control" name="felhasznalonev" id="felhasznalonev" placeholder="gipszjakab22" required autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail cím</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="minta@gmail.com" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="*********" required>
            </div>

            <div class="mb-3">
                <label for="passwordAgain" class="form-label">Jelszó megerősítése</label>
                <input type="password" class="form-control" name="passwordAgain" id="passwordAgain" placeholder="*********" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Regisztráció</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
