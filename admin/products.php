<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}

include './admin_navbar.php';

// Csatlakozás az adatbázishoz
$conn = new mysqli('localhost', 'root', '', 'halaliweb');
if ($conn->connect_error) {
    die("Adatbázis hiba: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termékek Kezelése</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Termékek Kezelése</h1>
    <div class="text-end mb-3">
        <a href="add_product.php" class="btn btn-success">Új Termék Hozzáadása</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Egységár</th>
                <th>Kategória</th>
                <th>Készlet</th>
                <th>Gyártó</th>
                <th>Típus</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Termékek lekérdezése
            $sql = "SELECT termek.id, termek.nev, termek.egysegar, termek.kategoria_id, termek.elerheto_darab, termek.gyarto, termek.tipus, kategoria.nev AS kategoria_nev
                    FROM termek
                    JOIN kategoria ON termek.kategoria_id = kategoria.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nev']}</td>
                        <td>{$row['egysegar']} Ft</td>
                        <td>{$row['kategoria_nev']}</td>
                        <td>{$row['elerheto_darab']}</td>
                        <td>{$row['gyarto']}</td>
                        <td>{$row['tipus']}</td>
                        <td>
                            <a href='edit_product.php?id={$row['id']}' class='btn btn-primary btn-sm'>Szerkesztés</a>
                            <a href='delete_product.php?id={$row['id']}' class='btn btn-danger btn-sm'>Törlés</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Nincsenek termékek</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
