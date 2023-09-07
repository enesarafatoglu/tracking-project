<?php
// Veri tabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "takip";

try {
    // PDO ile veri tabanına bağlanma
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Hata raporlamayı etkinleştirme
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POST isteğiyle gelen verileri alın
    $mail = $_POST['mail'];
    $sifre = $_POST['sifre'];

    // Kullanıcıyı veritabanından sorgulama
    $stmt = $conn->prepare("SELECT * FROM personel WHERE mail = :mail AND sifre = :sifre");
    $stmt->bindParam(':mail', $mail);
    $stmt->bindParam(':sifre', $sifre);
    $stmt->execute();

    // Kullanıcı bilgileri doğruysa oturum başlat ve ana sayfaya yönlendir
    if ($stmt->rowCount() == 1) {
        session_start();
        $_SESSION['mail'] = $mail;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $yetki = $row['YetkiID'];
        switch ($yetki) {
            case 1:
                header("Location: ana_sayfa.php");
                break;
            case 2:
                header("Location: ana_sayfa2.php");
                break;
            case 3:
                header("Location: ana_sayfa3.php");
                break;
            default:
                header("Location: index.html");
                break;
        }
    } else {
        // Kullanıcı bilgileri yanlış, giriş sayfasına geri yönlendir
        header("Location: index.html");
    }
} catch(PDOException $e) {
    die("Veritabanına bağlanılamadı: " . $e->getMessage());
}

$conn = null; // Bağlantıyı kapat
?>
