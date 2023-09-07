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
    $loggedInMudurlukID = $user['MudurlukID'];

    // Aynı MudurlukID'ye sahip diğer personelleri çekme
    $stmt = $conn->prepare("SELECT * FROM personel WHERE MudurlukID = :mudurlukID AND PersonelID != :personelID");
    $stmt->bindParam(':mudurlukID', $loggedInMudurlukID);
    $stmt->bindParam(':personelID', $loggedInPersonelID);
    $stmt->execute();
    $relatedPersonel = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Veritabanına bağlanılamadı: " . $e->getMessage());
}

$conn = null; // Bağlantıyı kapat
$_SESSION['loggedInPersonelID'] = $loggedInPersonelID;
$_SESSION['loggedInMudurlukID'] = $loggedInMudurlukID;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personel İşlemleri</title>
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
    <h1>Personel İşlemleri - Hoşgeldiniz, <?php echo $user['Ad'] . ' ' . $user['Soyad']; ?></h1>
    <h2>Aynı Mudurlukta Bulunan Diğer Personeller:</h2>
    <?php if (count($relatedPersonel) > 0): ?>
        <table>
            <tr>
                <th>Personel ID</th>
                <th>Müdürlük ID</th>
                <th>Ad Soyad</th>
                <th>Mail</th>
                <th>Telefon No</th>
                <th>Kimlik No</th>
                <th>Başladığı Tarih</th>
                <th>İzin Hakkı</th>
            </tr>
            <?php foreach ($relatedPersonel as $person): ?>
                <tr>
                    <td><?php echo $person['PersonelID']; ?></td>
                    <td><?php echo $person['MudurlukID']; ?></td>
                    <td><?php echo $person['Ad'] . ' ' . $person['Soyad']; ?></td>
                    <td><?php echo $person['mail']; ?></td>
                    <td><?php echo $person['TelefonNo']; ?></td>
                    <td><?php echo $person['KimlikNo']; ?></td>
                    <td><?php echo $person['BasladigiTarih']; ?></td>
                    <td><?php echo $person['IzinHakki']; ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aynı Mudurlukta başka personel bulunamadı.</p>
    <?php endif; ?>
    <a href="ana_sayfa2.php">Ana Sayfa</a>
    <a href="cikis.php" style="background-color: #ff0000;"
           onmouseover="this.style.backgroundColor='#720000';"
           onmouseout="this.style.backgroundColor='#ff0000';">Çıkış Yap</a>
</body>
</html>
