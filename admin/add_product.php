<?php
// PDO adatbázis kapcsolat
require_once '../db.php';

// Kategória hozzáadás
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    // Ellenőrizzük, hogy létezik-e már a kategória
    $stmt = $pdo->prepare("SELECT * FROM kategoria WHERE nev = :nev");
    $stmt->execute(['nev' => $category_name]);
    if ($stmt->rowCount() > 0) {
        echo "Ez a kategória már létezik.";
    } else {
        // Új kategória hozzáadása
        $stmt = $pdo->prepare("INSERT INTO kategoria (nev, leiras) VALUES (:nev, :leiras)");
        $stmt->execute(['nev' => $category_name, 'leiras' => $category_description]);
        echo "Kategória sikeresen hozzáadva.";
    }
}

// Termék hozzáadása
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $category_id = $_POST['category_id'];
    $available_quantity = $_POST['available_quantity'];
    $manufacturer = $_POST['manufacturer'];
    $type = $_POST['type'];

    // Kép feltöltés
    $target_dir = "képek/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image_path = $target_file;

    // Ellenőrzés, hogy a fájl tényleg kép
    if (getimagesize($_FILES["product_image"]["tmp_name"]) === false) {
        echo "Hiba: A fájl nem egy kép.\n";
    } else {
        // Kép feltöltése
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $image_path)) {
            echo "A kép sikeresen feltöltődött.\n";
        } else {
            echo "Hiba történt a fájl feltöltése közben.\n";
            $image_path = null;  // Ha hiba történt, ne adjuk hozzá a képet
        }

        $stmt = $pdo->prepare("SELECT * FROM termek WHERE nev = :nev AND kategoria_id = :kategoria_id");
        $stmt->execute(['nev' => $product_name, 'kategoria_id' => $category_id]);
        if ($stmt->rowCount() > 0) {
            die("Hiba: Ez a termék már létezik az adott kategóriában.\n");
        }
        else{
            // Új termék hozzáadása az adatbázishoz
            $stmt = $pdo->prepare("INSERT INTO termek (nev, leiras, egysegar, kategoria_id, elerheto_darab, gyarto, tipus, kep) 
                                VALUES (:nev, :leiras, :egysegar, :kategoria_id, :elerheto_darab, :gyarto, :tipus, :kep)");
            $stmt->execute([
                'nev' => $product_name,
                'leiras' => $product_description,
                'egysegar' => $product_price,
                'kategoria_id' => $category_id,
                'elerheto_darab' => $available_quantity,
                'gyarto' => $manufacturer,
                'tipus' => $type,
                'kep' => $image_path
            ]);

            echo "Termék sikeresen hozzáadva.";
        }
    }
}
include './admin_navbar.php';
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termék hozzáadása</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Kanit:wght@300&family=Montserrat&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Termék és Kategória Hozzáadása</h1>

        <div class="row">
            <!-- Kategória hozzáadása kártya -->
            <div class="col-md-6">
                <div class="card">
                    <h2 class="card-title text-center">Kategória hozzáadása</h2>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="category_name">Kategória neve:</label>
                            <input type="text" class="form-control" name="category_name" id="category_name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_description">Kategória leírása:</label>
                            <textarea class="form-control" name="category_description" id="category_description" required></textarea>
                        </div>
                        <button type="submit" name="add_category" class="btn btn-success btn-block mt-3">Kategória hozzáadása</button>
                    </form>
                </div>
            </div>

            <!-- Termék hozzáadása kártya -->
            <div class="col-md-6">
                <div class="card">
                    <h2 class="card-title text-center">Új Termék Hozzáadása</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Termék neve:</label>
                            <input type="text" class="form-control" name="product_name" id="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="product_description">Termék leírása:</label>
                            <textarea class="form-control" name="product_description" id="product_description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_price">Termék ára:</label>
                            <input type="number" class="form-control" name="product_price" id="product_price" required>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategória:</label>
                            <select class="form-control" name="category_id" id="category_id" required>
                                <?php
                                // Kategóriák lekérése
                                $stmt = $pdo->query("SELECT * FROM kategoria");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['id']}'>{$row['nev']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="available_quantity">Elérhető darabok száma:</label>
                            <input type="number" class="form-control" name="available_quantity" id="available_quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="manufacturer">Gyártó:</label>
                            <input type="text" class="form-control" name="manufacturer" id="manufacturer" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Típus:</label>
                            <input type="text" class="form-control" name="type" id="type" required>
                        </div>
                        <div class="form-group">
                            <label for="product_image">Termék képe:</label>
                            <input type="file" class="form-control" name="product_image" id="product_image" required>
                        </div>
                        <button type="submit" name="add_product" class="btn btn-primary btn-block mt-3">Termék hozzáadása</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
