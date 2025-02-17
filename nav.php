<nav class="navbar navbar-expand-lg bg-body-tertiary shadow rounded">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img id="navLogo" src="./képek/HaLálip.png" alt="HaLáli Kft. logo">
            <a class="ms-auto">
                <a class="nav-link" href="./kosar">
                    <img id="kosarIkon__3" src="./képek/kosarIkon.png" alt="Kosár ikon">
                    <span id="cart-count" class="badge">
                        <?php 
                            include './kosarszamlalo.php';
                        ?>
                    </span>
                </a>    
                <a class="nav-link" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src='./képek/profilikon.png' id="profilIkon__3" alt="Profil">
                </a>
            </a>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./fooldal">Kezdőlap</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./termekek">Termékek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./kalkulator">Kalkulátor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./kapcsolat">Kapcsolat</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./kosar"><img id="kosarIkon__2" src="./képek/kosarIkon.png" alt="Kosár ikon">
                    <span id="cart-count" class="badge">
                        <?php 
                            include './kosarszamlalo.php';
                        ?>
                    </span></a>
                </li>
                <li class="nav-item dropdown dropstart">
                    <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src='./képek/profilikon.png' id="profilIkon__2" alt="Profil">
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (isset($_SESSION['felhasznalo'])): ?>
                            <li><a class="dropdown-item" href="./profil.php">Profil</a></li>
                                <?php if ($_SESSION['jogosultsag'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="./admin/dashboard.php">Admin dashboard</a></li>
                                <?php endif; ?>
                            <li><a class="dropdown-item" href="./kijelentkezes.php">Kijelentkezés</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="./regisztracio">Regisztráció</a></li>
                            <li><a class="dropdown-item" href="./bejelentkezes">Bejelentkezés</a></li>
                        <?php endif; ?>
                    </ul>
                </li>       
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const navbarToggler = document.querySelector(".navbar-toggler");

        navbarToggler.addEventListener("click", function () {
            this.classList.toggle("open");
        });
    });
</script>
