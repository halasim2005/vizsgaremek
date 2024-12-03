<?php
require_once '../db.php';

// Termék ID lekérése az URL-ből vagy a POST-ból
$product_id = $_POST['product_id'] ?? $_GET['id'] ?? null;

if (!$product_id) {
    die("Hiba: A termék ID hiányzik.");
}

// Termék adatok lekérdezése
$stmt = $pdo->prepare("SELECT * FROM termek WHERE id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Hiba: A termék nem található az adatbázisban.");
}

// Adatok mentése
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form adatok
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $category_id = $_POST['category_id'];
    $available_quantity = $_POST['available_quantity'];
    $manufacturer = $_POST['manufacturer'];
    $type = $_POST['type'];

    // Kép frissítése, ha van új feltöltés
    $image_path = $product['kep'];
    if (!empty($_FILES["product_image"]["name"])) {
        $target_dir = "képek/"; 
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
    }

    // Termék frissítése az adatbázisban
    $stmt = $pdo->prepare("UPDATE termek 
                           SET nev = :nev, leiras = :leiras, egysegar = :egysegar, 
                               kategoria_id = :kategoria_id, elerheto_darab = :elerheto_darab, 
                               gyarto = :gyarto, tipus = :tipus, kep = :kep 
                           WHERE id = :id");
    $stmt->execute([
        'nev' => $product_name,
        'leiras' => $product_description,
        'egysegar' => $product_price,
        'kategoria_id' => $category_id,
        'elerheto_darab' => $available_quantity,
        'gyarto' => $manufacturer,
        'tipus' => $type,
        'kep' => $image_path,
        'id' => $product_id
    ]);

    echo "Termék sikeresen frissítve.";
    header("Location: products.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termék szerkesztése</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">Termék szerkesztése</h1>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Termék neve:</label>
            <input type="text" name="product_name" id="product_name" class="form-control" 
                   value="<?= htmlspecialchars($product['nev']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="product_description" class="form-label">Termék leírása:</label>
            <textarea name="product_description" id="product_description" class="form-control" required><?= htmlspecialchars($product['leiras']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="product_price" class="form-label">Termék ára:</label>
            <input type="number" name="product_price" id="product_price" class="form-control" 
                   value="<?= htmlspecialchars($product['egysegar']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategória:</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <?php
                $categories = $pdo->query("SELECT * FROM kategoria")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $category) {
                    $selected = $category['id'] === $product['kategoria_id'] ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['nev']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="available_quantity" class="form-label">Elérhető darabok száma:</label>
            <input type="number" name="available_quantity" id="available_quantity" class="form-control" 
                   value="<?= htmlspecialchars($product['elerheto_darab']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="manufacturer" class="form-label">Gyártó:</label>
            <input type="text" name="manufacturer" id="manufacturer" class="form-control" 
                   value="<?= htmlspecialchars($product['gyarto']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Típus:</label>
            <input type="text" name="type" id="type" class="form-control" 
                   value="<?= htmlspecialchars($product['tipus']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="product_image" class="form-label">Termék képe:</label>
            <input type="file" name="product_image" id="product_image" class="form-control">
            <img src="<?= htmlspecialchars($product['kep']) ?>" alt="Jelenlegi kép" style="max-width: 100px; margin-top: 10px;">
        </div>
        <!-- Termék ID hozzáadása rejtett mezőben -->
        <input type="hidden" name="product_id" id="product_id" value="<?= htmlspecialchars($product_id) ?>">

        <button type="submit" class="btn btn-primary">Mentés</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
