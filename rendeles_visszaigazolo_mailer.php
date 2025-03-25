<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

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
        $mail->CharSet = 'UTF-8';

        // Címzett és feladó
        $mail->setFrom($_ENV['SMTP_USER'], 'HaLáli Kft. Webshop');
        $mail->addAddress($toEmail);

        // Tárgy és tartalom
        $mail->Subject = 'Rendelés visszaigazolás';
        $mail->isHTML(true);
        $mail->Body = "
            <h2>Kedves Vásárlónk!</h2>
            <p>Köszönjük megrendelését! Ez egy automatikus visszaigazóló e-mail. Az alábbiakban találja rendelése adatait (további részletes információkat a weboldal rendeléseim részen talál):</p>
            <p><strong>Rendelés azonosítója:</strong> {$orderDetails['id']}</p>
            <p><strong>Összeg:</strong> {$orderDetails['total']} Ft</p>
            <p><strong>Szállítási cím:</strong> {$orderDetails['address']}</p>
            <p><strong>Fizetési mód:</strong> {$orderDetails['fizmod']}</p>
            <p><strong>Fizetési mód:</strong> {$orderDetails['szallitas']}</p><br>
            <p>Üdvözlettel,<br>Halasi Martin, Lálity Dominik</p>
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

//Adatok
$orderDetails = [
    'id' =>  $ID_megrendeles,
    'total' => $vegosszeg,
    'address' => $_SESSION['felhasznalo']['kezbesitesi_iranyitoszam'] . ", " . $_SESSION['felhasznalo']['kezbesitesi_telepules']. ", " . $_SESSION['felhasznalo']['kezbesitesi_utca']. " " . $_SESSION['felhasznalo']['kezbesitesi_hazszam'] . ".",
    'szallitas' => $szallitasi_mod == "standard" ? "Standard" : null,
    'fizmod' => $fizetesi_mod  == "utanvet" ? "Utánvét" : "Bankkártya"
];

sendOrderConfirmation($_SESSION['felhasznalo']['email'], $orderDetails);
?>
