<?php
$servername = "localhost";
$username = "root";  // Adatbázis felhasználónév
$password = "";      // Adatbázis jelszó
$dbname = "halaliweb";  // Az adatbázis neve

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Kapcsolódási hiba: " . $e->getMessage();
}
?>
