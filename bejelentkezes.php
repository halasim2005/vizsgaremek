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
            $_SESSION['felhasznalo'] = $user['fh_nev'];
            $_SESSION['jogosultsag'] = $user['jogosultsag']; // Pl.: "admin" vagy "user"
            if($_SESSION['jogosultsag'] == 'admin') $_SESSION['admin_logged_in'] = true;
            // Átirányítás főoldalra vagy admin oldalra
            header("Location: fooldal.php");
            exit();
        } else {
            $error = "Hibás jelszó.";
        }
    } else {
        $error = "Nem létező felhasználó.";
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
</head>
<body>
    <?php include './navbar.php'; ?>
    <div class="container form-container">
        <h2 class="text-center">Bejelentkezés</h2>
        
        <?php if (!empty($error)) { echo "<div class='alert alert-danger text-center'>$error</div>"; } ?>

        <form action="bejelentkezes.php" method="post" autocomplete="off">
            <?php
                if (isset($_GET['logout']) && $_GET['logout'] == 1) {
                    echo "<div class='alert alert-success'>Sikeres kijelentkezés!</div>";
                }
            ?>
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
