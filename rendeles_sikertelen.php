<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés sikeres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

    <?php include './nav.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <h3>Rendelés sikertelen!</h3>
                    <p>Valami nem jó</p>
                    <p>Ha bármilyen kérdése van, kérjük lépjen kapcsolatba velünk!</p>
                    <a href="fooldal.php" class="btn btn-primary">Vissza a főoldalra</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>