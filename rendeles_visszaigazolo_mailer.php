<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

// Betöltjük a környezeti változókat
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function sendOrderConfirmation($toEmail, $orderDetails) {
    $mail = new PHPMailer(true);
    
    try {
        // SMTP szerver beállításai
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER']; // Email .env-ből
        $mail->Password = $_ENV['SMTP_PASS']; // Jelszó .env-ből
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8'; // Karakterkódolás

        // Feladó és címzett
        $mail->setFrom($_ENV['SMTP_USER'], 'Webshop');
        $mail->addAddress($toEmail);

        // Tárgy és tartalom
        $mail->Subject = 'Rendelés visszaigazolás';
        $mail->isHTML(true);
        $mail->Body = "
            <h2>Kedves Vásárlónk!</h2>
            <p>Köszönjük a rendelésed! Az alábbiakban találod a rendelés részleteit:</p>
            <p><strong>Rendelés ID:</strong> {$orderDetails['id']}</p>
            <p><strong>Összeg:</strong> {$orderDetails['total']} Ft</p>
            <p><strong>Szállítási cím:</strong> {$orderDetails['address']}</p>
            <p>Üdvözlettel,<br>Webshop Csapata</p>
        ";

        if ($mail->send()) {
            return "✅ Email sikeresen elküldve!";
        } else {
            return "❌ Sikertelen küldés: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        return "Hiba történt: " . $mail->ErrorInfo;
    }
}

// Teszt küldés
$orderDetails = [
    'id' => 12345,
    'total' => 9990,
    'address' => 'Budapest, Petőfi S. utca 10.'
];

echo sendOrderConfirmation('13c-halasi@ipari.vein.hu', $orderDetails);
?>
