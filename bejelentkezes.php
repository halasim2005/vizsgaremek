<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
    <title>Bejelentkezés</title>
</head>

<body>

    <?php
        include './navbar.php';
    ?>
    
    <div class="container form-container">
        <form action="" method="post" autocomplete="off">
            <h2 class="text-center">Bejelentkezés</h2>
            <div class="mb-3">
                <label for="felhasznalonev" class="form-label">Felhasználónév</label>
                <input type="text" class="form-control" name="felhasznalonev" id="felhasznalonev" placeholder="gipszjakab22" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="*********" required>
            </div>

            <div class="text-center">
                    <button type="submit" class="btn btn-primary">Bejelentkezés</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>