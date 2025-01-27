<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./style/style.css">
    <title>HaLáli Webshop</title>
</head>

<style>
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

li{
    list-style: none;
}

a{
    color: white;
    text-decoration: none;
}

.navbar{
    min-height: 70px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 24px;
}

.nav-menu{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 60px;
}

.nav-branding{
    font-size: 2rem;
}

.nav-link{
    color: rgb(106, 106, 106) !important;
    font-weight: 900;
    font-size: medium;
}

.nav-link:hover {
    color: black !important;
    font-weight: 900;
}

.nav-link:after{
    content: '';
    margin: auto;
    display: block;
    height: 2px;
    width: 0%;
    background-color: transparent;
    /*transition: width 0.5s ease,background-color 0.5s ease; */
    transition: all 0.5s ease;
}
.nav-link:hover:after{
    width: 100%;
    background-color: rgb(0, 0, 0);
}

.hamburger{
    display: none;
    cursor: pointer;
}

.bar{
    display: block;
    width: 25px;
    height: 3px;
    margin: 5px auto;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    background-color: rgb(61, 61, 61);
}

@media (max-width: 991px) {
    #navbarLogo{
        display: none;
    }

    .hamburger{
        display: block;
    }

    .hamburger.active .bar:nth-child(2){
        opacity: 0;
    }

    .hamburger.active .bar:nth-child(1){
        transform: translateY(8px) rotate(45deg);
    }

    .hamburger.active .bar:nth-child(3){
        transform: translateY(-8px) rotate(-45deg);
    }

    .nav-menu{
        position: fixed;
        left: -100%;
        top: 70px;
        gap: 0;
        flex-direction: column;
        background-color: rgb(61, 61, 61);
        width: 100%;
        text-align: center;
        transition: 0.3s;
    }

    .nav-item{
        margin: 16px 0;
    }

    .nav-menu.active{
        left: 0;
    }
}


</style>
<header>
    <nav class="navbar navbar-expand-lg navbar-light shadow p-3 mb-5 bg-white rounded">
        <div class="hamburger" id="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <a href="#" class="nav-branding"><img id="navbarLogo" style="width: 70px" src="./képek/HaLálip.png" alt="HaLáli Kft. logo"></a>

        <ul class="nav-menu me-auto mb-2 mb-lg-0">
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
    </nav>
</header>

<script>
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-menu");

    hamburger.addEventListener("click", () => {
        hamburger.classList.toggle("active");
        navMenu.classList.toggle("active");
    })
</script>