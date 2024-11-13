<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HaLáli Villszer Kft.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="./fooldal.php">Kezdőlap</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./termekek.php">Termékek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./kalkulator.php">Kalkulátor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./kapcsolat.php">Kapcsolat</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control btn-outline-primary me-2" type="search" placeholder="Keresés" aria-label="Keresés">
            </form>
            <a href="./kosar.php" class="btn cart-button ms-3">Kosár</a>

            <?php if (isset($_SESSION['felhasznalo'])): ?>
                <a href="./profil.php" class="btn regist-button ms-3">Profil</a>
                <a href="./kijelentkezes.php" class="btn login-button ms-3">Kijelentkezés</a>
            <?php else: ?>
                <a href="./regisztracio.php" class="btn regist-button ms-3">Regisztráció</a>
                <a href="./bejelentkezes.php" class="btn login-button ms-3">Bejelentkezés</a>
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
</script>