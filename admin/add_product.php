<?php
// PDO adatbázis kapcsolat
require_once '../db.php';  // A konfigurációs fájl, ami tartalmazza a PDO kapcsolatot

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
    $manufacturer = $_POST['manufacturer'];  // Új mező: gyártó
    $type = $_POST['type'];  // Új mező: típus

    // Kép feltöltés
    $target_dir = "képek/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image_path = $target_file;

    // Ellenőrzés, hogy a fájl tényleg kép
    if (getimagesize($_FILES["product_image"]["tmp_name"]) === false) {
        echo "Hiba: A fájl nem egy kép.";
    } else {
        // Kép feltöltése
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $image_path)) {
            echo "A kép sikeresen feltöltődött.";
        } else {
            echo "Hiba történt a fájl feltöltése közben.";
            $image_path = null;  // Ha hiba történt, ne adjuk hozzá a képet
        }

        // Új termék hozzáadása az adatbázishoz
        $stmt = $pdo->prepare("INSERT INTO termek (nev, leiras, egysegar, kategoria_id, elerheto_darab, gyarto, tipus, kep) 
                               VALUES (:nev, :leiras, :egysegar, :kategoria_id, :elerheto_darab, :gyarto, :tipus, :kep)");
        $stmt->execute([
            'nev' => $product_name,
            'leiras' => $product_description,
            'egysegar' => $product_price,
            'kategoria_id' => $category_id,
            'elerheto_darab' => $available_quantity,
            'gyarto' => $manufacturer,  // Hozzáadva gyártó mező
            'tipus' => $type,  // Hozzáadva típus mező
            'kep' => $image_path
        ]);

        echo "Termék sikeresen hozzáadva.";
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
    <link rel="stylesheet" href="styles.css"> <!-- Linkeld a stíluslapot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navbar-height: 70px;
        }
        body {
            padding-top: var(--navbar-height);
        }
        .row {
            overflow-x: auto;
            word-wrap: break-word;
            max-width: 100%;
            margin: 0 auto;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .card-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .alert {
            margin-top: 2rem;
        }
    </style>
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
