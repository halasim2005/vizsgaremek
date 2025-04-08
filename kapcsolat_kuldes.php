<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

session_start();

// .env betöltése
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['flash_error'] = "Kérlek, töltsd ki az összes mezőt!";
        header("Location: kapcsolat.php");
        exit();
    }

    try {
        // ======= 1. EMAIL: Megy a cégnek =======
        $toCeg = new PHPMailer(true);
        $toCeg->isSMTP();
        $toCeg->Host = 'smtp.gmail.com';
        $toCeg->SMTPAuth = true;
        $toCeg->Username = $_ENV['SMTP_USER'];
        $toCeg->Password = $_ENV['SMTP_PASS'];
        $toCeg->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $toCeg->Port = 587;
        $toCeg->CharSet = 'UTF-8';

        $toCeg->setFrom($email, $name);
        $toCeg->addAddress($_ENV['SMTP_USER'], 'HaLáli Kft. Kapcsolat');

        $toCeg->isHTML(true);
        $toCeg->Subject = 'Új kapcsolatfelvétel az oldalról';
        $toCeg->Body = "
            <h3>Új üzenet érkezett</h3>
            <p><strong>Név:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Üzenet:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
        ";
        $toCeg->send();


        // ======= 2. EMAIL: Visszaigazolás a látogatónak =======
        $toFelado = new PHPMailer(true);
        $toFelado->isSMTP();
        $toFelado->Host = 'smtp.gmail.com';
        $toFelado->SMTPAuth = true;
        $toFelado->Username = $_ENV['SMTP_USER'];
        $toFelado->Password = $_ENV['SMTP_PASS'];
        $toFelado->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $toFelado->Port = 587;
        $toFelado->CharSet = 'UTF-8';

        $toFelado->setFrom($_ENV['SMTP_USER'], 'HaLáli Kft.');
        $toFelado->addAddress($email, $name);

        $toFelado->isHTML(true);
        $toFelado->Subject = 'Üzeneted megérkezett hozzánk';
        $toFelado->Body = "
            <p>Kedves <strong>{$name}</strong>!</p>
            <p>Köszönjük, hogy írtál nekünk. Az alábbi üzenetedet megkaptuk, és hamarosan válaszolunk:</p>
            <blockquote>" . nl2br(htmlspecialchars($message)) . "</blockquote>
            <br>
            <p>Üdvözlettel,<br><strong>HaLáli Kft. csapata</strong></p>
        ";
        $toFelado->send();

        $_SESSION['flash_success'] = "Az üzenetet sikeresen elküldtük! Köszönjük a megkeresést.";
    } catch (Exception $e) {
        $_SESSION['flash_error'] = "Hiba történt az e-mail küldésekor: " . $e->getMessage();
    }

    header("Location: kapcsolat.php");
    exit();
}
?>
