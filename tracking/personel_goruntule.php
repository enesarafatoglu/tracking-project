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

    // Oturum açmış personelin ID'sini al
    $loggedInPersonelID = $_SESSION['loggedInPersonelID'];

    // Tüm personel bilgilerini veritabanından çekme
    $stmt = $conn->prepare("SELECT * FROM personel WHERE PersonelID != :loggedInPersonelID");
    $stmt->bindParam(':loggedInPersonelID', $loggedInPersonelID);
    $stmt->execute();
    $personelList = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Veritabanına bağlanılamadı: " . $e->getMessage());
}

$conn = null; // Bağlantıyı kapat
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personel Görüntüle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }

        h1 {
            color: #007bff;
        }

        /* Add table styles */
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
            width: 150px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Personel Listesi</h1>
    <table>
        <tr>
            <th>Personel ID</th>
            <th>Yetki Seviyesi</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Mail</th>
            <th>Telefon No</th>
            <th>Kimlik No</th>
            <th>Basladigi Tarih</th>
            <th>Izin Hakki</th>
        </tr>
        <?php foreach ($personelList as $personel) { ?>
            <tr>
                <td><?php echo $personel['PersonelID']; ?></td>
                <td><?php echo $personel['YetkiID']; ?></td>
                <td><?php echo $personel['Ad']; ?></td>
                <td><?php echo $personel['Soyad']; ?></td>
                <td><?php echo $personel['mail']; ?></td>
                <td><?php echo $personel['TelefonNo']; ?></td>
                <td><?php echo $personel['KimlikNo']; ?></td>
                <td><?php echo $personel['BasladigiTarih']; ?></td>
                <td><?php echo $personel['IzinHakki']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <a href="ana_sayfa3.php">Ana Sayfa</a>
    <a href="cikis.php" style="background-color: #ff0000;"
           onmouseover="this.style.backgroundColor='#720000';"
           onmouseout="this.style.backgroundColor='#ff0000';">Çıkış Yap</a>
</body>
</html>
