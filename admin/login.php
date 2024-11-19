<?php
session_start();
include '../db.php'; // Az adatbázis kapcsolat.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Admin felhasználó ellenőrzése.
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Hibás felhasználónév vagy jelszó.";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Admin bejelentkezés</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <h2>Admin bejelentkezés</h2>
    <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="post">
        <input type="text" name="username" placeholder="Felhasználónév" required>
        <input type="password" name="password" placeholder="Jelszó" required>
        <button type="submit">Belépés</button>
    </form>
</body>
</html>
