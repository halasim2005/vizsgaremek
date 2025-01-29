<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reszponzív Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* Logo méret */
#navbarLogo {
    height: 50px;
}

/* Navbar ikonok */
#navbarIcons {
    height: 30px;
    margin-left: 15px;
}

/* Keresési mező alapból rejtve */
#navbarKereses {
    display: none;
}

/* Megjelenítés osztály */
.megjelenik {
    display: block !important;
}

</style>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow p-3">
        <div class="container-fluid">
            <!-- Hamburger Menü -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Logo -->
            <a href="#" class="navbar-brand">
                <img id="navbarLogo" src="./képek/HaLálip.png" alt="HaLáli Kft. logo">
            </a>

            <!-- Navigációs menü -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="./fooldal">KEZDŐLAP</a></li>
                    <li class="nav-item"><a class="nav-link" href="./termekek">TERMÉKEK</a></li>
                    <li class="nav-item"><a class="nav-link" href="./kalkulator">KALKULÁTOR</a></li>
                    <li class="nav-item"><a class="nav-link" href="./kapcsolat">KAPCSOLAT</a></li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <!-- Kereső -->
                    <li class="nav-item">
                        <form class="d-flex" id="searchForm">
                            <input id="navbarKereses" class="form-control me-2" type="search" placeholder="Keresés">
                            <img id="keresesIkonNavbar" src="./képek/keresesIkon.png" alt="Keresés ikon" onclick="toggleSearch()">
                        </form>
                    </li>

                    <!-- Kosár ikon -->
                    <li class="nav-item">
                        <a href="./kosar"><img id="navbarIcons" src="./képek/kosarIkon.png" alt="Kosár ikon"></a>
                    </li>

                    <!-- PHP: Bejelentkezett felhasználó esetén -->
                    <?php if (isset($_SESSION['felhasznalo'])): ?>
                        <li class="nav-item">
                            <a href="./profil.php"><img src='./képek/profilikon.png' alt="Profil" id="navbarIcons"></a>
                        </li>
                        <?php if ($_SESSION['jogosultsag'] === 'admin'): ?>
                            <li class="nav-item">
                                <a href="./admin/dashboard.php"><img src='./képek/adminIkon.png' alt="Admin" id="navbarIcons"></a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="./kijelentkezes.php" class="btn btn-danger ms-3">Kijelentkezés</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="./regisztracio" class="btn btn-primary ms-3">Regisztráció</a>
                        </li>
                        <li class="nav-item">
                            <a href="./bejelentkezes" class="btn btn-success ms-3">Bejelentkezés</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Modal hibaüzenet -->
<div id="errorModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-danger text-white">
            <div class="modal-body text-center">
                A keresett kifejezés nem található!
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const kereses = document.getElementById("navbarKereses");
    const keresesIkon = document.getElementById("keresesIkonNavbar");

    // Keresési mező megjelenítése ikon kattintásra
    keresesIkon.addEventListener('click', (event) => {
        event.stopPropagation();
        kereses.classList.toggle('megjelenik');
    });

    // Kattintás más helyre: elrejtés
    document.addEventListener('click', (event) => {
        if (!kereses.contains(event.target) && event.target !== keresesIkon) {
            kereses.classList.remove('megjelenik');
        }
    });

    // Keresési funkció
    kereses.addEventListener('keypress', function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            const keresettSzoveg = kereses.value.toLowerCase();

            if (keresettSzoveg.includes("rólunk")) {
                window.location.href = "./fooldal#rolunk";
            } else if (keresettSzoveg.includes("kalkulator")) {
                window.location.href = "./fooldal#kalkulator";
            } else {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }
        }
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
