<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha = $_POST['g-recaptcha-response'];
    $secret_key = '6LfhrZ4qAAAAAJob4H4DXTYik72YDWwalvPX83N0';
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret_key . '&response=' . $recaptcha;
    $response = file_get_contents($url);
    $response = json_decode($response);

    if ($response->success == true) {
        $vezeteknev = $_POST['vezNev'];
        $keresztnev = $_POST['kerNev'];
        $felhasznalonev = $_POST['felhasznalonev'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordAgain = $_POST['passwordAgain'];
    
        // Hibakezelés - üzenet inicializálása
        $error = "";
    
        // Felhasználónév és email ellenőrzése az adatbázisban
        $stmt = $pdo->prepare("SELECT * FROM felhasznalo WHERE fh_nev = :fh_name OR email = :email");
        $stmt->bindParam(':fh_name', $felhasznalonev);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $error = "Ez a felhasználónév vagy email már létezik.";
        } elseif ($password !== $passwordAgain) {
            $error = "A két jelszó nem egyezik meg.";
        } else {
            // Jelszó titkosítása
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Új felhasználó mentése az adatbázisba
            $sql = "INSERT INTO felhasznalo (vezeteknev, keresztnev, fh_nev, email, jelszo) 
                    VALUES (:vezeteknev, :keresztnev, :fh_nev, :email, :jelszo)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':vezeteknev', $vezeteknev);
            $stmt->bindParam(':keresztnev', $keresztnev);
            $stmt->bindParam(':fh_nev', $felhasznalonev);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':jelszo', $hashedPassword);
    
            if ($stmt->execute()) {
                $_SESSION['reg_success'] = true;
            } else {
                $error = "Hiba történt a regisztráció során. Próbálja újra.";
            }
    }
    
    }
    else header("regisztracio");
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="icon" type="image/x-icon" href="./képek/HaLálip.ico">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"async defer></script>
</head>
<body>

    <?php include './nav.php'; ?>

    <div class="container form-container">
        <h2 class="text-center">Regisztráció</h2>
        
        <?php if (!empty($error)) { echo "<div class='alert alert-danger text-center'>$error</div>"; } ?>

        <form action="regisztracio.php" method="post" autocomplete="off">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="vezNev" class="form-label">Vezetéknév</label>
                    <input type="text" class="form-control w-100" name="vezNev" id="vezNev" placeholder="Gipsz" required>
                </div>
    
                <div class="col-md-6 mb-3">
                    <label for="kerNev" class="form-label">Keresztnév</label>
                    <input type="text" class="form-control w-100" name="kerNev" id="kerNev" placeholder="Jakab" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="felhasznalonev" class="form-label">Felhasználónév</label>
                    <input type="text" class="form-control w-100" name="felhasznalonev" id="felhasznalonev" placeholder="gipszjakab22" required autocomplete="off">
                </div>
    
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail cím</label>
                    <input type="email" class="form-control w-100" name="email" id="email" placeholder="minta@gmail.com" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Jelszó</label>
                    <input type="password" class="form-control w-100" name="password" id="password" placeholder="*********" required>
                </div>
    
                <div class="col-md-6 mb-3">
                    <label for="passwordAgain" class="form-label">Jelszó megerősítése</label>
                    <input type="password" class="form-control w-100" name="passwordAgain" id="passwordAgain" placeholder="*********" required>
                </div>
            </div>

            <div class="row">
                <label for="adatkezelesi"><input name="adatkezelesi" id="adatkezelesi" type="checkbox" required>
                Elolvastam és elfogadom az <a class="text-dark" href="./adatkezeles">adatkezelési tájékoztató</a>t.</label>
            </div>

            <div class="text-center">
                <!-- secret: 6LcSMZ4qAAAAAKoFX-gDaOa9eOgWBqM8CNVkHKuK-->
                <br>
                <div class="g-recaptcha" data-sitekey="6LfhrZ4qAAAAAKM6FWwbkxfS3zjnRCgE3e_3JmI6"></div>
                <br>
                <button id="navbarGomb" type="submit" class="btn regist-button w-100">Regisztráció</button>
            </div>
        </form>
    </div>
    <?php
        include './footer.php';
    ?>
<?php if (isset($_SESSION['reg_success']) && $_SESSION['reg_success'] === true): ?>
    <div class="modal fade" id="regSuccessModal" tabindex="-1" aria-labelledby="regSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="regSuccessModalLabel">Sikeres regisztráció</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
                </div>
                <div class="modal-body">
                    A regisztrációd sikeres volt, most átirányítunk a bejelentkezési oldalra.
                </div>
                <div class="modal-footer">
                    <button type="button" id="goToLogin" class="btn btn-success">OK</button>
                </div>
            </div>
        </div>
    </div>
<script>
        const showModal = new bootstrap.Modal(document.getElementById('regSuccessModal'));
        showModal.show();

        document.getElementById('goToLogin').addEventListener('click', () => {
            window.location.href = 'bejelentkezes.php';
        });

        // Automatikus átirányítás ha nem nyom semmit 5 mp-ig
        setTimeout(() => {
            window.location.href = 'bejelentkezes.php';
        }, 5000);
</script>

    <?php unset($_SESSION['reg_success']); ?>
    <?php endif; ?>

<script type="text/javascript">
    var onloadCallback = function() {
    grecaptcha.render('html_element', {
        'sitekey' : '6LfhrZ4qAAAAAKM6FWwbkxfS3zjnRCgE3e_3JmI6'
    });
    };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
