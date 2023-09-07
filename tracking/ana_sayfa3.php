<?php
// Önceki sayfada başlatılan oturumu devam ettir
session_start();

// Kullanıcının oturumu yoksa, giriş sayfasına yönlendir
if (!isset($_SESSION['mail'])) {
    header("Location: index.html");
    exit();
}

// Veritabanı bağlantı bilgilerini burada değiştirin
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "takip";

try {
    // PDO ile veritabanına bağlanma
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Hata raporlamayı etkinleştir
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Kullanıcının bilgilerini veritabanından çekme
    $mail = $_SESSION['mail'];
    $stmt = $conn->prepare("SELECT * FROM personel WHERE mail = :mail");
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $loggedInPersonelID = $user['PersonelID'];

} catch(PDOException $e) {
    die("Veritabanına bağlanılamadı: " . $e->getMessage());
}

$conn = null; // Bağlantıyı kapat
$_SESSION['loggedInPersonelID'] = $loggedInPersonelID;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hoşgeldiniz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }

        h1 {
            color: #007bff;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            display: block;
            margin: 20px auto;
            color: #fff;
            background-color: #007bff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 5px;
            width: 100px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Merhaba, CEO <?php echo $user['Ad'] . ' ' . $user['Soyad']; ?></h1>
    <table>
        <tr>
            <th>Personel ID:</th>
            <td><?php echo $user['PersonelID']; ?></td>
        </tr>
        <tr>
            <th>Mail Adresiniz:</th>
            <td><?php echo $user['mail']; ?></td>
        </tr>
        <tr>
            <th>Telefon Numaraniz:</th>
            <td><?php echo $user['TelefonNo']; ?></td>
        </tr>
        <tr>
            <th>Kimlik No:</th>
            <td><?php echo $user['KimlikNo']; ?></td>
        </tr>
        <tr>
            <th>Basladigi Tarih:</th>
            <td><?php echo $user['BasladigiTarih']; ?></td>
        </tr>
        <tr>
            <th>Izin Hakkiniz:</th>
            <td><?php echo $user['IzinHakki']; ?></td>
        </tr>
    </table>
    <a href="personel_goruntule.php">Personel Görüntüle</a>
    <a href="cikis.php" style="background-color: #ff0000;"
           onmouseover="this.style.backgroundColor='#720000';"
           onmouseout="this.style.backgroundColor='#ff0000';">Çıkış Yap</a>
</html>

