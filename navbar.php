<nav class="navbar navbar-expand-lg navbar-dark shadow p-3 mb-5 bg-white rounded">
    <div class="container-fluid">
<!--<a class="navbar-brand" href="#">HaLáli Villszer Kft.</a>-->
        <a href="#"><img id="navbarLogo" src="./képek/HaLálip.png" alt="HaLáli Kft. logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="./fooldal">KEZDŐLAP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./termekek">TERMÉKEK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./kalkulator">KALKULÁTOR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./kapcsolat">KAPCSOLAT</a>
                </li>
            </ul>
            <form id="keresesIkonPadding" class="d-flex" role="search">
                <input id="navbarKereses" class="form-control btn-outline-primary me-2" type="search" placeholder="Keresés" aria-label="Keresés">
                <img id="keresesIkonNavbar"  onclick="keresesMegj()" src="./képek/keresesIkon.png" alt="Keresés ikon">
            </form>
            <a id="kosarIkonPadding" href="./kosar"><img id="navbarIcons" src="./képek/kosarIkon.png" alt="Kosár ikon"></a>

            <?php if (isset($_SESSION['felhasznalo'])): ?>
                <a id="profilIconPadding"  href="./profil.php"><img src='./képek/profilikon.png' alt="Profil" id="navbarIcons"></a>
                <?php if ($_SESSION['jogosultsag'] === 'admin'): ?>
                    <a href="./admin/dashboard.php"><img src='./képek/adminIkon.png' alt="Profil" id="navbarIcons"></a>
                <?php endif; ?>
                <a id="navbarGomb" href="./kijelentkezes.php" class="btn login-button ms-3">Kijelentkezés</a>
            <?php else: ?>
                <a id="navbarGomb" href="./regisztracio" class="btn regist-button ms-3">Regisztráció</a>
                <a id="navbarGomb" href="./bejelentkezes" class="btn login-button ms-3">Bejelentkezés</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<link rel="stylesheet" href="./style/style.css">

<!-- Modal -->
<div id="errorModal" class="modal fade" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="modal-content" style="background-color: #f44336; color: white; border-radius: 8px;">
            <div class="modal-body" style="padding: 20px; text-align: center;">
                A keresett kifejezés nem található!
            </div>
        </div>
    </div>
</div>


<script>
    // Kattintáskor bezárjuk a menüt, ha egy linket választunk
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    link.addEventListener('click', () => {
        const navbarCollapse = document.querySelector('.navbar-collapse');
        navbarCollapse.classList.remove('show'); // Bezárjuk a menüt
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const kereses = document.getElementById("navbarKereses");
        const keresesIkon = document.getElementById("keresesIkonNavbar");

        // Kattintás az ikonra: láthatóság váltása
        keresesIkon.addEventListener('click', (event) => {
            event.stopPropagation(); // Megállítjuk az eseményt, hogy ne terjedjen tovább
            kereses.classList.toggle('megjelenik'); // Osztály hozzáadása/eltávolítása
        });

        // Kattintás bárhová máshova: eltüntetjük a keresési mezőt
        document.addEventListener('click', (event) => {
            // Ellenőrizzük, hogy a kattintás nem a keresési mezőn volt-e
            // vagy nem a keresési ikonon
            if (!kereses.contains(event.target) && event.target !== keresesIkon) {
                kereses.classList.remove('megjelenik'); // Ha máshova kattintunk, eltüntetjük
            }
        });

        // Ha a keresési mezőn belül kattintunk, ne tüntessük el
        kereses.addEventListener('click', (event) => {
            event.stopPropagation(); // Megállítjuk az eseményt, hogy ne terjedjen tovább
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const keresMezo = document.getElementById("navbarKereses");

        // Keresés esemény figyelése
        keresMezo.addEventListener('keypress', function(event) {
            // Csak akkor lépjen, ha az Enter gombot nyomjuk meg
            if (event.key === "Enter") {
                const keresettSzoveg = keresMezo.value.toLowerCase();

                // Ha a keresett kifejezés tartalmazza a "rólunk" szót
                if (keresettSzoveg.includes("rólunk") || keresettSzoveg.includes("rolunk")) {
                    // Navigálás a főoldalon belüli "rólunk" szekcióhoz
                    window.location.href = "./fooldal#rolunk";  // A #rolunk a főoldalon lévő szekció ID-ja
                }else if(keresettSzoveg.includes("kínálatunk") || keresettSzoveg.includes("kinalatunk")){
                    window.location.href = "./fooldal#kinalatunk";
                }
                else if(keresettSzoveg.includes("kalkulator") || keresettSzoveg.includes("kalkulátor")){
                    window.location.href = "./fooldal#kalkulator";
                } 
                else if(keresettSzoveg.includes("ugyfel") || keresettSzoveg.includes("ugyfelszolgalat") || keresettSzoveg.includes("ügyfélszolgálat")){
                    window.location.href = "./fooldal#ugyfel";
                }  
                else {
                    // Ha más kifejezésre keres, itt kezelheted a keresést, pl. eredmények megjelenítése
                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                }

                // Megakadályozzuk, hogy az oldal frissüljön
                event.preventDefault();
            }
        });
    });

</script>