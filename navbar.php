<?php

?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
<!--<a class="navbar-brand" href="#">HaLáli Villszer Kft.</a>-->
        <img id="navbarLogo" href="fooldal.php" src="./képek/HaLálip.png" alt="HaLáli Kft. logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="./fooldal.php">KEZDŐLAP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./termekek.php">TERMÉKEK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./kalkulator.php">KALKULÁTOR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./kapcsolat.php">KAPCSOLAT</a>
                </li>
            </ul>
            <form id="keresesIkonPadding" class="d-flex" role="search">
                <input id="navbarKereses" class="form-control btn-outline-primary me-2" type="search" placeholder="Keresés" aria-label="Keresés">
                <img id="keresesIkonNavbar"  onclick="keresesMegj()" src="./képek/keresesIkon.png" alt="Keresés ikon">
            </form>
            <a id="kosarIkonPadding" href="./kosar.php"><img id="navbarIcons" src="./képek/kosarIkon.png" alt="Kosár ikon"></a>

            <?php if (isset($_SESSION['felhasznalo'])): ?>
                <?php if ($_SESSION['jogosultsag'] === 'admin'): ?>
                    <a href="./admin/dashboard.php" class="btn btn-warning ms-3">Admin</a>
                <?php endif; ?>
                <a href="./profil.php" class="btn regist-button ms-3">Profil</a>
                <a href="./kijelentkezes.php" class="btn login-button ms-3">Kijelentkezés</a>
            <?php else: ?>
                <a id="navbarGomb" href="./regisztracio.php" class="btn regist-button ms-3">Regisztráció</a>
                <a id="navbarGomb" href="./bejelentkezes.php" class="btn login-button ms-3">Bejelentkezés</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    // Kattintáskor bezárjuk a menüt, ha egy linket választunk
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    link.addEventListener('click', () => {
        const navbarCollapse = document.querySelector('.navbar-collapse');
        navbarCollapse.classList.remove('show'); // Bezárjuk a menüt
        });
    });

    function keresesMegj(){
        let kereses = document.getElementById("navbarKereses");
        let keresesIkon = document.getElementById("keresesIkonNavbar");
        kereses.style.visibility = "visible";
    }
</script>