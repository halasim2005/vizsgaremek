<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<style>
    *{
        font-family: 'Montserrat';
    }

    /*.navbar{
        height: 70px;
    }*/

    #navbarGomb{
      background-color: white;
      border: 1px solid black;
      color:black;
      text-decoration: none;
      border-radius: 5px;
    }

    #navbarGomb:hover{
      background-color: rgb(61, 61, 61);
      border: 1px solid rgb(61, 61, 61);
      color:white;
      text-decoration: none;
      border-radius: 5px;
    }
    #navbarIcons{
      width: 35px;
    }

    #profilIconPadding{
        padding-left: 10px;
        padding-right: 10px;
    }

    #keresesIkonNavbar{
        width: 35px;
        cursor: pointer;
    }

    #kosarIkonPadding{
        padding-left: 10px;
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

</style>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <nav class="navbar navbar-expand-lg shadow rounded fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="./képek/HaLálip.png" width="70px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="./képek/HaLálip.png" width="70px"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-left flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="./fooldal">KEZDŐLAP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="./termekek">TERMÉKEK</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="./kalkulator">KALKULÁTOR</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="./kapcsolat">KAPCSOLAT</a>
                </li>
              </ul>
            </div>
          </div>
          
        </div>
      </nav>
</body>
</html>

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

