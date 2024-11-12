<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haláli Villszer Kft. - Kosár</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>

    <?php
        include './navbar.php';
    ?>

    <!-- Main Content -->
    <div class="container main-container">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <h2>Kosár <span class="text-muted">3 termék</span></h2>
                
                <!-- Card for each item -->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="images/kabel.png" class="img-fluid rounded-start" alt="Vezeték">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">EM 0,75 vezeték tömör réz zöld/sárga</h5>
                                <p class="card-text">55 Ft / m</p>
                                <div class="d-flex align-items-center">
                                    <input type="number" value="10" min="1" class="form-control me-2" style="width: 80px;"> m
                                </div>
                                <p class="card-text"><strong>550 Ft</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="images/detektor.png" class="img-fluid rounded-start" alt="Feszültség detektor">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">EM Érintés nélküli feszültség detektor</h5>
                                <p class="card-text">1810 Ft / db</p>
                                <div class="d-flex align-items-center">
                                    <input type="number" value="1" min="1" class="form-control me-2" style="width: 80px;"> db
                                </div>
                                <p class="card-text"><strong>1810 Ft</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img class="kepekImg" src="képek/vilagitastechnika/led_panel_mennyezeti_3W.webp" class="img-fluid rounded-start" alt="LED panel">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">EM LED panel mennyezeti 3W</h5>
                                <p class="card-text">1275 Ft / db</p>
                                <div class="d-flex align-items-center">
                                    <input type="number" value="1" min="1" class="form-control me-2" style="width: 80px;"> db
                                </div>
                                <p class="card-text"><strong>1275 Ft</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h3>Rendelés összesítő</h3>
                    <p>Összesen: <span>3635 Ft</span></p>
                    <p>Szállítás: <span>1690 Ft</span></p>
                    <p>ÁFA (27%): <span>981 Ft</span></p>
                    <h4>Végösszeg: <strong>5325 Ft</strong></h4>
                    <button class="checkout-button mt-3 w-100">Tovább a fizetéshez</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
