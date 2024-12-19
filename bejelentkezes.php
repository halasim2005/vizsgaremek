<?php
session_start();
include 'db.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $felhasznalonev = $_POST['felhasznalonev'];
    $password = $_POST['password'];    
    
    $stmt = $pdo->prepare("SELECT * FROM felhasznalo WHERE fh_nev = :fh_name");
    $stmt->bindParam(':fh_name', $felhasznalonev);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (password_verify($password, $user['jelszo'])) {
            $_SESSION['felhasznalo'] = $user;
            $_SESSION['jogosultsag'] = $user['jogosultsag'];
            if($_SESSION['jogosultsag'] == 'admin') $_SESSION['admin_logged_in'] = true;
            // Bejelentkezés után, felhasználó kosarának visszaállítása
            header("Location: fooldal");
            $user_id = $_SESSION['user_id'];  // A felhasználó ID-ja
    
            // Lekérjük a felhasználó rendelését
            $query = "SELECT t.termek_id, t.tetelek_mennyiseg, p.nev, p.ar 
                    FROM tetelek t 
                    JOIN termekek p ON t.termek_id = p.id 
                    WHERE t.rendeles_id LIKE ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$user_id . '%']);  // A rendelés ID-ja a felhasználóhoz van kötve
    
            $kosar = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Kosárba tesszük az összes tételt
                $kosar[] = $row;
            }
            exit();
        } else {
            $error = "Hibás felhasználónév vagy jelszó.";
        }
    } else {
        $error = "Hibás felhasználónév vagy jelszó."; //nemlétező felhasználó
    }
    

}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="container form-container">
        <h2 class="text-center">Bejelentkezés</h2>
        
        
        <form action="bejelentkezes.php" method="post" autocomplete="off">
            <?php
                if (isset($_GET['logout']) && $_GET['logout'] == 1) {
                    echo "<div class='alert alert-success'>Sikeres kijelentkezés!</div>";
                }
                if (!empty($error)) { echo "<div class='alert alert-danger text-center'>$error</div>"; } ?>
            <div class="row">
                <div class="mb-3">
                    <label for="felhasznalonev" class="text-center form-label">Felhasználónév</label>
                    <input type="text" class="form-control w-100" name="felhasznalonev" id="felhasznalonev" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="password" class="form-label text-center">Jelszó</label>
                    <input type="password" class="form-control w-100" name="password" id="password" required>
                </div>
            </div>
            
            <div class="row">
                <div class="mb-3">
                    <!--secret: 6LfhrZ4qAAAAAJob4H4DXTYik72YDWwalvPX83N0-->
                    <div class="g-recaptcha text-center" data-sitekey="6LfhrZ4qAAAAAKM6FWwbkxfS3zjnRCgE3e_3JmI6"></div>
                </div>
            </div>

            <div class="text-center">
                <button id="navbarGomb" type="submit" class="btn">Bejelentkezés</button>
            </div>
        </form>
    </div>
    <?php
        include './footer.php';
    ?>
</body>
</html>
