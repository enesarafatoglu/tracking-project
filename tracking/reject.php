<?php
$servername = "localhost";
$username = "root"; // Veritabanı kullanıcı adınız
$password = ""; // Veritabanı şifreniz
$dbname = "takip"; // Kullandığınız veritabanının adı

// Veritabanı bağlantısı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol etme
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

$talepID = $_GET["id"];

// Talebi reddetme ve silme
$sql = "DELETE FROM izintalep WHERE TalepID = $talepID";
if ($conn->query($sql) === TRUE) {
    // Talep reddedildi ve silindi
    header("Location: izintalep.php");
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

