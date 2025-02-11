<?php
session_start();
if (!isset($_SESSION['jogosultsag']) || $_SESSION['jogosultsag'] !== 'admin') {
    header("Location: ../fooldal.php");
    exit();
}
include './admin_navbar.php';

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Termékek Kezelése</h1>
    <div class="text-center mb-3">
        <a href="add_product.php" class="btn btn-success termek_add_button">Új Termék Hozzáadása</a>
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
                            <form action='delete_product.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='product_id' value='{$row['id']}'>
                            <button type='submit' class='btn btn-danger btn-sm delete-product'>Törlés</button>
                            </form>
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
<!-- Modal HTML -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black" id="confirmDeleteLabel">Megerősítés</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
      </div>
      <div class="modal-body text-black">
        Biztosan törölni szeretnéd ezt a terméket?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Mégse</button>
        <form id="deleteForm" method="POST" action="delete_product.php" style="display: inline;">
          <input type="hidden" name="product_id" id="modalProductId" value="">
          <button type="submit" class="btn btn-danger">Törlés</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.delete-product').forEach(btn => {
    btn.addEventListener('click', function(event) {
        event.preventDefault(); // Megakadályozza az alapértelmezett űrlapbeküldést
        const productId = this.previousElementSibling.value; // A termék ID-jének lekérése
        document.getElementById('modalProductId').value = productId; // Átadja a modálnak
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show(); // Megjeleníti a modált
    });
});

</script>

</body>
</html>
<?php $conn->close(); ?>
