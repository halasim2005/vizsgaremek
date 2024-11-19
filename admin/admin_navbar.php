<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="./dashboard.php">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="./users.php">Felhasználók kezelése</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./orders.php">Rendelések kezelése</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./products.php">Termékek kezelése</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (isset($_SESSION['felhasznalo']) && $_SESSION['jogosultsag'] === 'admin'): ?>
                    <span class="navbar-text me-3">Üdv, <?php echo htmlspecialchars($_SESSION['felhasznalo']); ?>!</span>
                    <a href="../kijelentkezes.php" class="btn btn-danger">Kijelentkezés</a>
                <?php else: ?>
                    <a href="./bejelentkezes.php" class="btn btn-primary">Bejelentkezés</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
