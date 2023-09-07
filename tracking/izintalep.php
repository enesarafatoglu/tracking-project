<!DOCTYPE html>
<html>
<head>
    <title>Izin Talepleri</title>
    <style>
         body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        a {
            display: inline-block;
            margin: 20px 10px;
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
<div class="container">
    <h1>Izin Talepleri</h1>
    <?php
    session_start();

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

    // Get MudurlukID from the session
    $loggedInMudurlukID = $_SESSION['loggedInMudurlukID'];

    // Onay durumu 0 olan izin taleplerini ve belirli MudurlukID'ye sahip olanları seçme
    $sql = "SELECT * FROM izintalep WHERE Onay = 0 AND MudurlukID = $loggedInMudurlukID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Talep ID: " . $row["TalepID"] . "<br>";
            echo "Personel ID: " . $row["PersonelID"] . "<br>";
            echo "Mudurluk ID: " . $row["MudurlukID"] . "<br>";
            echo "Izin Turu ID: " . $row["IzinturuID"] . "<br>";
            echo "Izin Başlangıç: " . $row["IzinBaslangic"] . "<br>";
            echo "Izin Bitiş: " . $row["IzinBitis"] . "<br>";
    
            // Personel adı ve soyadını çekme
            $personelID = $row["PersonelID"];
            $personelQuery = "SELECT Ad, Soyad FROM personel WHERE PersonelID = '$personelID'";
            $personelResult = $conn->query($personelQuery);
            $personelData = $personelResult->fetch_assoc();
    
            if ($personelData) {
                echo "Personel Adı: " . $personelData["Ad"] . "<br>";
                echo "Personel Soyadı: " . $personelData["Soyad"] . "<br>";
            }
    
            // Onaylama ve reddetme bağlantıları
            echo "<a href='approve.php?id=" . $row["TalepID"] . "'>Onayla</a> | ";
            echo "<a href='reject.php?id=" . $row["TalepID"] . "'>Reddet</a><br><br>";
        }
    } else {
        echo "Onay bekleyen izin talebi bulunmuyor.";
    }


    $conn->close();
    ?>
    <a href="ana_sayfa2.php">Ana Sayfa</a>
</div>
</body>
</html>
