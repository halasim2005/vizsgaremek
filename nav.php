<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

<style>
    #kosarIkon__2{
        width: 40px;
        display: block;
    }

    #kosarIkon__3{
        display: none;
    }

    #profilIkon__2{
        width: 40px;
        margin-right: 30px;
        display: block;
    }

    #profilIkon__3{
        display: none;
    }

    .navbar{
        font-family: 'Montserrat';
    }

    .nav-link{
        color: rgb(61, 61, 61);
    }

    .nav-link:hover {
        color: black !important;
        font-weight: 500;
    }

    .navbar-nav {
        gap: 40px; 
        font-size: large;
        color: rgb(61, 61, 61);
    }

    #navLogo{
        height: 80px;
    }

    @media (max-width: 991px){
        .navbar-toggler{
            border: none;
            color: rgb(61, 61, 61);
        }

        .navbar-nav {
            gap: 10px; 
        }

        #kosarIkon__2{
            display: none;
        }

        #kosarIkon__3{
            display: block;
            width: 40px;
            margin-right: 15px;
            margin-left: 15px;
        }

        #profilIkon__2{
            display: none;
        }

        #profilIkon__3{
            display: block;
            width: 40px;
            margin-right: 15px;
            margin-left: 15px;
        }
    }

    /* Hamburger ikon alapstílusok */
    .hamburger {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 30px;
        height: 24px;
        cursor: pointer;
        border: none;
    }

    .bar {
        width: 100%;
        height: 4px;
        background-color: black;
        border-radius: 2px;
        transition: all 0.4s ease-in-out;
    }

    /* Ha a menü nyitva van */
    .navbar-toggler.open .bar:nth-child(1) {
        transform: translateY(10px) rotate(45deg);
    }

    .navbar-toggler.open .bar:nth-child(2) {
        opacity: 0;
    }

    .navbar-toggler.open .bar:nth-child(3) {
        transform: translateY(-10px) rotate(-45deg);
    }

    
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary shadow rounded">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img id="navLogo" src="./képek/HaLálip.png" alt="HaLáli Kft. logo">
            <a class="ms-auto">
                <a class="nav-link" href="./kosar">
                    <img id="kosarIkon__3" src="./képek/kosarIkon.png" alt="Kosár ikon">
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
                    <a class="nav-link" href="./kosar"><img id="kosarIkon__2" src="./képek/kosarIkon.png" alt="Kosár ikon"></a>
                </li>
                <li class="nav-item dropdown">
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
